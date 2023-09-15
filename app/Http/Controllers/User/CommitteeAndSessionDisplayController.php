<?php

namespace App\Http\Controllers\User;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;

final class CommitteeAndSessionDisplayController extends Controller
{

    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, $dates)
    {
        $dates = explode(separator: "&", string: $dates);
        $records = $scheduleRepository->groupedByDate($dates);
        $groupByDateAndType = $records->map(fn ($record) => $record->groupBy(fn ($data) => $data->type . " | " . $data->venue));
        $groupByDateAndType = $groupByDateAndType->sortBy(fn ($item, $key) => strtotime($key));

        return view('user.committee-meeting.session-and-committee-display', [
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $records,
            'groupByDateAndType' => $groupByDateAndType,
        ]);
    }
}
