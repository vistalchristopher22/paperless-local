<?php

namespace App\Pipes\Legislation;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateSponsors implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {

        if (array_key_exists('sponsors', $payload)) {
            $payload['sponsors'] = array_filter($payload['sponsors']);
            if (isset($payload['sponsors'])) {
                $legislation = $payload['legislation'];
                $legislation->sponsors()->attach($payload['sponsors']);
            }
        }

        return $next($payload);
    }
}
