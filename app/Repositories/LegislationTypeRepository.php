<?php

namespace App\Repositories;

use App\Models\Type as LegislationType;

final class LegislationTypeRepository extends BaseRepository
{
    public function __construct(LegislationType $model)
    {
        parent::__construct($model);
    }
}
