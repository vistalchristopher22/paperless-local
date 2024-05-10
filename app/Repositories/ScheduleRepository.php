<?php

namespace App\Repositories;

use App\Enums\ScheduleType;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class ScheduleRepository extends BaseRepository
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public static function getUniqueSchedules()
    {
        return Schedule::with([
            'with_guest_committees',
            'without_guest_committees',
        ])
            ->get(['reference_session', 'type', 'id'])
            ->unique(function ($item) {
                return $item->reference_session . '-' . $item->type;
            })->values();
    }


    public function get(): Collection
    {
        return $this->model->get();
    }

    public function getAllSchedules()
    {
        return $this->model->get();
    }

    public function findByDate(string $date)
    {
        return $this->model->whereDate('date_and_time', $date)
            ->with('schedule_venue')
            ->with(['order_of_business_information' => ['file_link']])
            ->with([
                'with_guest_committees' => [
                    'file_link',
                    'lead_committee_information' => [
                        'chairman_information',
                        'vice_chairman_information',
                        'members' => ['sanggunian_member'],
                    ],
                    'expanded_committee_information',
                    'other_expanded_committee_information',
                ],
                'without_guest_committees' => [
                    'file_link',
                    'lead_committee_information' => [
                        'chairman_information',
                        'vice_chairman_information',
                        'members' => ['sanggunian_member'],
                    ],
                    'expanded_committee_information',
                    'other_expanded_committee_information',
                ],
            ])
            ->first();
    }

    public function createSchedule(array $data = [])
    {
        $carbonDate = request()->time ? Carbon::parse($data['selected_date'] . ' ' . $data['time']) : Carbon::parse(
            $data['selected_date']
        );
        return $this->model->create([
            'date_and_time'     => $carbonDate,
            'description'       => $data['description'],
            'reference_session' => $data['reference_session'],
            'order_of_business' => $data['order_of_business'],
            'venue'             => $data['venue'],
            'type'              => $data['type'],
        ]);
    }

    public function updateSchedule(array $data = []): mixed
    {
        $schedule                    = $this->model->find($data['id']);
        $schedule->date_and_time     = Carbon::parse($data['selected_date'] . ' ' . $data['time']);
        $schedule->description       = $data['description'];
        $schedule->venue             = $data['venue'];
        $schedule->type              = $data['type'];
        $schedule->reference_session = $data['reference_session'];
        $schedule->order_of_business = $data['order_of_business'];
        $schedule->save();

        return $schedule;
    }

    public function deleteSchedule(int $id): mixed
    {
        return DB::transaction(function () use ($id) {
            $schedule = $this->model->find($id);

            $this->removeCommitteeSchedule($schedule);

            $isDeleted = $schedule->delete();

            return [
                'isDeleted' => $isDeleted,
                'schedule'  => $schedule,
            ];
        });
    }

    public function groupedByDate(array $dates = [])
    {
        return $this->model->with(
            [
                'committees:id,lead_committee,expanded_committee,schedule_id,expanded_committee_2',
                'committees.lead_committee_information',
                'committees.expanded_committee_information',
                'committees.other_expanded_committee_information',
                'order_of_business'
            ]
        )
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('date_and_time', 'ASC')
            ->get()
            ->groupBy(fn ($record) => $record->date_and_time->format('Y-m-d'));
    }

    public function groupedByDateCommittees(array $dates = [])
    {
        return $this->model->with(
            [
                'committees:id,lead_committee,expanded_committee,schedule_id,expanded_committee_2',
                'committees.lead_committee_information',
                'committees.expanded_committee_information',
                'committees.other_expanded_committee_information',
                'board_sessions',
                'regular_session'
            ]
        )
            ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->where('type', ScheduleType::MEETING)
            ->get()
            ->groupBy(fn ($record) => $record->date_and_time->format('Y-m-d'));
    }

    private function removeOrderBusinessSchedule($schedule): void
    {
        $schedule->board_sessions->each(function ($boardSession) {
            $boardSession->schedule_id = null;
            $boardSession->save();
        });
    }

    private function removeCommitteeSchedule($schedule): void
    {
        $schedule->committees->each(function ($committee) {
            $committee->schedule_id = null;
            $committee->save();
        });
    }
}
