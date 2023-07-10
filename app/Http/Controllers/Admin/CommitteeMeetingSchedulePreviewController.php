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
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->whereDay('date_and_time', date('d'))
            ->whereYear('date_and_time', date('Y'))
            ->get();

        $schedules = $allSchedules->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });

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
