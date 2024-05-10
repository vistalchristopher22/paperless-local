<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoardSession;
use App\Utilities\FileUtility;
use App\Http\Controllers\Controller;

final class BoardSessionDownloadController extends Controller
{
    public function __invoke(int $id)
    {
        $boardSession = BoardSession::find($id, ['id', 'file_path']);
        return response()->download(FileUtility::correctDirectorySeparator($boardSession->file_path), removeTimestampPrefix(basename($boardSession->file_path)));
    }
}
