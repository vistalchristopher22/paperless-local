<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Models\ScreenDisplay;
use App\Repositories\ReferenceSessionRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;

final class ScreenController extends Controller
{
    public function __construct(private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository, private readonly SettingRepository $settingRepository)
    {
    }

    public function __invoke(int $id)
    {
        $data = ReferenceSession::with(['scheduleSessions', 'scheduleCommittees.committees', 'scheduleCommittees.committees.committee_invited_guests', 'scheduleCommittees.committees.lead_committee_information', 'scheduleSessions.board_sessions'])->find($id);
        $totalCommittees = 0;
        $totalSessions = 0;

        $data->scheduleCommittees->map(function ($schedule) use (&$totalCommittees) {
            $totalCommittees += $schedule->committees->count();
        });

        $data->scheduleSessions->map(function ($schedule) use (&$totalSessions) {
            $totalSessions += $schedule->board_sessions->count();
        });

        $totalDataToDisplay = $totalCommittees + $totalSessions;

        if (ScreenDisplay::where('reference_session_id', $data['id'])->count() !== $totalDataToDisplay) {
            $this->screenDisplayRepository->updateScreenDisplays($data);
        }

        $dataToPresent = $this->screenDisplayRepository->getCurrentScreenDisplay($data);

        $upNextData = $this->screenDisplayRepository->getUpNextScreenDisplay($data);

        return view('admin.screen.index', [
            'data' => $data,
            'dataToPresent' => $dataToPresent,
            'upNextData' => $upNextData,
            'sanggunianMembers' => SanggunianMember::get(),
            'announcementRunningSpeed' => $this->settingRepository->getValueByName('announcement_running_speed'),
            'announcement' => $this->settingRepository->getValueByName('display_announcement'),
            'fontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'chairmanNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'membersNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
        ]);
    }

}
