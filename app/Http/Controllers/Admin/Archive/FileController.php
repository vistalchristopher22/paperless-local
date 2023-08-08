<?php

namespace App\Http\Controllers\Admin\Archive;

use App\Http\Controllers\Controller;
use App\Services\ArchiveFileService;
use App\Utilities\FileUtility;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FileController extends Controller
{
    public function __construct(private ArchiveFileService $archiveFileService)
    {
    }

    public function list(Request $request): JsonResponse
    {
        return response()->json($this->archiveFileService->getFileInDirectory($request->query('path')));
    }

    public function index()
    {
        return view('admin.archieve.files.index', [
            'source' => Storage::disk('source')->path('/'),
        ]);
    }

    public function show(Request $request)
    {
        $fileName = basename($request->path);
        $fileInformation = $this->archiveFileService->getFileDetails($request->directory, $fileName);
        return response()->json($fileInformation);
    }

    public function store(Request $request): JsonResponse
    {

        try {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = $originalFilename;

            $filename = FileUtility::addTimePrefixToFileName($filename);

            $filename = pathinfo($filename, PATHINFO_FILENAME);

            $filename = Str::of($filename)
                ->replace(" ", "_")
                ->upper()
                ->append('.')
                ->append($extension)
                ->value();

            $file->storeAs('source', $filename);
            $filePath = storage_path('app/source/' . $filename);
            $realPath = realpath($filePath);
            $mTime = filemtime($filePath);
            $fileSize = filesize($filePath);

            $response = [
                'message' => 'File uploaded successfully',
                'path' => storage_path('app/source/'),
                'fileName' => $filename,
                'fullPath' => $realPath,
                'mTime' => $mTime,
                'fileSize' => $fileSize,
            ];

            $code = Response::HTTP_OK;
        } catch (Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($response, $code);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $this->archiveFileService->rename($request->directory, $request->oldName, $request->newName);
            $response = ['message' => 'File renamed successfully'];
            $code = Response::HTTP_OK;
        } catch (Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($response, $code);
    }

    public function destroy(Request $request): JsonResponse
    {
        $path = $request->directory . DIRECTORY_SEPARATOR . $request->path;
        try {
            $this->archiveFileService->delete($path);
            $response = ['message' => 'File deleted successfully'];
            $code = Response::HTTP_OK;
        } catch (Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        return response()->json($response, $code);
    }

    public function filter(Request $request): JsonResponse
    {
        $fileInformation = $this->archiveFileService->getFilesByType($request->type, $request->directory);
        return response()->json($fileInformation);
    }

}
