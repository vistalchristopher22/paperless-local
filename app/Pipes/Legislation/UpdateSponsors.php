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
        if (array_key_exists('sponsors', $payload)) {
            if (!is_array($payload['sponsors'])) {
                $payload['sponsors'] = json_decode($payload['sponsors'], true);
            }
            $payload['sponsors'] = array_filter($payload['sponsors']);

            if (isset($payload['sponsors'])) {
                $payload['legislation']->sponsors()->sync($payload['sponsors']);
            }
        }
        return $next($payload);
    }
}
