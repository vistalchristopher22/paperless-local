<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ScheduleType;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Models\ReferenceSession;
use App\Http\Controllers\Controller;
use App\Models\BoardSession;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\BoardSessionRespository;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(string $dates)
    {
        $date = Carbon::parse($dates);
        $schedule = Schedule::with('board_sessions')
                            ->whereYear('date_and_time', $date->year)
                            ->whereMonth('date_and_time', $date->month)
                            ->whereDay('date_and_time', $date->day)
                            ->where('type', ScheduleType::SESSION)
                            ->first();

        if(!$schedule?->board_sessions->isEmpty()) {
            $session = $schedule->board_sessions->first();
        }

        if(Str::contains(url()->previous(), 'preview')) {
            $committeeUrl = route('committee-meeting-schedule.preview', $dates);
        } else {
            $committeeUrl = route('scheduled.committee-meeting.today', $dates);
        }
        
        $outputDirectory = FileUtility::publicDirectoryForViewing();
        $location = FileUtility::correctDirectorySeparator($session->file_path);
        Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

        if ($session) {
            return view('admin.board-sessions.preview', [
                'dates' => $dates,
                'orderBusinessView' => $session->file_path_view,
                'announcementTitle' => $session->announcement_title,
                'announcementContent' => $session->announcement_content,
                'committeeUrl' => $committeeUrl,
            ]);
        }
        return abort(404);
    }
}
