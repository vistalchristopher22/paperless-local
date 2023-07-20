<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanggunianMember;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;

final class CommitteeMeetingSchedulePreviewController extends Controller
{
    public function __invoke(ScheduleRepository $scheduleRepository, string $dates)
    {
        $dates = explode('&', $dates);
        $allSchedules = Schedule::with(['committees:id,schedule_id,lead_committee,expanded_committee,display_index', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
            ->where(function ($query) use ($dates) {
                foreach ($dates as $date) {
                    $day = date('d', strtotime($date));
                    $query->orWhereDay('date_and_time', $day);
                }
            })
            ->where(function ($query) use ($dates) {
                foreach ($dates as $date) {
                    $month = date('m', strtotime($date));
                    $query->orWhereMonth('date_and_time', $month);
                }
            })
            ->where(function ($query) use ($dates) {
                foreach ($dates as $date) {
                    $year = date('Y', strtotime($date));
                    $query->orWhereYear('date_and_time', $year);
                }
            })
            ->where('type', 'committee')
            ->orderBy('with_invited_guest', 'DESC')
            ->get();

        $schedules = $allSchedules->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });

        $schedules = $schedules->sort();

        $leadCommitteeIds = $allSchedules->map(function ($schedule) {
            return $schedule->committees->pluck('lead_committee')->toArray();
        })->flatten()->toArray();

        $expandedCommitteeIds = $allSchedules->map(function ($schedule) {
            return $schedule->committees->pluck('expanded_committee')->toArray();
        })->flatten()->toArray();


        $sanggunianMembers = SanggunianMember::with([
            'agenda_chairman' => function ($query) use ($leadCommitteeIds) {
                $query->whereIn('id', $leadCommitteeIds);
            },
            'agenda_vice_chairman' => function ($query) use ($leadCommitteeIds) {
                $query->whereIn('id', $leadCommitteeIds);
            },
            'agenda_member' => function ($query) use ($leadCommitteeIds) {
                $query->whereIn('agenda_id', $leadCommitteeIds);
            },
            'agenda_member.agenda',
            'expanded_agenda_chairman' => function ($query) use ($expandedCommitteeIds) {
                $query->whereIn('id', $expandedCommitteeIds);
            },
            'expanded_agenda_vice_chairman' => function ($query) use ($expandedCommitteeIds) {
                $query->whereIn('id', $expandedCommitteeIds);
            },
            'expanded_agenda_member' => function ($query) use ($expandedCommitteeIds) {
                $query->whereIn('agenda_id', $expandedCommitteeIds);
            },
            'expanded_agenda_member.agenda',
        ])->get();

        $sanggunianMembers = $sanggunianMembers->filter(function ($record) {
            return
                !$record->agenda_chairman->isEmpty() or
                !$record->agenda_vice_chairman->isEmpty() or
                !$record->agenda_member->isEmpty() or
                !$record->expanded_agenda_chairman->isEmpty() or
                !$record->expanded_agenda_vice_chairman->isEmpty() or !$record->expanded_agenda_member->isEmpty();
        });


        return view('admin.committee-meeting.preview', [
            'members' => $sanggunianMembers,
            'schedules' => $schedules,
            'dates' => implode('&', $dates)
        ]);
    }
}
