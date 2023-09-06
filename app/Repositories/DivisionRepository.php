<?php

namespace App\Repositories;

use App\Models\Division;
use Illuminate\Support\Collection;

final class DivisionRepository extends BaseRepository
{
    public function __construct(Division $model)
    {
        parent::__construct($model);
    }
}
