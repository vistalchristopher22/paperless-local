<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use Closure;

final class DeleteFileUpload implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {

        $payload['file_name'] = basename($payload['file_path']);
        unlink(storage_path('app/public/board-sessions/'.$payload['file_name']));

        return $next($payload);
    }
}
