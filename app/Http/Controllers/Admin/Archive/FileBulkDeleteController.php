<?php

namespace App\Http\Controllers\Admin\Archive;

use App\Http\Controllers\Controller;
use App\Services\ArchiveFileService;
use Illuminate\Http\Request;

final class FileBulkDeleteController extends Controller
{
    public function __construct(private ArchiveFileService $archiveFileService)
    {
    }

    public function __invoke(Request $request)
    {
        $data = array_filter($request->all());
        foreach ($data as $file) {
            $path = $file['directory'] . DIRECTORY_SEPARATOR . $file['name'];
            $this->archiveFileService->delete($path);
        }

        return response()->json(['message' => 'All files deleted successfully!']);
    }
}
