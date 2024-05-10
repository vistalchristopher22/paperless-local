<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Models\BoardSession;
use App\Utilities\FileUtility;
use App\Services\UploadFileService;
use App\Contracts\Pipes\IPipeHandler;

final class FileUpload implements IPipeHandler
{
    protected UploadFileService $service;

    public function __construct()
    {
        $this->service = app()->make(UploadFileService::class);
    }

    private function updateFileLocation(BoardSession $session, string $location)
    {
        $session->file_path = $location;
        $session->save();
        $session->refresh();
    }

    public function handle(mixed $payload, Closure $next)
    {
        $session = $payload['session'];
        $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['file_path'], 'BOARD_SESSIONS'));
        $this->updateFileLocation($session, $location);
        return $next($payload);
    }
}
