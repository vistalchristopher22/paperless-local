<?php

namespace App\Repositories;

use App\Models\Committee;
use Illuminate\Support\Collection;

class CommitteeRepository extends BaseRepository
{
    public function __construct(Committee $model)
    {
        parent::__construct($model);
    }

    public function get($columns = []): Collection
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->whereNull('deleted_at')
            ->get($columns);
    }

    public function approvedOrLocked($columns = [])
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->whereNull('deleted_at')
            ->where('status', '!=', 'review')
            ->get($columns);
    }
}
