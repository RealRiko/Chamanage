<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Noliktava: preču atlikumu pārskats un masveida atjaunināšana.
class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Noliktavas lapa — produkti ar pašreizējo daudzumu
    public function index()
    {
        $company = auth()->user()->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'You must create or join a company first.');
        }

        $search = request('search');

        $products = Product::where('company_id', $company->id)
            ->with('inventory')
            ->when($search, function ($query, $s) {
                $query->where(function ($q) use ($s) {
                    $q->where('name', 'like', '%'.$s.'%')
                        ->orWhere('category', 'like', '%'.$s.'%');
                });
            })
            ->latest()
            ->get();

        return view('inventory.index', compact('products'));
    }

    // Vienā pieprasījumā atjauno vairāku produktu daudzumus (transakcijā)
    public function bulkUpdateQuantities(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'You must create or join a company first.');
        }

        $validated = $request->validate([
            'quantities' => ['required', 'array'],
            'quantities.*' => ['integer', 'min:0'],
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $allowedIds = Product::where('company_id', $company->id)->pluck('id');

        foreach (array_keys($validated['quantities']) as $rawId) {
            $pid = (int) $rawId;
            if (! $allowedIds->contains($pid)) {
                return redirect()
                    ->route('inventory.index', $validated['search'] ? ['search' => $validated['search']] : [])
                    ->with('error', __('page.storage.bulk_error_invalid'));
            }
        }

        DB::transaction(function () use ($validated, $company) {
            foreach ($validated['quantities'] as $productId => $qty) {
                Inventory::updateOrCreate(
                    [
                        'product_id' => (int) $productId,
                        'company_id' => $company->id,
                    ],
                    [
                        'quantity' => (int) $qty,
                    ]
                );
            }
        });

        Log::info('Inventory bulk quantity update', [
            'company_id' => $company->id,
            'user_id' => $user->id,
            'rows' => count($validated['quantities']),
        ]);

        $search = isset($validated['search']) ? trim((string) $validated['search']) : '';

        return redirect()
            ->route('inventory.index', $search !== '' ? ['search' => $search] : [])
            ->with('success', __('page.storage.bulk_success'));
    }
}
