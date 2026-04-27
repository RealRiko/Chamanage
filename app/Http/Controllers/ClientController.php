<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

// Klientu CRUD un tiešā meklēšana pēc uzņēmuma.
class ClientController extends Controller
{
    // Autentifikācija obligāta visām metodēm
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Klientu saraksts ar opcionālu meklēšanu pēc vārda/e-pasta
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            Log::warning("User ID {$user->id} attempted to access clients without a company.");

            return redirect()->route('company.required')->with('error', 'You must belong to a company.');
        }

        $clients = Client::where('company_id', $company->id)
            ->when(request('search'), function ($query, $search) {
                $query->searchByNameOrEmailPrefix(trim((string) $search));
            })
            ->with('creator:id,name,surname')
            ->latest()
            ->get();

        return view('clients.index', compact('clients'));
    }

    // AJAX: klientu ieteikumi dzīvajai meklēšanai
    public function liveSearch(Request $request)
    {
        $company = auth()->user()?->company;
        $q = trim((string) $request->query('query', ''));
        if ($q === '' || ! $company) {
            return response()->json([]);
        }

        $table = (new Client)->getTable();

        return response()->json(
            Client::query()
                ->where($table.'.company_id', $company->id)
                ->searchByNameOrEmailPrefix($q)
                ->with('creator:id,name,surname')
                ->orderByRaw(
                    'CASE WHEN `'.$table.'`.`name` = ? THEN 100 WHEN `'.$table.'`.`name` LIKE ? THEN 90 ELSE 80 END DESC',
                    [$q, $q.'%']
                )
                ->limit(200)
                ->get()
        );
    }

    // Jauna klienta forma
    public function create()
    {
        $company = auth()->user()->company;

        if (! $company) {
            Log::warning('User ID '.auth()->id().' tried to access clients.create without company.');

            return redirect()->route('company.required')->with('error', 'Please create or join a company first.');
        }

        return view('clients.create');
    }

    // Saglabā jaunu klientu uzņēmumam
    public function store(Request $request)
    {
        $company = auth()->user()->company;

        if (! $company) {
            Log::warning('User ID '.auth()->id().' tried to store a client without company.');

            return redirect()->route('company.required')->with('error', 'Please join or create a company first.');
        }

        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => $this->nullIfEmpty($request->input('phone')),
            'address' => $this->nullIfEmpty($request->input('address')),
            'city' => $this->nullIfEmpty($request->input('city')),
            'postal_code' => $this->nullIfEmpty($request->input('postal_code')),
            'registration_number' => $this->nullIfEmpty($request->input('registration_number')),
            'vat_number' => $this->nullIfEmpty($request->input('vat_number')),
            'bank' => $this->nullIfEmpty($request->input('bank')),
            'bank_account' => $this->nullIfEmpty($request->input('bank_account')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email:rfc',
                Rule::unique('clients', 'email')->where(fn ($q) => $q->where('company_id', $company->id)),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'registration_number' => ['nullable', 'string', 'max:100'],
            'vat_number' => ['nullable', 'string', 'max:100'],
            'bank' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['company_id'] = $company->id;
        $validated['created_by_user_id'] = auth()->id();

        $client = Client::create($validated);

        Log::info('Client created successfully', [
            'client_id' => $client->id,
            'company_id' => $company->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    // Klienta labošanas forma
    public function edit(Client $client)
    {
        $this->authorizeClientAccess($client);

        return view('clients.edit', compact('client'));
    }

    // Atjauno klienta datus
    public function update(Request $request, Client $client)
    {
        $this->authorizeClientAccess($client);

        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => $this->nullIfEmpty($request->input('phone')),
            'address' => $this->nullIfEmpty($request->input('address')),
            'city' => $this->nullIfEmpty($request->input('city')),
            'postal_code' => $this->nullIfEmpty($request->input('postal_code')),
            'registration_number' => $this->nullIfEmpty($request->input('registration_number')),
            'vat_number' => $this->nullIfEmpty($request->input('vat_number')),
            'bank' => $this->nullIfEmpty($request->input('bank')),
            'bank_account' => $this->nullIfEmpty($request->input('bank_account')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email:rfc',
                Rule::unique('clients', 'email')
                    ->where(fn ($q) => $q->where('company_id', $client->company_id))
                    ->ignore($client->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'registration_number' => ['nullable', 'string', 'max:100'],
            'vat_number' => ['nullable', 'string', 'max:100'],
            'bank' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
        ]);

        $client->update($validated);

        Log::info('Client updated successfully', [
            'client_id' => $client->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    // Dzēš klientu (tikai savam uzņēmumam)
    public function destroy(Client $client)
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('clients.index')->with('error', 'You are not assigned to a company.');
        }

        if ($client->company_id !== $company->id) {
            return redirect()->route('clients.index')->with('error', 'You do not have permission to delete this client.');
        }

        // Saglabā klienta nosaukumu dokumentos, lai pēc klienta dzēšanas neparādās N/A.
        Document::query()
            ->where('company_id', $company->id)
            ->where('client_id', $client->id)
            ->update([
                'client_name_snapshot' => $client->name,
            ]);

        Log::info("Client ID {$client->id} deleted by user ID {$user->id}");

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    // Pārbauda, vai klients pieder lietotāja uzņēmumam
    protected function authorizeClientAccess(Client $client)
    {
        $user = auth()->user();
        if (! $user->company || $client->company_id !== $user->company->id) {
            Log::error("User {$user->id} attempted unauthorized access to client {$client->id}");
            abort(403, 'Unauthorized action.');
        }
    }

    private function nullIfEmpty(mixed $value): ?string
    {
        $trimmed = trim((string) ($value ?? ''));
        return $trimmed === '' ? null : $trimmed;
    }
}
