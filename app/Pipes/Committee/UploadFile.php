<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Services\CommitteeService;
use App\Services\UploadFileService;
use Closure;

final class UploadFile implements IPipeHandler
{
    private CommitteeService $committeeService;

    public function __construct()
    {
        $this->committeeService = app()->make(CommitteeService::class);
    }

    public function handle(mixed $data, Closure $next)
    {
        $data = $this->committeeService->uploadFile($data, new UploadFileService());
        return $next($data);
    }
}
