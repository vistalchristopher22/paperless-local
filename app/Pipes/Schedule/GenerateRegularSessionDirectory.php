<?php

namespace App\Pipes\Schedule;

use App\Utilities\FileUtility;
use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class GenerateRegularSessionDirectory implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {

        $reference = $payload['reference'];

        $path = Storage::path('source') . DIRECTORY_SEPARATOR . Str::of($reference->number . ' Regular Session - ' .
                $reference->year)->replace([" ", "-"], "_")->upper();

        FileUtility::generateDirectory($path);

        $payload['root_directory'] = $path;

        return $next($payload);
    }
}
