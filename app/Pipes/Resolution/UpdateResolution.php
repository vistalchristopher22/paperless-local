<?php

namespace App\Pipes\Resolution;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateResolution implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {

        $payload['legislation']->legislable->update([
            'type' => $payload['type'],
            'author' => $payload['author'],
            'session_date' => $payload['sessionDate'],
            'file' => $payload['file'] ?? $payload['legislation']->legislable->file,
        ]);

        return $next($payload);
    }
}
