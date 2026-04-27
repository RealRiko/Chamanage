<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use App\Services\DashboardFinanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

// Sākumlapa: komandas un personīgie rādītāji, diagramma, kavētie rēķini, zems atlikums.
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Saglabā lietotāja personīgo mērķi un tā veidu (apgrozījums vai neto peļņa)
    public function updatePersonalSettings(Request $request)
    {
        if (! Schema::hasColumn('users', 'personal_monthly_goal')) {
            return redirect()->route('dashboard')->with('error', __('dashboard.settings_migrate_short'));
        }

        $goalInput = $request->input('personal_monthly_goal');
        if ($goalInput === '' || $goalInput === null) {
            $request->merge(['personal_monthly_goal' => null]);
        }

        $validated = $request->validate([
            'personal_monthly_goal' => 'nullable|numeric|min:0|max:99999999',
            'personal_goal_type' => 'required|in:revenue,net_profit',
        ]);

        $user = $request->user();
        $user->update([
            'personal_monthly_goal' => $validated['personal_monthly_goal'],
            'personal_goal_type' => $validated['personal_goal_type'],
        ]);

        return redirect()->route('dashboard')->with('status', __('dashboard.settings_saved'));
    }

    // Galvenais dashboard ar finanšu sērijām, mērķiem un brīdinājumiem
    public function index(Request $request)
    {
        $user = $request->user()->fresh(['company']);

        $company = $user->company;

        if (! $company) {
            return redirect()->route('company.required')
                ->with('error', 'Please create or join a company first.');
        }

        $now = Carbon::now();
        $companyId = $company->id;

        $hasPersonalDashboard = Schema::hasColumn('users', 'personal_monthly_goal');

        // Pēdējo mēnešu apmaksāto rēķinu apgrozījums (diagrammai)
        [$months, $revenues] = DashboardFinanceService::companyMonthlyRevenueSeries(
            $companyId,
            6,
            $now,
        );

        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();

        // Komandas apgrozījums šajā mēnesī (apmaksātie rēķini)
        $teamIncomeThisMonth = DashboardFinanceService::companyPaidInvoiceRevenueBetween(
            $companyId,
            $monthStart,
            $monthEnd,
        );

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();
        $lastMonthRevenue = DashboardFinanceService::companyPaidInvoiceRevenueBetween(
            $companyId,
            $lastMonthStart,
            $lastMonthEnd,
        );

        $weekStart = $now->copy()->startOfWeek();
        $weekEnd = $now->copy()->endOfWeek();
        // Nedēļas neto peļņa (pēc pašizmaksas)
        $weeklyNetProfitTotal = DashboardFinanceService::companyNetProfitBetween(
            $companyId,
            $weekStart,
            $weekEnd,
        );

        $monthlyNetProfitTotal = DashboardFinanceService::companyNetProfitBetween(
            $companyId,
            $monthStart,
            $monthEnd,
        );

        // Personīgie ieņēmumi / peļņa šajā mēnesī
        $myRev = DashboardFinanceService::personalPaidInvoiceRevenueBetween(
            $companyId,
            $user->id,
            $monthStart,
            $monthEnd,
        );
        $myNet = DashboardFinanceService::personalNetProfitBetween(
            $companyId,
            $user->id,
            $monthStart,
            $monthEnd,
        );
        $myGoalAmount = $hasPersonalDashboard ? $user->personal_monthly_goal : null;
        $myGoalType = ($hasPersonalDashboard && ($user->personal_goal_type ?? 'revenue') === 'net_profit')
            ? 'net_profit'
            : 'revenue';
        $myCurrent = $myGoalType === 'net_profit' ? $myNet : $myRev;
        $myGoalFloat = $myGoalAmount !== null ? (float) $myGoalAmount : 0.0;
        $myProgressPct = $myGoalFloat > 0 ? min(100.0, round(($myCurrent / $myGoalFloat) * 100, 1)) : null;

        $myGoalProgress = $myProgressPct;

        $goal = (float) ($company->monthly_goal ?? 0);
        $goalProgress = $goal > 0
            ? min(100.0, round(($teamIncomeThisMonth / $goal) * 100, 1))
            : 0.0;

        // Kavētie pārdošanas rēķini (gaida maksājumu, termiņš pagājis)
        $overdueInvoices = Document::where('company_id', $companyId)
            ->where('type', 'sales_invoice')
            ->where('status', 'waiting_payment')
            ->whereDate('due_date', '<', $now->toDateString())
            ->with('client')
            ->orderBy('due_date')
            ->limit(10)
            ->get();

        $lowStockThreshold = max(1, (int) ($company->low_stock_threshold ?? 10));
        $lowStockProducts = collect();
        if ($company->low_stock_notify_enabled) {
            $lowStockProducts = Product::query()
                ->where('company_id', $companyId)
                ->quantityStrictlyBelow($lowStockThreshold)
                ->with('inventory')
                ->limit(200)
                ->get()
                ->sortBy(fn ($p) => $p->inventory->quantity ?? 0)
                ->values()
                ->take(12);
        }

        $thisMonthRevenue = $teamIncomeThisMonth;

        return view('dashboard', compact(
            'months',
            'revenues',
            'thisMonthRevenue',
            'lastMonthRevenue',
            'goal',
            'goalProgress',
            'overdueInvoices',
            'lowStockProducts',
            'company',
            'teamIncomeThisMonth',
            'weeklyNetProfitTotal',
            'monthlyNetProfitTotal',
            'weekStart',
            'weekEnd',
            'monthStart',
            'monthEnd',
            'hasPersonalDashboard',
            'myGoalProgress',
            'myRev',
            'myNet',
            'myGoalAmount',
            'myGoalType',
            'myCurrent',
            'myProgressPct',
        ));
    }
}
