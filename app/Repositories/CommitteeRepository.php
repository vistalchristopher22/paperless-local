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
            ->orderBy('created_at', 'DESC')
            ->get($columns);
    }

    public function approvedOrLocked($columns = [])
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->whereNull('deleted_at')
            ->where('status', '!=', 'review')
            ->get($columns);
    }

    public function paginated(int|null $lead, int|null $expanded)
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted', 'other_expanded_committee_information', 'file_link'])
            ->when($lead, function ($query, $lead) {
                return $query->where('lead_committee', $lead);
            })
            ->when($expanded, function ($query, $expanded) {
                return $query->where('expanded_committee', $expanded);
            })->when($expanded, function ($query, $expanded) {
                return $query->orWhere('expanded_committee_2', $expanded);
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }
}
