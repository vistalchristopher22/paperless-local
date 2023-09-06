<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Repositories\BoardSessionRespository;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(BoardSessionRespository $boardSessionRepository, string $dates)
    {
        $session = $boardSessionRepository->fetchByDate($dates);
        if(!$session) {
            $data = ReferenceSession::with(['scheduleSessions'])->latest()->first();
            $session = $data->scheduleSessinos->first();
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
