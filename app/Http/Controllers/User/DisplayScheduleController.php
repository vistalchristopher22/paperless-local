<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;

final class DisplayScheduleController extends Controller
{
    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, string $dates)
    {
        $dates = explode('&', $dates);

        return view('user.schedule.index', [
            'schedules' => $scheduleRepository->groupedByDate($dates),
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
