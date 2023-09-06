<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Enums\ScreenDisplayStatus;
use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Models\ScreenDisplay;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

final class ScreenTableController extends Controller
{
    public function __construct(private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository, private readonly SettingRepository $settingRepository)
    {
    }

    public function __invoke(int $id)
    {
        $listDisplay = $this->screenDisplayRepository->getByReferenceSession($id);
        return view('admin.screen.screen-table', [
            'data' => $listDisplay,
            'settingRepository' => $this->settingRepository,
            'sanggunianMembers' => SanggunianMember::get(),
            'announcementRunningSpeed' => $this->settingRepository->getValueByName('announcement_running_speed'),
            'announcement' => $this->settingRepository->getValueByName('display_announcement'),
            'fontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'chairmanNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
            'membersNameFontSize' => $this->settingRepository->getValueByName('screen_font_size') ?? 1.9,
        ]);
    }
}
