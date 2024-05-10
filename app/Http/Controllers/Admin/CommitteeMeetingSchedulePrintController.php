<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\App;

final class CommitteeMeetingSchedulePrintController extends Controller
{
    public function __construct(private SettingRepository $settingRepository, private ScheduleRepository $scheduleRepository)
    {
    }

    public function __invoke(string $date)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('header-html', view('admin.committee-meeting.print-header'));
        $schedule = $this->scheduleRepository->findByDate($date);
        $pdf->loadView('admin.committee-meeting.print', [
            'schedule' => $this->scheduleRepository->findByDate($date),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
        ])->setPaper('legal')->setOption('enable-local-file-access', true)->setOrientation('portrait');
        return $pdf->stream();
    }
}
