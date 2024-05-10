<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CommitteeFileLinkRepository;

final class CommitteeFileViewerController extends Controller
{
    public function __construct(private readonly CommitteeFileLinkRepository $committeeFileLinkRepository)
    {
    }

    public function __invoke(string $uuid)
    {
        $committeeFileLink = $this->committeeFileLinkRepository->getByUUID($uuid);

        if ($committeeFileLink?->public_path) {
            $file = str()->after($committeeFileLink->public_path, 'public');

            $schedule = $committeeFileLink?->committee?->schedule_information;

            return inertia('CommitteeLink', [
                'file' => basename($file),
                'watermarkSchedule' => $schedule?->reference_session . ' ' . $schedule?->type,
            ]);
        } else {
            return view('errors.attachment-not-found');
        }
    }
}
