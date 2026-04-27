<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait LiveSearchTrait
{
    // Vispārīga meklēšana pa uzņēmuma ierakstiem pēc norādītajiem laukiem
    protected function performLiveSearch(Request $request, string $modelClass, array $searchFields = ['name']): JsonResponse
    {
        $search = trim($request->query('query', ''));
        $company = Auth::user()?->company;

        if ($search === '' || ! $company) {
            return response()->json([]);
        }

        if (! class_exists($modelClass) || ! is_subclass_of($modelClass, Model::class)) {
            return response()->json([]);
        }

        /** @var Model $model */
        $model = new $modelClass();
        $table = $model->getTable();

        $builder = $modelClass::query()
            ->where($table.'.company_id', $company->id)
            ->where(function ($q) use ($search, $searchFields, $table): void {
                foreach ($searchFields as $field) {
                    $q->orWhere($table.'.'.$field, 'like', '%'.$search.'%');
                }
            });

        $builder->orderByRaw(
            'CASE WHEN `'.$table.'`.`name` = ? THEN 100 WHEN `'.$table.'`.`name` LIKE ? THEN 90 ELSE 80 END DESC',
            [$search, $search.'%']
        );

        return response()->json($builder->limit(200)->get());
    }
}
