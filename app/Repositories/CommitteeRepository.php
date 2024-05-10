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

    public function approvedOrLocked($columns = [])
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->whereNull('deleted_at')
            ->where('status', '!=', 'review')
            ->get($columns);
    }

    public function get($columns = []): Collection
    {
        return $this->model->with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get($columns);
    }

    public function paginated(int|null $lead, int|null $expanded, string|null $schedule)
    {
        return $this->model->with(
            [
                'lead_committee_information',
                'expanded_committee_information',
                'submitted',
                'other_expanded_committee_information',
                'schedule_information',
                'schedule_information.schedule_venue',
                'file_link',
                'committee_invited_guests',
            ]
        )
            ->when($lead, function ($query, $lead) {
                return $query->where('lead_committee', $lead);
            })
            ->when($expanded, function ($query, $expanded) {
                return $query->where('expanded_committee', $expanded);
            })->when($expanded, function ($query, $expanded) {
                return $query->orWhere('expanded_committee_2', $expanded);
            })->when($schedule, function ($query, $schedule) {
                $query->whereHas('schedule_information', function ($query) use ($schedule) {
                    if ($schedule) {
                        [$referenceSession, $type] = explode('-', $schedule);
                        $query->where('reference_session', $referenceSession)
                            ->where('type', trim($type));
                    }
                });
            })
            ->withCount('committee_invited_guests')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }
}
