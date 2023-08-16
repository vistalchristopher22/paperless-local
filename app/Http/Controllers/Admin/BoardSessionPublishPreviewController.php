<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(BoardSessionRespository $boardSessionRepository, string $dates)
    {
        $session = $boardSessionRepository->fetchByDate($dates);
        if ($session) {
            return view('admin.board-sessions.preview', [
                'dates' => $dates,
                'orderBusinessView' => $session->file_path_view,
                'announcementTitle' => $session->announcement_title,
                'announcementContent' => $session->announcement_content,
            ]);
        }
        return abort(404);
    }
}
