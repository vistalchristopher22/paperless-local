<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;

final class SessionDisplayController extends Controller
{
    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, $dates)
    {
        $dates = explode(separator: "&", string: $dates);
        return view('user.committee-meeting.session-display', [
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $scheduleRepository->groupedByDate($dates),
        ]);
    }
}
