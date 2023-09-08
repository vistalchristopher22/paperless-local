<?php

namespace App\Repositories;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Enums\ScheduleType;
use App\Enums\ScreenDisplayStatus;
use App\Models\ReferenceSession;
use App\Models\ScreenDisplay;
use Exception;

final class ScreenDisplayRepository extends BaseRepository implements ScreenDisplayRepositoryInterface
{
    public function __construct(ScreenDisplay $model)
    {
        parent::__construct($model);
    }

    /**
     * @throws Exception
     */
    public function updateScreenDisplays(ReferenceSession $data, $totalDataToDisplay)
    {

        // get the ongoing
        $onGoing = $this->model::where([
            'reference_session_id' => $data['id'],
            'status' => ScreenDisplayStatus::ON_GOING,
        ])->first();

        // get the next
        $next = $this->model::where([
            'reference_session_id' => $data['id'],
            'status' => ScreenDisplayStatus::NEXT,
        ])->first();

        // get the done
        $doneIds = $this->model::where([
            'reference_session_id' => $data['id'],
            'status' => ScreenDisplayStatus::DONE,
        ])->get();

        if ($onGoing?->count() == 0 && $next?->count() == 0 && $doneIds?->count() == 0) {
            $key = 1;
            if ($data->scheduleSessions->count() !== 0) {
                foreach ($data->scheduleSessions as $scheduleSession) {
                    foreach ($scheduleSession->board_sessions as $boardSession) {
                        $this->updateOrCreateScreenDisplay($data, $scheduleSession->id, $boardSession, ScheduleType::SESSION, ScreenDisplayStatus::ON_GOING, $key);
                        $key++;
                    }
                }

                foreach ($data->scheduleCommittees as $scheduleCommittees) {
                    foreach ($scheduleCommittees->committees as $committee) {
                        $status = ($key == 2) ? ScreenDisplayStatus::NEXT : ScreenDisplayStatus::PENDING;
                        $this->updateOrCreateScreenDisplay($data, $scheduleCommittees->id, $committee, ScheduleType::MEETING, $status, $key);
                        $key++;
                    }
                }
            } else {
                $committeeIndex = 1;
                foreach ($data->scheduleCommittees as $scheduleCommittees) {
                    foreach ($scheduleCommittees->committees as $committee) {
                        if ($committeeIndex === 1) {
                            $status = ScreenDisplayStatus::ON_GOING;
                        } else if ($committeeIndex == 2) {
                            $status = ScreenDisplayStatus::NEXT;
                        } else {
                            $status = ScreenDisplayStatus::PENDING;
                        }
                        $this->model::create([
                            'reference_session_id' => $data['id'],
                            'schedule_id' => $scheduleCommittees->id,
                            'screen_displayable_id' => $committee->id,
                            'screen_displayable_type' => get_class($committee),
                            'index' => $committeeIndex,
                            'type' => ScheduleType::MEETING,
                            'status' => $status,
                        ]);
                        $committeeIndex++;
                    }
                }
            }
        } else {
            $this->model::where([
                'reference_session_id' => $data['id'],
            ])->delete();

            $key = 1;
            if ($data->scheduleSessions->count() !== 0) {
                foreach ($data->scheduleSessions as $scheduleSession) {
                    foreach ($scheduleSession->board_sessions as $boardSession) {
                        $status = ScreenDisplayStatus::DONE;
                        
                        if ($boardSession->id == $onGoing->screen_displayable_id && $onGoing->screen_displayable_type == get_class($boardSession)) {
                            $status = ScreenDisplayStatus::ON_GOING;
                        } else if ($boardSession->id == $next->screen_displayable_id && $next->screen_displayable_type == get_class($boardSession)) {
                            $status = ScreenDisplayStatus::NEXT;
                        }

                        $doneIds->each(function ($doneRecord) use ($boardSession, &$status) {
                            if ($boardSession->id == $doneRecord->screen_displayable_id && $doneRecord->screen_displayable_type == get_class($boardSession)) {
                                $status = ScreenDisplayStatus::DONE;
                            }
                        });

                        $this->model::create([
                            'reference_session_id' => $data['id'],
                            'schedule_id' => $scheduleSession->id,
                            'screen_displayable_id' => $boardSession->id,
                            'screen_displayable_type' => get_class($boardSession),
                            'index' => $key,
                            'type' => ScheduleType::SESSION,
                            'status' => $status,
                        ]);

                        $key++;
                    }
                }
            }

            foreach ($data->scheduleCommittees as $scheduleCommittees) {
                foreach ($scheduleCommittees->committees as $committee) {
                    $status = ScreenDisplayStatus::PENDING;

                    if ($committee->id == $onGoing?->screen_displayable_id && $onGoing?->screen_displayable_type == get_class($committee)) {
                        $status = ScreenDisplayStatus::ON_GOING;
                    } else if ($committee->id == $next?->screen_displayable_id && $next?->screen_displayable_type == get_class($committee)) {
                        $status = ScreenDisplayStatus::NEXT;
                    }

                    $doneIds->each(function ($doneRecord) use ($committee, &$status) {
                        if ($committee->id == $doneRecord->screen_displayable_id && $doneRecord?->screen_displayable_type == get_class($committee)) {
                            $status = ScreenDisplayStatus::DONE;
                        }
                    });

                    $this->model::create([
                        'reference_session_id' => $data['id'],
                        'schedule_id' => $scheduleCommittees->id,
                        'screen_displayable_id' => $committee->id,
                        'screen_displayable_type' => get_class($committee),
                        'index' => $key,
                        'type' => ScheduleType::MEETING,
                        'status' => $status,
                    ]);
                    $key++;
                }
            }
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
        $this->model::create([
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
