<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

// Darbinieku (uzņēmuma lietotāju) pārvaldība — tikai adminiem.
class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Darbinieku saraksts uzņēmumam
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'You are not assigned to a company.');
        }

        $workers = User::where('company_id', $company->id)->get();

        return view('workers.index', compact('workers', 'company'));
    }

    // Jauna darbinieka forma (izveido uzņēmumu, ja adminam vēl nav)
    public function create()
    {
        $user = auth()->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to create workers.');
        }

        $company = $user->company;

        if (! $company) {
            $company = Company::create([
                'name' => $user->name."'s Company",
                'country' => 'LV',
            ]);

            $user->update([
                'company_id' => $company->id,
                'role' => 'admin',
            ]);

            Log::info("Created company ID {$company->id} for admin user ID {$user->id}");
        }

        return view('workers.create-worker', compact('company'));
    }

    // Izveido lietotāju ar lomu «user» pie admina uzņēmuma
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to create workers.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['name'] = trim($validated['name']);
        $validated['surname'] = trim($validated['surname']);
        $validated['email'] = strtolower(trim($validated['email']));

        $company = $user->company;

        if (! $company) {
            $company = Company::create([
                'name' => $user->name."'s Company",
                'country' => 'LV',
            ]);
            $user->update(['company_id' => $company->id]);
        }

        $worker = User::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company_id' => $company->id,
            'role' => 'user',
        ]);

        Log::info("Worker ID {$worker->id} created for company ID {$company->id} by admin ID {$user->id}");

        return redirect()
            ->route('workers.index')
            ->with('success', 'Worker created successfully and linked to your company.');
    }

    // Darbinieka labošanas forma
    public function edit(User $worker)
    {
        $user = auth()->user();

        if (! $user->isAdmin() || $worker->company_id !== $user->company_id) {
            return redirect()->route('workers.index')->with('error', 'You do not have permission to edit this worker.');
        }

        return view('workers.edit-worker', compact('worker'));
    }

    // Atjauno vārdu, uzvārdu, e-pastu un opcionāli paroli
    public function update(Request $request, User $worker)
    {
        $user = auth()->user();

        if (! $user->isAdmin() || $worker->company_id !== $user->company_id) {
            return redirect()->route('workers.index')->with('error', 'You do not have permission to update this worker.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($worker->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['name'] = trim($validated['name']);
        $validated['surname'] = trim($validated['surname']);
        $validated['email'] = strtolower(trim($validated['email']));

        $worker->name = $validated['name'];
        $worker->surname = $validated['surname'];
        $worker->email = $validated['email'];

        if (! empty($validated['password'])) {
            $worker->password = Hash::make($validated['password']);
        }

        $worker->save();

        Log::info("Worker ID {$worker->id} updated by admin ID {$user->id}");

        return redirect()
            ->route('workers.index')
            ->with('success', 'Worker updated successfully.');
    }

    // Dzēš darbinieku (neļauj dzēst sevi)
    public function destroy(User $worker)
    {
        $user = auth()->user();

        if (! $user->isAdmin()) {
            return redirect()->route('workers.index')->with('error', 'You do not have permission to delete workers.');
        }

        if ($worker->company_id !== $user->company_id) {
            return redirect()->route('workers.index')->with('error', 'You do not have permission to delete this worker.');
        }

        if ($user->id === $worker->id) {
            return redirect()->route('workers.index')->with('error', 'You cannot delete your own account.');
        }

        Log::info("Worker ID {$worker->id} deleted by admin ID {$user->id}");

        $worker->delete();

        return redirect()
            ->route('workers.index')
            ->with('success', 'Worker deleted successfully.');
    }
}
