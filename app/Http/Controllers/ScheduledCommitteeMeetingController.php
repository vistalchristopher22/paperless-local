<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;

final class ScheduledCommitteeMeetingController extends Controller
{
    public function __invoke()
    {
        $dates = date('Y-m-d H:i:s');
        $dates = explode("&", $dates);

        $allSchedules = Schedule::with(['committees:id,schedule_id,lead_committee,expanded_committee,display_index,invited_guests', 'committees.lead_committee_information', 'committees.expanded_committee_information', 'committees.committee_invited_guests'])
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->whereDay('date_and_time', date('d'))
            ->whereYear('date_and_time', date('Y'))
            ->where('type', 'committee')
            ->get();

        if($allSchedules->count() === 0) {
            return redirect()->route('login');
        }


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

        if ($allSchedules->count() === 0) {
            $latestCommittees = ReferenceSession::with('scheduleCommittees')->whereHas('scheduleCommittees')->whereHas('scheduleCommittees.committees')->orderBy('number', 'DESC')->first();
            $schedules = $latestCommittees->scheduleCommittees->groupBy(function ($record) {
                return $record->date_and_time->format('Y-m-d');
            });

            $schedules = $latestCommittees->scheduleCommittees->groupBy(function ($record) {
                return $record->date_and_time->format('Y-m-d');
            });

            $leadCommitteeIds = $latestCommittees->scheduleCommittees->map(function ($schedule) {
                return $schedule->committees->pluck('lead_committee')->toArray();
            })->flatten()->toArray();

            $expandedCommitteeIds = $latestCommittees->scheduleCommittees->map(function ($schedule) {
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

            return view('sp-committee-sched-meeting', [
                'members' => $sanggunianMembers,
                'schedules' => $schedules,
                'dates' => implode('&', $dates)
            ]);
        } else {
            return view('sp-committee-sched-meeting', [
                'members' => $sanggunianMembers,
                'schedules' => $schedules,
                'dates' => implode('&', $dates)
            ]);
        }
    }
}
