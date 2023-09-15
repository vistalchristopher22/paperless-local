<?php

namespace App\Http\Controllers\Admin;

use App\Utilities\FileUtility;
use App\Models\ReferenceSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

final class ScheduledOrderBusinessController extends Controller
{
    public function __invoke()
    {
        $latestReferenceSession = ReferenceSession::with('scheduleSessions')->whereHas('scheduleSessions')->whereHas('scheduleSessions.board_sessions')->orderBy('number', 'DESC')->first();
        $session = $latestReferenceSession?->scheduleSessions?->first()?->board_sessions->first();

        $outputDirectory = FileUtility::publicDirectoryForViewing();
        $location = FileUtility::correctDirectorySeparator($session->file_path);
        Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

        return view('admin.board-sessions.display', [
            'orderBusinessView' => $session->file_path_view,
            'announcementTitle' => $session->announcement_title,
            'announcementContent' => $session->announcement_content,
        ]);
    }
}
