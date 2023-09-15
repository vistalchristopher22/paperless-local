<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommitteeFileLinkRepository;

final class FileInspectController extends Controller
{
    public function __invoke(CommitteeFileLinkRepository $committeeFileLinkRepository, Request $request)
    {
        $fileLinkRecord = $committeeFileLinkRepository->getPublicLink($request->filename);
        return response()->json(['view_link' => $fileLinkRecord->view_link]);
    }
}
