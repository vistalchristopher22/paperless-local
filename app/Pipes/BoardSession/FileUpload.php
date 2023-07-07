<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Services\UploadFileService;
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
            $session->file_path = $this->service->handle($payload['file_path'], 'board-sessions');
            $session->save();
            return $next($payload);
        }

        return $next($payload);
    }
}
