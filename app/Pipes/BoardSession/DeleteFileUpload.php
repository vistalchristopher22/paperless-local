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
        if (isset($payload['file_path'])) {
            $payload['file_name'] = basename($payload['file_path']);
            unlink($payload['file_path']);
        }

        return $next($payload);
    }
}
