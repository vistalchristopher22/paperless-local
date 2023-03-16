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


    public function handle(mixed $data, Closure $next)
    {
        Artisan::call('extract:file ' . $data->id);
        return $next($data);
    }
}
