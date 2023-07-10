<?php

namespace App\Http\Controllers;

use App\Models\Schedule;

final class LandingPageController extends Controller
{
    public function __invoke()
    {
        $allSchedules = Schedule::with(['committees:id,schedule_id,lead_committee,expanded_committee,display_index', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
            ->orderBy('with_invited_guest', 'DESC')
            ->orderBy('date_and_time', 'ASC')
            ->whereDay('date_and_time', date('d'))
            ->whereYear('date_and_time', date('Y'))
            ->get();

        if ($allSchedules->count()) {
            return to_route("scheduled.committee-meeting.today");
        }

        return to_route("login");
    }
}
