<?php

namespace App\Pipes\BoardSession;

use App\Utilities\FileUtility;
use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\Artisan;

final class GeneratePDFDocumentForViewing implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        if (!$payload['file_updated']) {
            $session = $payload['boardSession'] ?? $payload['session'];
            $outputDirectory = FileUtility::publicDirectoryForViewing();
            $location = FileUtility::correctDirectorySeparator($session->file_path);
            Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');
            $session->file_path_view = FileUtility::generatePathForViewing($outputDirectory, basename($location));
            $session->save();
        }

        return $next($payload);
    }
}
