<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Jobs\ConvertDocxToPDF;
use App\Jobs\ExtractTextJob;
use App\Models\Committee;
use App\Utilities\FileUtility;
use Closure;

final class ExtractFileText implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        if (isset($payload['file_path']) && $payload['file_path'] != null) {
            ConvertDocxToPDF::dispatch(
                $payload['file_path'],
                FileUtility::publicDirectoryForViewing()
            );

            ExtractTextJob::dispatch(
                $payload->id,
                Committee::class,
                FileUtility::draftCommitteesDirectory() . basename($payload['file_path'])
            );
        }

        $payload->refresh();

        return $next($payload);
    }
}
