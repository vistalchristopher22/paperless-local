<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Jobs\ExtractTextJob;
use App\Models\BoardSession;
use App\Contracts\Pipes\IPipeHandler;

final class ExtractTextFromWordDocument implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
       if(pathinfo($payload['session']['file_path'], PATHINFO_EXTENSION) === 'docx' ||  pathinfo($payload['session']['file_path'], PATHINFO_EXTENSION) === 'doc') {
           ExtractTextJob::dispatch($payload['session']['id'], BoardSession::class, $payload['session']['file_path']);
       }
        return $next($payload);
    }
}
