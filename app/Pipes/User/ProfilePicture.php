<?php

namespace App\Pipes\User;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class ProfilePicture implements IPipeHandler
{
    public function __construct()
    {
        // Inject service
    }

    
    public function handle(mixed $payload, Closure $next)
    {
        // Handle the incoming payload

        return $next($payload);
    }
}
