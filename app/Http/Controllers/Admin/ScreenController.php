<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Models\ScreenDisplay;

final class ScreenController extends Controller
{
    public function __construct(private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository, private readonly SettingRepository $settingRepository)
    {
    }

    public function __invoke(int $id)
    {

        $schedule = Schedule::with(['order_of_business_information', 'committees', 'schedule_venue'])->find($id);

        $totalCommittees = $schedule->committees()->count();
        $totalSessions = $schedule->order_of_business_information()->count();

        $totalDataToDisplay = $totalCommittees + $totalSessions;

        $dataToPresent = $this->screenDisplayRepository->getCurrentScreenDisplay($schedule);

        $upNextData =  ScreenDisplay::with([
            'schedule' => [
                'order_of_business_information', 'committees', 'schedule_venue'
            ],
        ])
            ->where('schedule_id', $id)
            ->where('index', $dataToPresent->index + 1)
            ->first();



        return view('admin.screen.index', [
            'dataToPresent' => $dataToPresent,
            'upNextData' => $upNextData,
            'schedule' => $schedule,
            'sanggunianMembers' => SanggunianMember::get(),
            'announcementRunningSpeed' => $this->settingRepository->getValueByName('announcement_running_speed'),
            'announcement' => $this->settingRepository->getValueByName('display_announcement'),
            'fontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'chairmanNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'membersNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
        ]);
    }
}
