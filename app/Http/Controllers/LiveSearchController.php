<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use App\Models\Product;
use App\Traits\LiveSearchTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Vienots JSON meklēšanas galapunkts produktiem, klientiem un dokumentiem.
class LiveSearchController extends Controller
{
    use LiveSearchTrait;

    // Atļautie Eloquent modeļi un lauki ģenerālajai meklēšanai (trait)
    private static function allowedModels(): array
    {
        return [
            Product::class => ['name', 'description', 'category'],
        ];
    }

    // Atgriež līdz 200 ierakstiem pēc vaicājuma un uzņēmuma
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('query', ''));
        $modelClass = (string) $request->query('model', '');
        $company = Auth::user()?->company;

        if ($query === '' || ! $company) {
            return response()->json([]);
        }

        if ($modelClass === Client::class) {
            $table = (new Client)->getTable();

            return response()->json(
                Client::query()
                    ->where($table.'.company_id', $company->id)
                    ->searchByNameOrEmailPrefix($query)
                    ->with('creator:id,name,surname')
                    ->orderByRaw(
                        'CASE WHEN `'.$table.'`.`name` = ? THEN 100 WHEN `'.$table.'`.`name` LIKE ? THEN 90 ELSE 80 END DESC',
                        [$query, $query.'%']
                    )
                    ->limit(200)
                    ->get()
            );
        }

        if ($modelClass === Document::class) {
            $results = Document::query()
                ->whereHas('client', function ($q) use ($query, $company): void {
                    $q->where('company_id', $company->id)
                        ->where('name', 'like', '%'.$query.'%');
                })
                ->with('client')
                ->limit(10)
                ->get();

            return response()->json($results);
        }

        $allowed = self::allowedModels();
        if (isset($allowed[$modelClass])) {
            return $this->performLiveSearch($request, $modelClass, $allowed[$modelClass]);
        }

        return response()->json([]);
    }
}
