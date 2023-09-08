<?php

namespace App\Pipes\Committee;

use Closure;
use App\Services\CommitteeService;
use App\Services\UploadFileService;
use App\Contracts\Pipes\IPipeHandler;

final class UploadFile implements IPipeHandler
{
    private CommitteeService $committeeService;


    public function __construct()
    {
        $this->committeeService = app()->make(CommitteeService::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $data = $this->committeeService->uploadFile($payload, new UploadFileService());
        return $next($data);
    }
}
