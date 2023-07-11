<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Services\UploadFileService;
use App\Utilities\FileUtility;
use Closure;

final class FileUpload implements IPipeHandler
{
    protected UploadFileService $service;

    public function __construct()
    {
        $this->service = app()->make(UploadFileService::class);
    }

    public function handle(mixed $payload, Closure $next)
    {

        if (request()->has('file_path')) {
            $session = $payload['boardSession'] ?? $payload['session'];
            $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['file_path'], 'BOARD_SESSIONS'));
            $session->file_path = $location;
            $session->save();
        }


        if (request()->has('unassigned_business')) {
            $session = $payload['boardSession'] ?? $payload['session'];
            $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['unassigned_business'], 'UNASSIGNED_BUSINESS'));
            $session->unassigned_business_file_path = $location;
            $session->save();
        }

        return $next($payload);
    }
}
