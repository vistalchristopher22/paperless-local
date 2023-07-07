<?php

namespace App\Repositories;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

final class ScheduleRepository extends BaseRepository
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function groupedByDate(array $dates = [])
    {
        return $this->model->with(['committees:id,lead_committee,expanded_committee,schedule_id', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->get()
            ->groupBy(fn ($record) => $record->date_and_time->format('Y-m-d'));
    }
}
