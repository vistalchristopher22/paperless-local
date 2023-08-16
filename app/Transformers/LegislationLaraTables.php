<?php

namespace App\Transformers;

use App\Enums\LegislateType;
use Illuminate\Support\Str;

class LegislationLaraTables
{

    public const WILDCARD = "*";

    public static function laratablesLegislableRelationQuery()
    {
        return function ($query) {
            $query->with('legislation');
        };
    }

    public static function laratablesSponsorsRelationQuery()
    {
        return function ($query) {
            $query->with('sponsors');
        };
    }

    public static function laratablesCustomSponsors($legislate)
    {
        return $legislate->sponsors->implode('fullname', '|');
    }

    private static function applyDatesFilter($query, string $dates): void
    {
        list($fromDate, $toDate) = explode(" - ", $dates);
        $query->whereHas('legislable', fn($query) => $query->whereDate('session_date', '>=', $fromDate)->whereDate('session_date', '<=', $toDate));
    }

    private static function applyAuthorFilter($query, int $authorID): void
    {
        $query->whereHas('legislable', fn($query) => $query->where('author', $authorID));
    }

    private static function applyTypeFilter($query, int $typeID): void
    {
        $query->whereHas('legislable', fn($query) => $query->where('type', $typeID));
    }

    private static function applyClassificationFilter($query, string $classification): void
    {
        $query->where('classification', Str::lower($classification));
    }

    private static function applySponsorsFilter($query, string $sponsors): void
    {
        $query->whereHas('sponsors', fn($query) => $query->whereIn('sanggunian_member_id', explode(',', $sponsors)));
    }

    public static function laratablesQueryConditions($query)
    {
        $query = $query->query();

        $query->when(request()->dates !== self::WILDCARD, fn($query) => self::applyDatesFilter($query, request()->dates));

        $query->when(request()->author !== self::WILDCARD, fn($query) => self::applyAuthorFilter($query, request()->author));

        $query->when(request()->type !== self::WILDCARD, fn($query) => self::applyTypeFilter($query, request()->type));

        $query->when(request()->classification !== self::WILDCARD, fn($query) => self::applyClassificationFilter($query, request()->classification));

        $query->when(request()->sponsors !== self::WILDCARD, fn($query) => self::applySponsorsFilter($query, request()->sponsors));

        return $query;
    }
}
