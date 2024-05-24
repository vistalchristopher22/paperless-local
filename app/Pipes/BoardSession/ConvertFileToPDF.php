<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Jobs\ConvertDocxToPDF;
use App\Utilities\FileUtility;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\File;
final class ConvertFileToPDF implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        $location = $payload['session']['file_path'];
        if(pathinfo($payload['session']['file_path'], PATHINFO_EXTENSION) !== 'pdf') {
            ConvertDocxToPDF::dispatch(FileUtility::isInputDirectoryEscaped($location), FileUtility::publicDirectoryForViewing());
        } else {
        }
        return $next($payload);
    }
}
