<?php

namespace App\Repositories;

use App\Enums\BoardSessionStatus;
use App\Models\BoardSession;
use Carbon\Carbon;

final class BoardSessionRespository extends BaseRepository
{
    public function __construct(BoardSession $model)
    {
        parent::__construct($model);
    }

    public function paginated(string|null $schedule)
    {
        return $this->model->with(['schedule_information' => [
            'schedule_venue',
        ], 'file_link', 'submitted'])
            ->when($schedule, function ($query, $schedule) {
                $query->whereHas('schedule_information', function ($query) use ($schedule) {
                    if ($schedule) {
                        [$referenceSession, $type] = explode('-', $schedule);
                        $query->where('reference_session', $referenceSession)
                            ->where('type', trim($type));
                    }
                });
            })->orderBy('created_at', 'DESC')
            ->paginate();
    }

    public function getNoScheduleEvents()
    {
        return $this->model::orderBy('created_at', 'ASC')
            // ->whereDoesntHave('schedule_information')
            ->get(['id', 'title']);
    }

    public function fetchByDate($date)
    {
        $date = Carbon::parse($date);
        $session = $this->model->with(['schedule_information' => function ($query) use ($date) {
            $query->whereDay('created_at', $date->day)->whereYear('created_at', $date->year)->whereMonth('created_at', $date->month);
        }])->first();
        return $session;
    }

    public function addSchedule(int $id, int $scheduleID): BoardSession
    {
        $record = $this->model->find($id);
        $record->schedule_id = $scheduleID;
        $record->save();
        return $record;
    }


    public function locked(BoardSession $boardSession): BoardSession
    {
        $boardSession->update([
            'status' => BoardSessionStatus::LOCKED,
        ]);

        return $boardSession;
    }

    public function unlocked(BoardSession $boardSession): BoardSession
    {
        $boardSession->update([
            'status' => BoardSessionStatus::UNLOCKED,
        ]);

        return $boardSession;
    }

    public function published()
    {
        return $this->model->where('is_published', 1)->latest()->first();
    }
}
