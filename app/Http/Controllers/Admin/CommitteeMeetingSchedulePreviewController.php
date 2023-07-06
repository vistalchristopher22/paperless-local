<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ScheduleRepository;

final class CommitteeMeetingSchedulePreviewController extends Controller
{
    public function __invoke(ScheduleRepository $scheduleRepository, string $dates)
    {
        $dates = explode("&", $dates);
        return view('admin.committee-meeting.preview', [
            'schedules' => $scheduleRepository->groupedByDate($dates),
            'dates' => implode('&', $dates),
        ]);
    }
}
