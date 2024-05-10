<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoardSession;
use App\Jobs\ConvertDocxToPDF;
use App\Utilities\FileUtility;
use App\Http\Controllers\Controller;

final class UpdateOrderofBusinessAttachmentController extends Controller
{
    public function __invoke(int $id)
    {
        $boardSession = BoardSession::find($id, ['id', 'file_path']);
        ConvertDocxToPDF::dispatch(FileUtility::isInputDirectoryEscaped($boardSession->file_path), FileUtility::publicDirectoryForViewing())->delay(now()->addSeconds(2));
        return response()->json($boardSession);
    }
}
