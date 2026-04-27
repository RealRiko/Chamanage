<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// Atskaites pēc dokumentiem: filtri, kopsummas un PDF eksports.
class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Atskaites lapa ar filtriem un lappušu sadalījumu
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('company.required')->with('error', 'No company assigned.');
        }

        $filters = $this->validatedFilters($request, $company->id);
        $query = $this->baseDocumentQuery($company->id, $filters);

        $documents = (clone $query)
            ->with(['client'])
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        $paidRevenue = (clone $query)
            ->where('type', 'sales_invoice')
            ->where('status', 'paid')
            ->sum('total');

        $outstanding = (clone $query)
            ->where('type', 'sales_invoice')
            ->where('status', 'waiting_payment')
            ->sum('total');

        $clients = Client::where('company_id', $company->id)->orderBy('name')->get(['id', 'name']);

        return view('reports.index', [
            'documents' => $documents,
            'filters' => $filters,
            'paidRevenue' => $paidRevenue,
            'outstanding' => $outstanding,
            'clients' => $clients,
        ]);
    }

    // PDF ar tiem pašiem filtriem kā tīmekļa atskaitei
    public function exportPdf(Request $request)
    {
        $company = auth()->user()->company;
        if (! $company) {
            return redirect()->route('dashboard')->with('error', 'No company assigned.');
        }

        $filters = $this->validatedFilters($request, $company->id);
        $docs = $this->baseDocumentQuery($company->id, $filters)
            ->with(['client'])
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->get();

        $paidRevenue = $docs->where('type', 'sales_invoice')->where('status', 'paid')->sum('total');
        $outstanding = $docs->where('type', 'sales_invoice')->where('status', 'waiting_payment')->sum('total');

        $prevLocale = App::getLocale();
        App::setLocale('lv');
        try {
            $pdf = Pdf::loadView('pdf.report', [
                'company' => $company,
                'documents' => $docs,
                'filters' => $filters,
                'paidRevenue' => $paidRevenue,
                'outstanding' => $outstanding,
            ], [], 'UTF-8');
        } finally {
            App::setLocale($prevLocale);
        }

        $from = $filters['date_from']->format('Y-m-d');
        $to = $filters['date_to']->format('Y-m-d');

        return $pdf->download("report-{$from}-{$to}.pdf");
    }

    // Apvieno un normalizē filtru vērtības (datumi noklusēti uz šo mēnesi)
    private function validatedFilters(Request $request, int $companyId): array
    {
        // Validējam tikai "atļauto filtru valodu", lai URL parametri nevar uzbūvēt nekorektu vaicājumu.
        $validator = Validator::make($request->all(), [
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'client_id' => [
                'nullable',
                'integer',
                Rule::exists('clients', 'id')->where('company_id', $companyId),
            ],
            'status' => 'nullable|in:draft,sent,confirmed,cancelled,waiting_payment,paid',
            'type' => 'nullable|in:estimate,sales_order,sales_invoice',
        ]);

        // Cross-field pārbaude: date_to nedrīkst būt agrāks par date_from.
        $validator->after(function ($v) use ($request) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                if (Carbon::parse($request->input('date_to'))->lt(Carbon::parse($request->input('date_from')))) {
                    $v->errors()->add('date_to', 'End date must be on or after start date.');
                }
            }
        });

        $validated = $validator->validate();

        // Ja datumi nav padoti, atskaite noklusēti rāda tekošo mēnesi.
        $dateFrom = isset($validated['date_from'])
            ? Carbon::parse($validated['date_from'])->startOfDay()
            : now()->startOfMonth();
        $dateTo = isset($validated['date_to'])
            ? Carbon::parse($validated['date_to'])->endOfDay()
            : now()->endOfMonth();

        $status = isset($validated['status']) && $validated['status'] !== '' ? $validated['status'] : null;
        $type = isset($validated['type']) && $validated['type'] !== '' ? $validated['type'] : null;

        return [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'client_id' => $validated['client_id'] ?? null,
            'status' => $status,
            'type' => $type,
        ];
    }

    // Dokumentu vaicājums ar datuma un papildfiltru ierobežojumiem
    private function baseDocumentQuery(int $companyId, array $filters)
    {
        $q = Document::query()->where('company_id', $companyId);

        $q->whereDate('invoice_date', '>=', $filters['date_from']->toDateString());
        $q->whereDate('invoice_date', '<=', $filters['date_to']->toDateString());

        if (! empty($filters['client_id'])) {
            $q->where('client_id', $filters['client_id']);
        }

        if (! empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        if (! empty($filters['type'])) {
            $q->where('type', $filters['type']);
        }

        return $q;
    }
}

