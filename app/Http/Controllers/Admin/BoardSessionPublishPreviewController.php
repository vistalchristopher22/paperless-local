<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(BoardSessionRespository $boardSessionRepository, string $dates)
    {
        $dates = explode("&", $dates);
        $latestPublishedBoardSession = $boardSessionRepository->published();

        $filePath = FileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($fileName));

        return view('admin.board-sessions.preview', [
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'dates' => $dates,
        ]);
    }
}
