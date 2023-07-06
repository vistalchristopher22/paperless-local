<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

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
        $dates = explode('&', $dates);

        return view('admin.committee-meeting.show', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
