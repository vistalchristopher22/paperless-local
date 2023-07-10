<?php

namespace App\Repositories;

use App\Models\Venue;

final class VenueRepository extends BaseRepository
{
    public function __construct(Venue $model)
    {
        parent::__construct($model);
    }
}
