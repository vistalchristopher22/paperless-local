<?php

namespace App\Contracts\Pipes;

use Closure;

interface IPipeHandler
{
    public function __construct();
    public function handle(mixed $data, Closure $next);
}
