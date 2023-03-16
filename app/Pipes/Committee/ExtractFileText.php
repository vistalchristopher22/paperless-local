<?php

namespace App\Pipes\Committee;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\Artisan;

final class ExtractFileText implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        Artisan::call('extract:file ' . $payload->id);
        return $next($payload);
    }
}
