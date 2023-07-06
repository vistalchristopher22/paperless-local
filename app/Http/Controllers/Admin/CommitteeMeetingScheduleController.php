<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\CommitteeMeetingRepository;

final class CommitteeMeetingScheduleController extends Controller
{
    public function __construct(private SettingRepository $settingRepository, private ScheduleRepository $scheduleRepository)
    {
    }

    public function store(CommitteeMeetingRepository $committeeMeetingRepository, Request $request)
    {
        $data = $request->all();
        $committeeMeetingRepository->addCommitteeMeetingToSchedule(scheduleId: $data['parent'], data: $data);
        return response()->json(['success' => true]);
    }

    public function show(string $dates)
    {
        $dates = explode("&", $dates);
        return view('admin.committee-meeting.show', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }

    public function preview(string $dates)
    {
        $dates = explode("&", $dates);
        return view('admin.committee-meeting.preview', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'dates' => implode('&', $dates),
        ]);
    }
}
