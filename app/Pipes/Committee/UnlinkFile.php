<?php

namespace App\Pipes\Committee;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UnlinkFile implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        unlink($payload->file_path);
        return $next($payload);
    }
}
