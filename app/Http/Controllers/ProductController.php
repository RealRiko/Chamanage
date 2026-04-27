<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

// Preču katalogs (cenas, apraksts); noliktavas daudzums tiek vadīts atsevišķi noliktavas sadaļā.
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Preču saraksts ar meklēšanu pēc nosaukuma/kategorijas
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'You must create or join a company first.');
        }

        $search = trim((string) $request->query('search', ''));

        $products = Product::query()
            ->where('company_id', $company->id)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $catalogTotal = Product::where('company_id', $company->id)->count();

        return view('products.index', compact('products', 'search', 'catalogTotal'));
    }

    // Jaunas preces forma
    public function create()
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        return view('products.create', compact('company'));
    }

    // Izveido preci un inicializē noliktavas ierakstu ar 0
    public function store(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('dashboard')->with('error', 'Please set up your company first.');
        }

        $request->merge([
            'name' => trim((string) $request->input('name')),
            'description' => $this->nullIfEmpty($request->input('description')),
            'category' => $this->nullIfEmpty($request->input('category')),
        ]);

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->where(fn ($q) => $q->where('company_id', $company->id)),
            ],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:255'],
        ];
        if (Schema::hasColumn('products', 'cost_price')) {
            $rules['cost_price'] = ['nullable', 'numeric', 'min:0', 'decimal:0,2', 'lte:price'];
        }
        $validated = $request->validate($rules, [
            'cost_price.lte' => __('form.product.cost_price_max'),
        ]);
        if (Schema::hasColumn('products', 'cost_price')) {
            $validated['cost_price'] = $validated['cost_price'] ?? 0;
        } else {
            unset($validated['cost_price']);
        }

        $validated['company_id'] = $company->id;

        $product = Product::create($validated);

        Inventory::create([
            'product_id' => $product->id,
            'company_id' => $company->id,
            'quantity' => 0,
        ]);

        Log::info('Product definition created successfully and inventory initialized', [
            'product_id' => $product->id,
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully. You can manage its stock in the Storage section.');
    }

    // Preces labošanas forma
    public function edit(Product $product)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company || $product->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        return view('products.edit', compact('product'));
    }

    // Atjauno preces rekvizītus (ne atlikumu — tas noliktavā)
    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company || $product->company_id !== $company->id) {
            return redirect()->route('dashboard')->with('error', 'Permission denied.');
        }

        $request->merge([
            'name' => trim((string) $request->input('name')),
            'description' => $this->nullIfEmpty($request->input('description')),
            'category' => $this->nullIfEmpty($request->input('category')),
        ]);

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')
                    ->where(fn ($q) => $q->where('company_id', $company->id))
                    ->ignore($product->id),
            ],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:255'],
        ];
        if (Schema::hasColumn('products', 'cost_price')) {
            $rules['cost_price'] = ['nullable', 'numeric', 'min:0', 'decimal:0,2', 'lte:price'];
        }
        $validated = $request->validate($rules, [
            'cost_price.lte' => __('form.product.cost_price_max'),
        ]);
        if (Schema::hasColumn('products', 'cost_price')) {
            $validated['cost_price'] = $validated['cost_price'] ?? 0;
        } else {
            unset($validated['cost_price']);
        }

        $product->update($validated);

        Log::info('Product definition updated successfully', [
            'product_id' => $product->id,
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Dzēš preci (tikai savam uzņēmumam)
    public function destroy(Product $product)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('products.index')->with('error', 'You are not assigned to a company.');
        }

        if ($product->company_id !== $company->id) {
            return redirect()->route('products.index')->with('error', 'You do not have permission to delete this product.');
        }

        Log::info("Product ID {$product->id} ('{$product->name}') deleted by user ID {$user->id}");

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function nullIfEmpty(mixed $value): ?string
    {
        $trimmed = trim((string) ($value ?? ''));
        return $trimmed === '' ? null : $trimmed;
    }
}
