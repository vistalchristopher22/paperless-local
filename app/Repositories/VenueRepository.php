<?php

namespace App\Repositories;

use App\Models\Venue;

final class VenueRepository extends BaseRepository
{
    public function __construct(Venue $model)
    {
        parent::__construct($model);
    }

    public static function getUniqueVenues()
    {
        return Venue::select('id', 'name')->get();
    }
}
