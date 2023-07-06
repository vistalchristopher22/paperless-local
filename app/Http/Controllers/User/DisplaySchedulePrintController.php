<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\App;

final class DisplaySchedulePrintController extends Controller
{
    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, string $dates)
    {
        $dates = explode('&', $dates);

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('header-html', view('admin.committee-meeting.print-header'));
        $pdf->loadView('admin.committee-meeting.print', [
            'schedules' => $scheduleRepository->groupedByDate($dates),
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
        ]);

        $pdf->setPaper('legal');
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOrientation('portrait');

        return $pdf->stream();
    }
}
