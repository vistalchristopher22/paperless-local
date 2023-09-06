<?php

namespace App\Repositories;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Enums\ScheduleType;
use App\Enums\ScreenDisplayStatus;
use App\Models\ReferenceSession;
use App\Models\ScreenDisplay;
use Exception;
use Illuminate\Support\Facades\DB;

final class ScreenDisplayRepository extends BaseRepository implements ScreenDisplayRepositoryInterface
{
    public function __construct(ScreenDisplay $model)
    {
        parent::__construct($model);
    }

    /**
     * @throws Exception
     */
    public function updateScreenDisplays(ReferenceSession $data)
    {
        DB::beginTransaction();

        try {
            // Update ScreenDisplays for board sessions
            foreach ($data->scheduleSessions as $scheduleSession) {
                foreach ($scheduleSession->board_sessions as $key => $boardSession) {
                    $this->updateOrCreateScreenDisplay($data, $scheduleSession->id, $boardSession, ScheduleType::SESSION, ScreenDisplayStatus::ON_GOING, $key + 1);
                    $key++;
                }
            }

            // Update ScreenDisplays for committees
            foreach ($data->scheduleCommittees as $scheduleCommittees) {
                foreach ($scheduleCommittees->committees as $committee) {
                    $status = ($key == 1) ? ScreenDisplayStatus::NEXT : ScreenDisplayStatus::PENDING;
                    $this->updateOrCreateScreenDisplay($data, $scheduleCommittees->id, $committee, ScheduleType::MEETING, $status, $key + 1);
                    $key++;
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function getCurrentScreenDisplay(ReferenceSession $data)
    {
        return $this->model::with([
            'schedule',
            'schedule.board_sessions',
            'schedule.committees',
            'schedule.guests',
            'screen_displayable'
        ])->where('reference_session_id', $data['id'])
            ->where('status', ScreenDisplayStatus::ON_GOING)
            ->first();
    }

    // public function getUpNextScreenDisplay(ReferenceSession $data)
    // {
    //     return $this->model::with([
    //         'schedule',
    //         'schedule.board_sessions',
    //         'schedule.committees',
    //         'schedule.guests',
    //         'screen_displayable',
    //         'screen_displayable.lead_committee_information',
    //         'screen_displayable.lead_committee_information.chairman_information',
    //         'screen_displayable.lead_committee_information.vice_chairman_information',
    //         'screen_displayable.lead_committee_information.members',
    //         'screen_displayable.lead_committee_information.members.sanggunian_member'
    //     ])->where('reference_session_id', $data['id'])
    //         ->where('status', ScreenDisplayStatus::NEXT)
    //         ->first();
    // }

    public function getUpNextScreenDisplay(ReferenceSession $data)
    {
        return $this->model::with([
            'schedule',
            'schedule.board_sessions',
            'schedule.committees',
            'schedule.guests',
            'screen_displayable',
            'screen_displayable.lead_committee_information',
            'screen_displayable.committee_invited_guests',
            'screen_displayable.lead_committee_information.chairman_information',
            'screen_displayable.lead_committee_information.vice_chairman_information',
            'screen_displayable.lead_committee_information.members',
            'screen_displayable.lead_committee_information.members.sanggunian_member'
        ])->where('reference_session_id', $data['id'])
            ->where('status', ScreenDisplayStatus::NEXT)
            ->first();
    }

    private function updateOrCreateScreenDisplay(ReferenceSession $data, $scheduleId, $displayable, $type, $status, $index)
    {
        $this->model::updateOrCreate([
            'reference_session_id' => $data['id'],
            'schedule_id' => $scheduleId,
            'screen_displayable_id' => $displayable->id,
            'screen_displayable_type' => get_class($displayable),
            'index' => $index,
            'status' => $status,
        ], [
            'reference_session_id' => $data['id'],
            'schedule_id' => $scheduleId,
            'screen_displayable_id' => $displayable->id,
            'screen_displayable_type' => get_class($displayable),
            'index' => $index,
            'type' => $type,
            'status' => $status,
        ]);
    }

    public function getByReferenceSession(int $id)
    {
        return $this->model::with([
            'reference_session',
            'schedule',
            'screen_displayable',
            'screen_displayable' => function ($query) {
                if (method_exists($query->getModel(), 'lead_committee_information')) {
                    $query->with('lead_committee_information');
                    $query->with('lead_committee_information.chairman_information');
                    $query->with('lead_committee_information.vice_chairman_information');
                    $query->with('lead_committee_information.members');
                    $query->with('lead_committee_information.members.sanggunian_member');
                }
            },
        ])
            ->where('reference_session_id', $id)
            ->orderBy('index', 'ASC')
            ->get();
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
