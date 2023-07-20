<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class CommitteeMeetingScheduleController extends Controller
{
    public function __construct(private readonly SettingRepository $settingRepository, private readonly ScheduleRepository $scheduleRepository)
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
        $arrayDates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($arrayDates);

        $recordTypes = $records->pluck('*.type')->flatten()->flip();

        if ($recordTypes->has('session') && !$recordTypes->has('committee')) {
            return to_route("committee-meeting.schedule.show.session-only", $dates);
        }

        if ($recordTypes->has('session') && $recordTypes->has('committee')) {
            return to_route("committee-meeting.schedule.show.committees-and-session", $dates);
        }

        return view('admin.committee-meeting.show', [
            'schedules' => $records->sort(),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $arrayDates),
        ]);

    }

    public function sessions($dates): View
    {
        $dates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($dates);
        return view('admin.committee-meeting.session-display', [
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $records,
        ]);
    }


    public function committeesAndSession($dates): View
    {
        $dates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($dates);
        $groupByDateAndType = $records->map(fn ($record) => $record->groupBy(fn ($data) => $data->type . " | " . $data->venue));
        $groupByDateAndType = $groupByDateAndType->sortBy(fn ($item, $key) => strtotime($key));

        return view('admin.committee-meeting.session-and-committee-display', [
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $records,
            'groupByDateAndType' => $groupByDateAndType,
        ]);
    }

}
