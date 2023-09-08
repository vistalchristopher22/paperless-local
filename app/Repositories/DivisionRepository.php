<?php

namespace App\Repositories;

use App\Models\Division;

final class DivisionRepository extends BaseRepository
{
    public function __construct(Division $model)
    {
        parent::__construct($model);
    }
}
