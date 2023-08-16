<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleGuest;
use App\Repositories\ScheduleGuestRepository;
use Illuminate\Http\Request;

final class InvitedGuestsController extends Controller
{
    public function __invoke(ScheduleGuestRepository $scheduleGuestRepository)
    {
        return view('admin.invited-guests.index', [
            'guests' => $scheduleGuestRepository->get()->load(['schedule:id,date_and_time,description,venue,reference_session_id', 'schedule.regular_session:id,number,year']),
        ]);
    }
}
