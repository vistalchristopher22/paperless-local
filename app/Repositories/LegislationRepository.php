<?php

namespace App\Repositories;

use App\Models\Legislation;
use Illuminate\Support\Collection;

final class LegislationRepository extends BaseRepository
{
    // Change the model
    public function __construct(Legislation $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->with('legislable')->get();
    }
}
