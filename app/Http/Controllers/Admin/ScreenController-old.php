<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Repositories\SettingRepository;

final class ScreenController extends Controller
{
    public function __construct(private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository, private readonly SettingRepository $settingRepository)
    {
    }

    public function __invoke(int $id)
    {
        $data = ReferenceSession::with(['scheduleSessions', 'scheduleCommittees.committees', 'scheduleCommittees.committees.lead_committee_information', 'scheduleSessions.board_sessions'])->find($id);

        $this->screenDisplayRepository->updateScreenDisplays($data);

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
