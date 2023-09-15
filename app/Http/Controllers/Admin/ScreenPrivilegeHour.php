<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Repositories\SettingRepository;

final class ScreenPrivilegeHour extends Controller
{
    public function __invoke(int $id)
    {
        $settingRepository = app()->make(SettingRepository::class);

        $data = ReferenceSession::with([
            'scheduleSessions',
        ])->find($id);

        $session = $data?->scheduleSessions?->first();

        return view('admin.screen.screen-privilege-hour', [
            'data' => $data,
            'dataToPresent' => $session,
            'selectedPrivilegeHourMember' => SanggunianMember::find($settingRepository->getValueByName('privilege_hour_member')),
            'announcementRunningSpeed' => $settingRepository->getValueByName('announcement_running_speed'),
            'announcement' => $settingRepository->getValueByName('display_announcement'),
            'guestFullName' => $settingRepository->getValueByName('question_of_hour_guest'),
            'fontSize' => $settingRepository->getValueByName('question_of_hour_font_size') ?? 1.9,
        ]);
    }
}
