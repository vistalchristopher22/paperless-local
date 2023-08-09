<?php

namespace App\Pipes\Legislation;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateSponsors implements IPipeHandler
{


    public function handle(mixed $payload, Closure $next)
    {
        $legislation = $payload['legislation'];
        $legislation->sponsors()->attach($payload['sponsors']);
        return $next($payload);
    }
}
