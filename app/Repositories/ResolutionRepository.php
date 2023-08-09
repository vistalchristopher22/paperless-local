<?php

namespace App\Repositories;

use App\Models\Resolution;

final class ResolutionRepository extends LegislationRepository
{
    public function __construct(Resolution $model)
    {
        $this->model = $model;
    }
}
