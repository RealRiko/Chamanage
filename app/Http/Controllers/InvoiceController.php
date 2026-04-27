<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

// Pārdošanas rēķinu saraksts un detaļu skats (dokumenti ar type = sales_invoice).
class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Rēķinu saraksts ar filtriem un kopsummām (apmaksāts / gaida)
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('dashboard')->with('error', 'No company assigned.');
        }

        // Filtru validācija pasargā no nekorektiem query parametriem un saglabā stabilu UX.
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'client_id' => [
                'nullable',
                'integer',
                Rule::exists('clients', 'id')->where('company_id', $company->id),
            ],
            'status' => 'nullable|in:waiting_payment,paid',
        ]);

        $validated['search'] = isset($validated['search'])
            ? trim((string) $validated['search'])
            : null;

        // Invoice skatā strādājam tikai ar sales_invoice tipa dokumentiem.
        $query = Document::where('type', 'sales_invoice')
            ->where('company_id', $company->id)
            ->with(['client', 'lineItems.product']);

        if (! empty($validated['search'])) {
            $s = '%'.$validated['search'].'%';
            $query->where(function ($q) use ($s) {
                $q->where('id', 'like', $s)
                    ->orWhereHas('client', fn ($c) => $c->where('name', 'like', $s));
            });
        }
        if (! empty($validated['date_from'])) {
            $query->whereDate('invoice_date', '>=', $validated['date_from']);
        }
        if (! empty($validated['date_to'])) {
            $query->whereDate('invoice_date', '<=', $validated['date_to']);
        }
        if (! empty($validated['client_id'])) {
            $query->where('client_id', $validated['client_id']);
        }
        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $invoices = $query->orderByDesc('invoice_date')->orderByDesc('id')->paginate(20)->withQueryString();

        $clients = Client::where('company_id', $company->id)->orderBy('name')->get(['id', 'name']);

        $paidSum = (clone $query)->where('status', 'paid')->sum('total');
        $waitingSum = (clone $query)->where('status', 'waiting_payment')->sum('total');

        return view('invoices.index', compact('invoices', 'clients', 'paidSum', 'waitingSum'));
    }

    // Viena rēķina detaļas (tā pati dokumenta struktūra kā show)
    public function show($id)
    {
        Log::info("InvoiceController@show accessed for ID: {$id} by user ID: ".auth()->id());

        $company = auth()->user()->company;
        if (! $company) {
            Log::warning('User ID '.auth()->id().' attempted to view invoice with no assigned company.');

            return redirect()->route('dashboard')->with('error', 'No company assigned.');
        }

        $invoice = Document::where('type', 'sales_invoice')
            ->where('company_id', $company->id)
            ->with(['client', 'lineItems.product'])
            ->findOrFail($id);

        return view('invoices.show', [
            'document' => $invoice,
            'documentListRoute' => route('invoices.index'),
        ]);
    }
}

