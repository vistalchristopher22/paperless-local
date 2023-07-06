<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;

final class CommitteeMeetingSchedulePrintController extends Controller
{

    public function __construct(private SettingRepository $settingRepository, private ScheduleRepository $scheduleRepository)
    {
    }

    public function __invoke(string $dates)
    {
        $dates = explode("&", $dates);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('header-html', view('admin.committee-meeting.print-header'));
        $pdf->loadView('admin.committee-meeting.print', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ])->setPaper('legal')->setOption('enable-local-file-access', true)->setOrientation('portrait');

        return $pdf->stream();
    }
}
