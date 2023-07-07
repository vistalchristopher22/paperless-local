<?php

namespace App\Http\Controllers\Admin\Archive;

use App\Http\Controllers\Controller;
use App\Services\ArchiveFileService;
use Illuminate\Http\Request;

final class FilePreviewController extends Controller
{
    public function __construct(private ArchiveFileService $archiveFileService)
    {
    }

    public function __invoke(Request $request)
    {

        $currentDirectory = $request->path . DIRECTORY_SEPARATOR . $request->fileName;
        $destination = public_path("storage/previews/{$request->fileName}");

        try {
            $this->archiveFileService->copy($currentDirectory, $destination);
            $response = ['message' => 'File copied successfully', 'destination' => url('/') . "/storage/previews/{$request->fileName}"];
            $code = 200;
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = 422;
        }

        return response()->json($response, $code);
    }
}
