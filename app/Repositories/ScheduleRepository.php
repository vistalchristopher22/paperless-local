<?php

namespace App\Repositories;

use App\Enums\CommitteeStatus;
use App\Enums\ScheduleType;
use App\Http\Resources\ScheduleResource;
use App\Models\Committee;
use App\Models\Schedule;
use App\Utilities\FileUtility;
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
        return ScheduleResource::collection($this->model->get()->load('regular_session'));
    }

    public function createSchedule(array $data = [], int $reference)
    {
        $carbonDate = request()->time ? Carbon::parse($data['selected_date'] . ' ' . $data['time']) : Carbon::parse($data['selected_date']);
        return $this->model->create([
            'name' => $data['name'],
            'date_and_time' => $carbonDate,
            'description' => $data['description'],
            'venue' => $data['venue'],
            'type' => $data['type'],
            'reference_session_id' => $reference,
            'with_invited_guest' => $data['guests'] == 'on' ? 1 : 0,
            'root_directory' => FileUtility::isInputDirectoryEscaped($data['root_directory']),
        ]);
    }

    public function updateSchedule(array $data = [], int $reference): mixed
    {
        $schedule = $this->model->find($data['id']);
        $schedule->name = $data['name'];
        $schedule->date_and_time = Carbon::parse($data['selected_date'] . ' ' . $data['time']);
        $schedule->description = $data['description'];
        $schedule->venue = $data['venue'];
        $schedule->with_invited_guest = $data['guests'] == 'on' ? 1 : 0;
        $schedule->type = $data['type'];
        $schedule->reference_session_id = $reference;
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
        return $this->model->with(['committees:id,lead_committee,expanded_committee,schedule_id,expanded_committee_2', 'committees.lead_committee_information', 'committees.expanded_committee_information', 'committees.other_expanded_committee_information', 'board_sessions', 'regular_session'])
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->get()
            ->groupBy(fn($record) => $record->date_and_time->format('Y-m-d'));
    }

    public function groupedByDateCommittees(array $dates = [])
    {
        return $this->model->with(['committees:id,lead_committee,expanded_committee,schedule_id,expanded_committee_2', 'committees.lead_committee_information', 'committees.expanded_committee_information', 'committees.other_expanded_committee_information', 'board_sessions', 'regular_session'])
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->where('type', ScheduleType::MEETING)
            ->get()
            ->groupBy(fn($record) => $record->date_and_time->format('Y-m-d'));
    }

}
