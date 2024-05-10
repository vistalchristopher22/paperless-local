<?php

namespace App\Http\Controllers\Admin;

use App\Utilities\FileUtility;
use App\Services\FileLinkService;
use App\Http\Controllers\Controller;
use App\Models\BoardSessionCommitteeLink;

final class BoardSessionFileViewController extends Controller
{
    public function __construct(private readonly FileLinkService $fileLinkService)
    {
    }

    public function __invoke(string $uuid)
    {
        $fileLink = BoardSessionCommitteeLink::with(['board_session'])->where('uuid', $uuid)->first();

        $session = $fileLink->board_session;
        $schedule = $session?->schedule_information;

        if ($session) {
            $orderBusinessView = str_replace(pathinfo(basename($session->file_path), PATHINFO_EXTENSION), 'pdf', $session->file_path);
            return inertia('OrderBusiness', [
                'file'              => basename($orderBusinessView),
                'id'                => $session->id,
                'watermarkSchedule' => $schedule?->reference_session . ' ' . $schedule?->type,
            ]);
        }

        return view('errors.attachment-not-found');
        // $outputDirectory = FileUtility::publicDirectoryForViewing();

        // if (!is_null($fileLink->board_session)) {
        //     if (file_exists($fileLink->board_session->file_path)) {
        //         $fileForViewing = $this->fileLinkService->generateFileForViewing($outputDirectory, $fileLink->board_session->file_path);
        //     }
        // } else {
        //     if (file_exists($fileLink->public_path)) {
        //         $fileForViewing = $this->fileLinkService->generateFileForViewing($outputDirectory, $fileLink->public_path);
        //     } else {
        //         $fileForViewing = $this->fileLinkService->notHavingCommittee($outputDirectory, $fileLink);
        //     }
        // }

        // return view('admin.board-sessions.show', [
        //     'filePathForView' => $fileForViewing,
        // ]);
    }
}
