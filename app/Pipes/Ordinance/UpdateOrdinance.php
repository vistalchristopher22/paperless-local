<?php

namespace App\Pipes\Ordinance;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateOrdinance implements IPipeHandler
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
