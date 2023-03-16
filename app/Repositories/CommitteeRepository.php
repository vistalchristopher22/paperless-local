<?php

namespace App\Repositories;

use App\Models\Committee;
use Illuminate\Support\Collection;

final class CommitteeRepository extends BaseRepository
{
    public function __construct(Committee $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information'])
                    ->orderBy('priority_number', 'ASC')
                    ->whereNull('deleted_at')
                    ->get();
    }

    public function getNextPriorityNumber(): string
    {
        return str_pad($this->model->count() + 1, 2, "0", STR_PAD_LEFT);
    }
}
