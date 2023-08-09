<?php

namespace App\Repositories;

use App\Models\Ordinance;

final class OrdinanceRepository extends LegislationRepository
{
    public function __construct(Ordinance $model)
    {
        $this->model = $model;
    }
}
