<?php

namespace App\Repositories;

use Exception;
use App\Models\Schedule;
use App\Enums\ScheduleType;
use App\Models\ScreenDisplay;
use App\Models\ReferenceSession;
use App\Enums\DisplayScheduleType;
use App\Enums\ScreenDisplayStatus;
use App\Contracts\ScreenDisplayRepositoryInterface;

final class ScreenDisplayRepository extends BaseRepository implements ScreenDisplayRepositoryInterface
{
    public function __construct(ScreenDisplay $model)
    {
        parent::__construct($model);
    }

    /**
     * TODO: refactor this method
     * @throws Exception
     */
    public function updateScreenDisplays(Schedule $data)
    {
        $currentIndex = 1;
        foreach ($data->committees as $committee) {
            if($currentIndex == 2) {
                $status = ScreenDisplayStatus::NEXT;
            } else if($currentIndex == 1) {
                $status = ScreenDisplayStatus::ON_GOING;
            } else {
                $status = ScreenDisplayStatus::PENDING;
            }
             ScreenDisplay::updateOrCreate([
                'schedule_id' => $data->id,
                'screen_displayable_id'   => $committee->id,
                'screen_displayable_type' => get_class($committee),
            ], [
                'schedule_id'             => $data->id,
                'screen_displayable_id'   => $committee->id,
                'screen_displayable_type' => get_class($committee),
                'type'                    => DisplayScheduleType::MEETING->value,
                'status'                  => $status,
                'index'                   => $currentIndex,
            ]);
            ++$currentIndex;
        }
    }

    public function getCurrentScreenDisplay(Schedule $data)
    {
        return $this->model::with([
            'schedule' => [
                'order_of_business_information', 'committees', 'schedule_venue'
            ],
        ])->where('schedule_id', $data['id'])
            ->where('status', ScreenDisplayStatus::ON_GOING)
            ->first();
    }


    public function getUpNextScreenDisplay(ReferenceSession $data)
    {
        // return $this->model::with([
        //     'schedule',
        //     'schedule.board_sessions',
        //     'schedule.committees',
        //     'schedule.guests',
        //     'screen_displayable',
        //     'screen_displayable.lead_committee_information',
        //     'screen_displayable.committee_invited_guests',
        //     'screen_displayable.lead_committee_information.chairman_information',
        //     'screen_displayable.lead_committee_information.vice_chairman_information',
        //     'screen_displayable.lead_committee_information.members',
        //     'screen_displayable.lead_committee_information.members.sanggunian_member'
        // ])->where('reference_session_id', $data['id'])
        //     ->where('status', ScreenDisplayStatus::NEXT)
        //     ->first();

    }

    private function updateOrCreateScreenDisplay(ReferenceSession $data, $scheduleId, $displayable, $type, $status, $index)
    {
        $this->model::create([
            'reference_session_id'    => $data['id'],
            'schedule_id'             => $scheduleId,
            'screen_displayable_id'   => $displayable->id,
            'screen_displayable_type' => get_class($displayable),
            'index'                   => $index,
            'type'                    => $type,
            'status'                  => $status,
        ]);
    }

    public function getByReferenceSession(int $id)
    {
        return $this->model::with([
            'schedule',
            'screen_displayable',
        ])
            ->where('schedule_id', $id)
            ->orderBy('index', 'ASC')
            ->get();
    }

    public function getSortedByReferenceSession(int $id)
    {
        return $this->getByReferenceSession($id)->sortBy(fn ($referenceSession) => array_search($referenceSession->status, ScreenDisplayStatus::values()))->values();
    }

    public function reOrderDisplay(array $data = []): bool
    {
        $status = match ((int) $data['index']) {
            1 => ScreenDisplayStatus::ON_GOING,
            2 => ScreenDisplayStatus::NEXT,
            default => ScreenDisplayStatus::PENDING,
        };

        return $this->findById($data['id'])->update([
            'index' => $data['index'],
            'status' => $status,
        ]);
    }
}
