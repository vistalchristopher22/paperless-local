<?php

namespace App\Repositories;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class ScheduleRepository extends BaseRepository
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function getAllSchedules()
    {
        return ScheduleResource::collection($this->model->get());
    }

    public function createSchedule(array $data = [])
    {
        $carbonDate = request()->time ? Carbon::parse($data['selected_date'] . ' ' . $data['time']) : Carbon::parse($data['selected_date']);
        return $this->model->create([
            'name' => $data['name'],
            'date_and_time' => $carbonDate,
            'description' => $data['description'],
            'venue' => $data['venue'],
            'type' => $data['type'],
            'with_invited_guest' => $data['guests'] == 'on' ? 1 : 0,
        ]);
    }

    public function updateSchedule(array $data = []): mixed
    {
        $schedule = $this->model->find($data['id']);
        $schedule->name = $data['name'];
        $schedule->date_and_time = Carbon::parse($data['selected_date'] . ' ' . $data['time']);
        $schedule->description = $data['description'];
        $schedule->venue = $data['venue'];
        $schedule->with_invited_guest = $data['guests'] == 'on' ? 1 : 0;
        $schedule->type = $data['type'];
        $schedule->save();
        return $schedule;
    }

    public function deleteSchedule(int $id): mixed
    {
        return DB::transaction(function () use ($id) {
            $schedule = $this->model->with('committees')->find($id);
            $this->removeCommitteeSchedule($schedule);
            return $schedule->delete();
        });
    }

    private function removeCommitteeSchedule($schedule): void
    {
        $schedule->committees->each(function ($committee) {
            $committee->schedule_id = null;
            $committee->save();
        });
    }

    public function groupedByDate(array $dates = [])
    {
        return $this->model->with(['committees:id,lead_committee,expanded_committee,schedule_id', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->get()
            ->groupBy(fn($record) => $record->date_and_time->format('Y-m-d'));
    }
}
