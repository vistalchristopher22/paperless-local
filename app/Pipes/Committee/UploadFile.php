<?php

namespace App\Pipes\Committee;

use Closure;
use App\Models\FileLinks;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Services\CommitteeService;
use App\Services\UploadFileService;
use App\Contracts\Pipes\IPipeHandler;
use App\Models\CommitteeFileLink;
use Illuminate\Support\Facades\Artisan;

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
