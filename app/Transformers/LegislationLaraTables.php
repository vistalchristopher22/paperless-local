<?php

namespace App\Transformers;

use Illuminate\Support\Str;

class LegislationLaraTables
{
    public static function laratablesLegislableRelationQuery()
    {
        return function ($query) {
            $query->with('legislation');
        };
    }

    public static function laratablesQueryConditions($query)
    {
        $query = $query->query();
        $query->when(request()->dates !== '*', function ($query) {
            $query->whereHas('legislable', function ($query) {
                list($fromDate, $toDate) = explode(" - ", request()->dates);
                $query->whereDate('session_date', '>=', $fromDate)->whereDate('session_date', '<=', $toDate);
            });
        })->when(request()->author !== '*', function ($query) {
            $query->whereHas('legislable', fn($query) => $query->where('author', request()->author));
        })->when(request()->type !== '*', function ($query) {
            $query->whereHas('legislable', fn($query) => $query->where('type', request()->type));
        })->when(request()->classification !== '*', function ($query) {
            $query->where('classification', Str::lower(request()->classification));
        });

        return $query;
    }
}
