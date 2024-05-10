<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Jobs\ConvertDocxToPDF;
use App\Utilities\FileUtility;
use App\Contracts\Pipes\IPipeHandler;

final class ConvertFileToPDF implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        $location = $payload['session']['file_path'];
        ConvertDocxToPDF::dispatch(FileUtility::isInputDirectoryEscaped($location), FileUtility::publicDirectoryForViewing());
        return $next($payload);
    }
}
