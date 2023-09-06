<?php

namespace App\Pipes\Resolution;

use App\Repositories\ResolutionRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateResolution implements IPipeHandler
{
    public function __construct()
    {
        $this->resolutionRepository = app()->make(ResolutionRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload['associate_data'] = $this->resolutionRepository->store([
            'file' => $payload['file'],
            'author' => $payload['author'],
            'co_author' => $payload['co_author'],
            'type' => $payload['type'],
            'session_date' => $payload['sessionDate'],
        ]);

        return $next($payload);
    }
}
