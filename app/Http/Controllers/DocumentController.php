<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Document;
use App\Models\Product;
use App\Models\Inventory;
use App\Support\Vat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

// Dokumentu pārvaldība: saraksts, izveide, labošana, dzēšana, PDF, noliktavas korekcijas pēc pārdošanas dokumentiem.
class DocumentController extends Controller
{
    // Konstruktors — nodrošina, ka visām šīs kontroliera metodēm jābūt autentificētām
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Rāda dokumentu sarakstu uzņēmumam, kuram pieder pieteikušais lietotājs
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'No company assigned.');
        }

        $validated = $request->validate([
            'search'    => 'nullable|string|max:255',
            'date_from' => 'nullable|date',
            'date_to'   => 'nullable|date|after_or_equal:date_from',
            'client_id' => [
                'nullable',
                'integer',
                Rule::exists('clients', 'id')->where('company_id', $company->id),
            ],
            'status' => 'nullable|in:draft,sent,confirmed,cancelled,waiting_payment,paid',
            'type'   => 'nullable|in:estimate,sales_order,sales_invoice',
        ]);

        $query = Document::where('company_id', $company->id)
            ->with(['client', 'lineItems.product', 'creator:id,name,surname']);

        if (!empty($validated['search'])) {
            $s = '%' . $validated['search'] . '%';
            $query->where(function ($q) use ($s) {
                $q->where('type', 'like', $s)
                    ->orWhere('status', 'like', $s)
                    ->orWhereHas('client', fn ($c) => $c->where('name', 'like', $s));
            });
        }

        if (!empty($validated['date_from'])) {
            $query->whereDate('invoice_date', '>=', $validated['date_from']);
        }

        if (!empty($validated['date_to'])) {
            $query->whereDate('invoice_date', '<=', $validated['date_to']);
        }

        if (!empty($validated['client_id'])) {
            $query->where('client_id', $validated['client_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        $documents = $query->latest()->paginate(20)->withQueryString();
        $clients   = Client::where('company_id', $company->id)->orderBy('name')->get(['id', 'name']);

        return view('documents.index', compact('documents', 'clients'));
    }

    // Parāda formu jaunam dokumentam
    public function create()
    {
        $user    = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        $clients       = Client::where('company_id', $company->id)->select('id', 'name')->get();
        $productSelect = ['id', 'name', 'price'];

        if (Schema::hasColumn('products', 'cost_price')) {
            $productSelect[] = 'cost_price';
        }

        $products = Product::where('company_id', $company->id)
            ->with('inventory')
            ->select($productSelect)
            ->get()
            ->map(function ($product) {
                $product->stock = $product->inventory->quantity ?? 0;
                return $product;
            });

        return view('documents.create', compact('clients', 'products', 'company'));
    }

    // Atver "izveidot jaunu" formu ar esošā dokumenta datu kopiju (bez saglabāšanas)
    public function copy(Document $document)
    {
        $user    = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        if ($document->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        $sourceDocument = $document->load('lineItems');
        $clients        = Client::where('company_id', $company->id)->select('id', 'name')->get();
        $productSelect  = ['id', 'name', 'price'];

        if (Schema::hasColumn('products', 'cost_price')) {
            $productSelect[] = 'cost_price';
        }

        $products = Product::where('company_id', $company->id)
            ->with('inventory')
            ->select($productSelect)
            ->get()
            ->map(function ($product) {
                $product->stock = $product->inventory->quantity ?? 0;
                return $product;
            });

        return view('documents.create', compact('clients', 'products', 'company', 'sourceDocument'));
    }

    // Saglabā jaunu dokumentu un attiecīgi koriģē noliktavas atlikumus, ja nepieciešams
    public function store(Request $request)
    {
        $user    = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('dashboard')->with('error', 'Please join or create a company first.');
        }

        // 1. solis: validē tikai type, lai droši noteiktu atļautos statusus
        $request->validate([
            'type' => 'bail|required|in:estimate,sales_order,sales_invoice',
        ]);

        $type           = $request->input('type');
        $allowedStatuses = match ($type) {
            'estimate'      => ['draft', 'sent'],
            'sales_order'   => ['draft', 'confirmed', 'cancelled'],
            'sales_invoice' => ['waiting_payment', 'paid'],
            default         => [],
        };

        // 2. solis: pilnā validācija ar dinamiski noteiktajiem statusiem
        $validated = $request->validate([
            'type'      => 'bail|required|in:estimate,sales_order,sales_invoice',
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')->where('company_id', $company->id),
            ],
            'invoice_date'  => 'required|date_format:Y-m-d',
            'delivery_days' => 'nullable|integer|min:0|max:3650',
            'status'        => ['required', Rule::in($allowedStatuses)],
            'apply_vat'     => 'nullable|boolean',
            'line_items'    => 'required|array|min:1|max:500',
            'line_items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('products', 'id')->where('company_id', $company->id),
            ],
            'line_items.*.quantity' => 'required|integer|min:1|max:999999',
            'line_items.*.price'    => 'required|numeric|min:0|decimal:0,2',
        ]);

        if (Schema::hasColumn('documents', 'apply_vat')) {
            $validated['apply_vat'] = $request->boolean('apply_vat');
        } else {
            unset($validated['apply_vat']);
        }

        $vatMultiplier = Vat::multiplierForCountry($company->country);

        $client = Client::where('company_id', $company->id)
            ->findOrFail($validated['client_id']);

        $total         = 0;
        $lineItemsData = [];

        foreach ($validated['line_items'] as $item) {
            $unitPriceNet    = (float) $item['price'];
            $storedUnitPrice = !empty($validated['apply_vat'])
                ? round($unitPriceNet * $vatMultiplier, 2)
                : $unitPriceNet;
            $subtotal = $item['quantity'] * $storedUnitPrice;
            $total   += $subtotal;

            $lineItemsData[] = [
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $storedUnitPrice,
                'subtotal'   => $subtotal,
            ];
        }

        $deliveryDays = (int) ($validated['delivery_days'] ?? 0);
        $invoiceDate  = Carbon::createFromFormat('Y-m-d', $validated['invoice_date']);
        $dueDate      = $invoiceDate->copy()->addDays($deliveryDays);

        // Visu DB darbu veic vienā transakcijā — ja kāds solis neizdodas, viss tiek atcelts
        DB::transaction(function () use ($validated, $company, $user, $client, $lineItemsData, $total, $dueDate, $deliveryDays) {
            $document = Document::create(array_merge($validated, [
                'due_date'              => $dueDate,
                'total'                 => $total,
                'company_id'            => $company->id,
                'created_by_user_id'    => $user->id,
                'client_name_snapshot'  => $client->name,
                'delivery_days'         => $deliveryDays,
            ]));

            $document->lineItems()->createMany($lineItemsData);

            if (in_array($validated['type'], ['sales_order', 'sales_invoice'])) {
                $this->handleInventoryAdjustment($lineItemsData, $company->id, 'decrement');
            }
        });

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }

    // Parāda rediģēšanas lapu dokumentam
    public function edit(Document $document)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        if ($document->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        $clients       = Client::where('company_id', $company->id)->select('id', 'name')->get();
        $productSelect = ['id', 'name', 'price'];

        if (Schema::hasColumn('products', 'cost_price')) {
            $productSelect[] = 'cost_price';
        }

        $products = Product::where('company_id', $company->id)
            ->with('inventory')
            ->select($productSelect)
            ->get()
            ->map(function ($product) {
                $product->stock = $product->inventory->quantity ?? 0;
                return $product;
            });

        return view('documents.edit', compact('document', 'clients', 'products'));
    }

    // Atjaunina esošu dokumentu; atjauno noliktavu (atgriež veco daudzumu, tad pielieto jauno)
    public function update(Request $request, Document $document)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        if ($document->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        // 1. solis: validē tikai type, lai droši noteiktu atļautos statusus
        $request->validate([
            'type' => 'bail|required|in:estimate,sales_order,sales_invoice',
        ]);

        $type            = $request->input('type');
        $allowedStatuses = match ($type) {
            'estimate'      => ['draft', 'sent'],
            'sales_order'   => ['draft', 'confirmed', 'cancelled'],
            'sales_invoice' => ['waiting_payment', 'paid'],
            default         => [],
        };

        // 2. solis: pilnā validācija
        $validated = $request->validate([
            'type'      => 'bail|required|in:estimate,sales_order,sales_invoice',
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')->where('company_id', $document->company_id),
            ],
            'invoice_date'  => 'required|date_format:Y-m-d',
            'delivery_days' => 'nullable|integer|min:0|max:3650',
            'status'        => ['required', Rule::in($allowedStatuses)],
            'apply_vat'     => 'nullable|boolean',
            'line_items'    => 'required|array|min:1|max:500',
            'line_items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('products', 'id')->where('company_id', $document->company_id),
            ],
            'line_items.*.quantity' => 'required|integer|min:1|max:999999',
            'line_items.*.price'    => 'required|numeric|min:0|decimal:0,2',
        ]);

        if (Schema::hasColumn('documents', 'apply_vat')) {
            $validated['apply_vat'] = $request->boolean('apply_vat');
        } else {
            unset($validated['apply_vat']);
        }

        $companyId     = $document->company_id;
        $vatMultiplier = Vat::multiplierForCountry(auth()->user()?->company?->country);

        $client = Client::where('company_id', $companyId)
            ->findOrFail($validated['client_id']);

        $total         = 0;
        $lineItemsData = [];

        foreach ($validated['line_items'] as $item) {
            $unitPriceNet    = (float) $item['price'];
            $storedUnitPrice = !empty($validated['apply_vat'])
                ? round($unitPriceNet * $vatMultiplier, 2)
                : $unitPriceNet;
            $subtotal = $item['quantity'] * $storedUnitPrice;
            $total   += $subtotal;

            $lineItemsData[] = [
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $storedUnitPrice,
                'subtotal'   => $subtotal,
            ];
        }

        $deliveryDays = (int) ($validated['delivery_days'] ?? 0);
        $invoiceDate  = Carbon::createFromFormat('Y-m-d', $validated['invoice_date']);
        $dueDate      = $invoiceDate->copy()->addDays($deliveryDays);

        // Visu DB darbu veic vienā transakcijā — noliktavas atjaunošana ir atomiska
        DB::transaction(function () use ($document, $validated, $companyId, $client, $lineItemsData, $total, $dueDate, $deliveryDays) {
            // Atgriež vecās rindas noliktavā pirms jebkādām izmaiņām
            if (in_array($document->type, ['sales_order', 'sales_invoice'])) {
                $oldLineItems = $document->lineItems()->select('product_id', 'quantity')->get()->toArray();
                $this->handleInventoryAdjustment($oldLineItems, $companyId, 'increment');
            }

            $document->update(array_merge($validated, [
                'due_date'             => $dueDate,
                'total'                => $total,
                'client_name_snapshot' => $client->name,
                'delivery_days'        => $deliveryDays,
            ]));

            $document->lineItems()->delete();
            $document->lineItems()->createMany($lineItemsData);

            if (in_array($validated['type'], ['sales_order', 'sales_invoice'])) {
                $this->handleInventoryAdjustment($lineItemsData, $companyId, 'decrement');
            }
        });

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    // Dzēš dokumentu — atjauno noliktavas atlikumus, ja dokuments bija pārdošanas raksturs
    public function destroy(Document $document)
    {
        $user    = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('documents.index')->with('error', 'You are not assigned to a company.');
        }

        if ($document->company_id !== $company->id) {
            return redirect()->route('documents.index')->with('error', 'You do not have permission to delete this document.');
        }

        DB::transaction(function () use ($document, $company, $user) {
            // Atgriež noliktavā, izmantojot to pašu metodi kā store/update — konsekventa loģika
            if (in_array($document->type, ['sales_order', 'sales_invoice'])) {
                $lineItems = $document->lineItems()->select('product_id', 'quantity')->get()->toArray();
                $this->handleInventoryAdjustment($lineItems, $company->id, 'increment');
            }

            Log::info("Document ID {$document->id} (Type: {$document->type}) deleted by user ID {$user->id}");

            $document->delete();
        });

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document deleted successfully and stock restored.');
    }

    // Ģenerē PDF no dokumenta datiem un uzņēmuma logotipa (ja ir)
    public function generatePdf(Document $document)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        if ($document->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        $document->load(['client', 'lineItems.product']);
        $company = $document->company;

        $logoBase64 = null;
        if ($company && $company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
            $logoData   = Storage::disk('public')->get($company->logo_path);
            $logoType   = pathinfo($company->logo_path, PATHINFO_EXTENSION);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $prevLocale = App::getLocale();
        App::setLocale('lv');

        try {
            $pdf        = Pdf::loadView('pdf.document', compact('document', 'logoBase64', 'company'), [], 'UTF-8');
            $typeLabel  = __('pdf.document.types.' . $document->type);
            $clientSlug = Str::slug($document->client?->name ?: 'klients', '-');

            if ($clientSlug === '') {
                $clientSlug = 'klients';
            }

            $dateSlug = $document->invoice_date?->format('Y-m-d') ?? 'bez-datuma';
            $baseSlug = Str::slug($typeLabel, '-');

            if ($baseSlug === '') {
                $baseSlug = 'dokuments';
            }

            $filename = "{$baseSlug}_{$clientSlug}_{$dateSlug}_{$document->id}.pdf";

            if (strlen($filename) > 180) {
                $filename = "{$baseSlug}_{$dateSlug}_{$document->id}.pdf";
            }

            return $pdf->download($filename);
        } finally {
            App::setLocale($prevLocale);
        }
    }

    // Rāda konkrēta dokumenta detaļas
    public function show($id)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        $document = Document::where('company_id', $company->id)
            ->with(['client', 'lineItems.product'])
            ->findOrFail($id);

        return view('documents.show', compact('document'));
    }

    // Privāta funkcija noliktavas korekcijai — increment vai decrement ar DB lock, lai izvairītos no race conditions
    private function handleInventoryAdjustment(array $lineItemsData, int $companyId, string $action): void
    {
        foreach ($lineItemsData as $item) {
            if (!isset($item['product_id'], $item['quantity'])) {
                continue;
            }

            $productId = (int) $item['product_id'];
            $quantity  = (int) $item['quantity'];

            // firstOrCreate + lockForUpdate novērš race condition vairāku pieprasījumu gadījumā
            $inventory = Inventory::firstOrCreate(
                ['product_id' => $productId, 'company_id' => $companyId],
                ['quantity' => 0]
            );

            // Atkārtoti nolasām ar lock, lai iegūtu aktuālo vērtību
            $inventory = Inventory::where('id', $inventory->id)->lockForUpdate()->first();

            if ($action === 'decrement') {
                $currentQty = (int) $inventory->quantity;
                $newQty     = max(0, $currentQty - $quantity);

                if ($currentQty < $quantity) {
                    Log::warning("Inventory decrement clamped at zero for Product ID {$productId}", [
                        'company_id'          => $companyId,
                        'current_quantity'    => $currentQty,
                        'requested_decrement' => $quantity,
                    ]);
                }

                $inventory->update(['quantity' => $newQty]);
                Log::info("Inventory decrement: {$quantity} units for Product ID {$productId}. New qty: {$newQty}");

            } elseif ($action === 'increment') {
                $inventory->increment('quantity', $quantity);
                Log::info("Inventory increment: {$quantity} units for Product ID {$productId}. New qty: " . ($inventory->quantity + $quantity));
            }
        }
    }
}
