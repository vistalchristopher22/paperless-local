<?php

namespace App\Repositories;

use App\Models\Committee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CommitteeRepository extends BaseRepository
{
    public function __construct(Committee $model)
    {
        parent::__construct($model);
    }

    public function get($columns = []): Collection
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information'])
            ->whereNull('deleted_at')
            ->get($columns);
    }


    public function prepareQuery()
    {
        return DB::table('committees')
            ->whereNull('committees.deleted_at')
            ->select('committees.*');
    }

    public function getNextPriorityNumber(): string
    {
        return str_pad($this->model->count() + 1, 2, "0", STR_PAD_LEFT);
    }
}
