<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Pipes\Screen\UpdateAnnouncement;
use Illuminate\Support\Facades\Pipeline;
use App\Pipes\Screen\UpdateScreenDisplay;
use App\Pipes\Screen\UpdatePrivilegeHourMember;
use App\Pipes\Screen\UpdateAnnouncementRunningSpeed;
use App\Pipes\Screen\UpdateQuestionVisitorHourGuest;
use App\Pipes\Screen\UpdateQuestionVisitorHourFontSize;
use App\Pipes\Screen\UpdateCommitteeMeetingScreenFontSize;

final class ScreenOperateController extends Controller
{
    public function __invoke(Request $request, SettingRepository $settingRepositry)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    UpdateAnnouncement::class,
                    UpdateCommitteeMeetingScreenFontSize::class,
                    UpdateAnnouncementRunningSpeed::class,
                    UpdateQuestionVisitorHourFontSize::class,
                    UpdateQuestionVisitorHourGuest::class,
                    UpdatePrivilegeHourMember::class,
                    UpdateScreenDisplay::class,
                ])->then(fn ($_) => back()->with('success', 'Updated Successfully!'));
        });
    }
}
