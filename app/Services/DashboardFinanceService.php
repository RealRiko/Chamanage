<?php

namespace App\Services;

use App\Models\Company;
use App\Support\Vat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Dashboard finanšu aprēķini: apmaksātie rēķini, neto peļņa, mēnešu sērijas (SQL saderīgs ar SQLite/MySQL).
class DashboardFinanceService
{
    // SQL izteiksme rindas apgrozījumam peļņai (bez PVN, ja dokumentā apply_vat)
    public static function lineNetRevenueSqlExpression(float $vatMultiplier): string
    {
        if (! Schema::hasColumn('documents', 'apply_vat')) {
            return '(line_items.subtotal / ' . $vatMultiplier . ')';
        }

        // IFNULL + skaitliskā piespiešana (+ 0) — vienāda uzvedība SQLite / MySQL.
        $m = $vatMultiplier;

        return "(CASE WHEN (IFNULL(documents.apply_vat, 1) + 0) != 0 THEN line_items.subtotal / {$m} ELSE line_items.subtotal END)";
    }

    // Datuma izteiksme dokumentam: invoice_date vai created_at (DB draivera atšķirība)
    public static function documentDayExpression(string $docAlias = 'documents'): string
    {
        return DB::connection()->getDriverName() === 'sqlite'
            ? "date(COALESCE({$docAlias}.invoice_date, {$docAlias}.created_at))"
            : "COALESCE({$docAlias}.invoice_date, DATE({$docAlias}.created_at))";
    }

    // Mēneša atslēga 'Y-m' grupēšanai diagrammām
    public static function monthKeyExpression(string $docAlias = 'documents'): string
    {
        return DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', COALESCE({$docAlias}.invoice_date, {$docAlias}.created_at))"
            : "DATE_FORMAT(COALESCE({$docAlias}.invoice_date, DATE({$docAlias}.created_at)), '%Y-%m')";
    }

    // Uzņēmuma apmaksāto pārdošanas rēķinu summa periodā
    public static function companyPaidInvoiceRevenueBetween(
        int $companyId,
        Carbon $from,
        Carbon $to,
    ): float {
        $dayExpr = self::documentDayExpression();

        return (float) DB::table('documents')
            ->where('company_id', $companyId)
            ->where('type', 'sales_invoice')
            ->where('status', 'paid')
            ->whereRaw("{$dayExpr} >= ?", [$from->toDateString()])
            ->whereRaw("{$dayExpr} <= ?", [$to->toDateString()])
            ->sum('total');
    }

    // Konkrēta lietotāja izveidoto apmaksāto rēķinu summa periodā
    public static function personalPaidInvoiceRevenueBetween(
        int $companyId,
        int $userId,
        Carbon $from,
        Carbon $to,
    ): float {
        $dayExpr = self::documentDayExpression();

        return (float) DB::table('documents')
            ->where('company_id', $companyId)
            ->where('created_by_user_id', $userId)
            ->where('type', 'sales_invoice')
            ->where('status', 'paid')
            ->whereRaw("{$dayExpr} >= ?", [$from->toDateString()])
            ->whereRaw("{$dayExpr} <= ?", [$to->toDateString()])
            ->sum('total');
    }

    // Personīgā neto peļņa periodā (pēc pašizmaksas)
    public static function personalNetProfitBetween(
        int $companyId,
        int $userId,
        Carbon $from,
        Carbon $to,
    ): float {
        return self::netProfitSumBetween($companyId, $from, $to, $userId);
    }

    // Uzņēmuma neto peļņa periodā
    public static function companyNetProfitBetween(
        int $companyId,
        Carbon $from,
        Carbon $to,
    ): float {
        return self::netProfitSumBetween($companyId, $from, $to, null);
    }

    // Kopējā neto peļņa no apmaksātām rēķinu rindām (opcionāli filtrē pēc izveidotāja)
    protected static function netProfitSumBetween(
        int $companyId,
        Carbon $from,
        Carbon $to,
        ?int $createdByUserId,
    ): float {
        $dayExpr = self::documentDayExpression('documents');
        $cost = DB::connection()->getDriverName() === 'sqlite'
            ? 'COALESCE(products.cost_price, 0)'
            : 'COALESCE(products.cost_price, 0)';

        $q = DB::table('line_items')
            ->join('documents', 'documents.id', '=', 'line_items.document_id')
            ->leftJoin('products', 'products.id', '=', 'line_items.product_id')
            ->where('documents.company_id', $companyId)
            ->where('documents.type', 'sales_invoice')
            ->where('documents.status', 'paid')
            ->whereRaw("{$dayExpr} >= ?", [$from->toDateString()])
            ->whereRaw("{$dayExpr} <= ?", [$to->toDateString()]);

        if ($createdByUserId !== null) {
            $q->where('documents.created_by_user_id', $createdByUserId);
        }

        $companyCountry = Company::query()->whereKey($companyId)->value('country');
        $vatMultiplier = Vat::multiplierForCountry($companyCountry);

        // Peļņai vajag apgrozījumu bez PVN. Ja apply_vat ir izslēgts, subtotal jau ir bez PVN.
        // Nav apply_vat kolonnas (vecā DB): pieņemam tipisko — subtotal ar PVN, tāpēc dalām ar uzņēmuma PVN multiplikatoru.
        $revenueExpr = self::lineNetRevenueSqlExpression($vatMultiplier);

        $sum = $q->selectRaw(
            "SUM({$revenueExpr} - line_items.quantity * {$cost}) as net"
        )->value('net');

        return round((float) $sum, 2);
    }

    // Atgriež [mēnešu etiķetes], [summas] apmaksātajiem rēķiniem (vecākais → jaunākais mēnesis)
    public static function companyMonthlyRevenueSeries(
        int $companyId,
        int $monthCount,
        Carbon $now,
    ): array {
        $monthCount = max(1, min(12, $monthCount));
        $monthKeyExpr = self::monthKeyExpression();

        $keys = collect(range($monthCount - 1, 0))
            ->map(fn (int $i) => $now->copy()->subMonths($i)->format('Y-m'))
            ->values();

        $fromYm = $keys->first();
        $toYm = $keys->last();

        $rows = DB::table('documents')
            ->where('company_id', $companyId)
            ->where('type', 'sales_invoice')
            ->where('status', 'paid')
            ->whereRaw("({$monthKeyExpr}) >= ?", [$fromYm])
            ->whereRaw("({$monthKeyExpr}) <= ?", [$toYm])
            ->groupBy(DB::raw($monthKeyExpr))
            ->selectRaw("{$monthKeyExpr} as ym, SUM(total) as revenue")
            ->pluck('revenue', 'ym');

        $labels = [];
        $values = [];
        foreach ($keys as $ym) {
            $labels[] = Carbon::createFromFormat('Y-m', $ym)->translatedFormat('M Y');
            $values[] = (float) $rows->get($ym, 0);
        }

        return [$labels, $values];
    }
}
