<?php

namespace App\Pipes\Schedule;

use App\Utilities\FileUtility;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class GenerateRegularSessionChildDirectories implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {

        FileUtility::generateDirectories([
            $payload['root_directory'] . DIRECTORY_SEPARATOR . 'COMMITTEES',
            $payload['root_directory'] . DIRECTORY_SEPARATOR . 'SESSION',
            $payload['root_directory'] . DIRECTORY_SEPARATOR . 'COMMITTEES' . DIRECTORY_SEPARATOR . 'temp',
            $payload['root_directory'] . DIRECTORY_SEPARATOR . 'SESSION' . DIRECTORY_SEPARATOR . 'temp'
        ]);

        return $next($payload);
    }
}
