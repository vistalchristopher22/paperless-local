<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;

final class DisplayScheduleController extends Controller
{
    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, string $dates)
    {
        $arrayDates = explode(separator: "&", string: $dates);
        $records = $scheduleRepository->groupedByDate($arrayDates);

        $recordTypes = $records->pluck('*.type')->flatten()->flip();

        if ($recordTypes->has('session') && !$recordTypes->has('committee')) {
            return to_route("user.committee-meeting.schedule.show.session-only", $dates);
        }

        if ($recordTypes->has('session') && $recordTypes->has('committee')) {
            return to_route("user.committee-meeting.schedule.show.committees-and-session", $dates);
        }

        return view('user.schedule.index', [
            'schedules' => $records->sort(),
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $arrayDates),
        ]);
    }


}
