<?php

namespace App\Pipes\Ordinance;

use App\Contracts\Services\IUploadService;
use App\Services\UploadFileService;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UploadFile implements IPipeHandler
{
    protected readonly IUploadService $uploadService;

    public function __construct()
    {
        $this->uploadService = app()->make(UploadFileService::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        if ($payload['attachment']) {
            $path = $this->uploadService->handle($payload['attachment'], 'LEGISLATIONS');
            $payload['file'] = $path;
        }
        return $next($payload);
    }
}
