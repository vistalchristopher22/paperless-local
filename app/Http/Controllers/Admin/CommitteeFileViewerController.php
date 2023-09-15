<?php

namespace App\Http\Controllers\Admin;

use App\Utilities\FileUtility;
use App\Http\Controllers\Controller;
use App\Repositories\CommitteeFileLinkRepository;
use App\Services\FileLinkService;

final class CommitteeFileViewerController extends Controller
{
    public function __construct(private readonly CommitteeFileLinkRepository $committeeFileLink, private readonly FileLinkService $fileLinkService)
    {
    }

    public function __invoke(string $uuid)
    {
        $committeeFileLink = $this->committeeFileLink->getByUUID($uuid);
        $outputDirectory = FileUtility::publicDirectoryForViewing();

        if (!is_null($committeeFileLink->committee)) {
            $fileForViewing = $this->fileLinkService->generateFileForViewing($outputDirectory, $committeeFileLink->committee->file_path);
        } else {
            $fileForViewing = $this->fileLinkService->notHavingCommittee($outputDirectory, $committeeFileLink);
        }

        return view('admin.committee.file-displays.show', [
            'filePathForView' => $fileForViewing,
        ]);
    }
}
