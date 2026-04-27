<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Admina uzņēmuma iestatījumi: mērķis, rekvizīti, logo, dokumentu prefiksi, zema atlikuma brīdinājumi.
class GoalController extends Controller
{
    // Apvienotā admina skata lapa (mērķis + uzņēmuma dati)
    public function companySettingsView()
    {
        $user = auth()->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please create your company first.');
        }

        return view('admin.company_settings', compact('company'));
    }

    // Saglabā uzņēmuma mēneša ieņēmumu mērķi
    public function setGoal(Request $request)
    {
        // Vienkārša robežvalidācija, lai dashboard progress aprēķini vienmēr būtu saprātīgos diapazonos.
        $validated = $request->validate([
            'monthly_goal' => 'required|numeric|min:0|max:99999999',
        ]);

        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please create your company first.');
        }
        $company->update(['monthly_goal' => $validated['monthly_goal']]);

        return back()->with('success', __('page.admin.goal_saved'));
    }

    // Atjauno uzņēmuma rekvizītus un logo
    public function updateCompanyDetails(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please create your company first.');
        }

        // Normalizējam rekvizītu laukus: noņemam whitespace un tukšās vērtības pārvēršam par null.
        $request->merge([
            'company_name' => trim((string) $request->input('company_name')),
            'reg_number' => $this->nullIfEmpty($request->input('reg_number')),
            'address' => $this->nullIfEmpty($request->input('address')),
            'city' => $this->nullIfEmpty($request->input('city')),
            'postal_code' => $this->nullIfEmpty($request->input('postal_code')),
            'bank_name' => $this->nullIfEmpty($request->input('bank_name')),
            'account_number' => $this->nullIfEmpty($request->input('account_number')),
            'vat_number' => $this->nullIfEmpty($request->input('vat_number')),
            'footer_contacts' => $this->nullIfEmpty($request->input('footer_contacts')),
            'document_contact_name' => $this->nullIfEmpty($request->input('document_contact_name')),
            'document_contact_email' => ($email = $this->nullIfEmpty($request->input('document_contact_email'))) !== null
                ? strtolower($email)
                : null,
        ]);

        // Kontaktu/rekvizītu validācija + logo faila tipa/izmēra aizsardzība.
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'footer_contacts' => 'nullable|string|max:500',
            'document_contact_name' => 'nullable|string|max:150',
            'document_contact_email' => 'nullable|email:rfc|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updateData = [
            'name' => $validated['company_name'],
            'registration_number' => $validated['reg_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'vat_number' => $validated['vat_number'] ?? null,
            'footer_contacts' => $validated['footer_contacts'] ?? null,
            'document_contact_name' => $validated['document_contact_name'] ?? null,
            'document_contact_email' => $validated['document_contact_email'] ?? null,
        ];

        // Nomainot logo, vecais fails tiek dzēsts, lai nekrātos "bāreņu" faili storage.
        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $updateData['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($updateData);

        return back()->with('success', __('page.admin.details_saved'));
    }

    // Dokumentu numuru prefiksi (ja kolonnas ir datubāzē)
    public function updateDocumentSettings(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please create your company first.');
        }

        // Prefiksi ir īsi pēc dizaina, lai dokumenta numuri paliek lasāmi.
        $validated = $request->validate([
            'invoice_prefix' => 'nullable|string|max:10',
            'estimate_prefix' => 'nullable|string|max:10',
        ]);

        $company->update([
            'invoice_prefix' => $this->nullIfEmpty($validated['invoice_prefix'] ?? null) ?? 'INV-',
            'estimate_prefix' => $this->nullIfEmpty($validated['estimate_prefix'] ?? null) ?? 'EST-',
        ]);

        return back()->with('success', __('page.admin.document_settings_saved'));
    }

    // Zema atlikuma brīdinājuma slieksnis un ieslēgšana/izslēgšana
    public function updateLowStockNotifications(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('company.required')->with('error', 'Please create your company first.');
        }

        // Slieksnim jābūt >= 1, lai izvairītos no bezjēdzīgiem paziņojumiem.
        $validated = $request->validate([
            'low_stock_threshold' => 'required|integer|min:1|max:999999',
        ]);

        $company->update([
            'low_stock_notify_enabled' => $request->boolean('low_stock_notify_enabled'),
            'low_stock_threshold' => $validated['low_stock_threshold'],
        ]);

        return back()->with('success', __('page.admin.low_stock_saved'));
    }

    private function nullIfEmpty(mixed $value): ?string
    {
        $trimmed = trim((string) ($value ?? ''));
        return $trimmed === '' ? null : $trimmed;
    }
}

