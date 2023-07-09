<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(BoardSessionRespository $boardSessionRepository, string $dates)
    {
        $dates = explode("&", $dates);
        $latestPublishedBoardSession = $boardSessionRepository->published();

        $filePath = CommitteeFileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($fileName));

        return view('admin.board-sessions.preview', [
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'dates' => $dates,
        ]);
    }
}
