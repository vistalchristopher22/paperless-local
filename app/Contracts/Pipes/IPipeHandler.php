<?php

namespace App\Contracts\Pipes;

use Closure;

interface IPipeHandler
{
    public function handle(mixed $payload, Closure $next);
}
