<?php

namespace App\Pipes\Legislation;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateSponsors implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload['legislation']->sponsors()->sync($payload['sponsors']);
        return $next($payload);
    }
}
