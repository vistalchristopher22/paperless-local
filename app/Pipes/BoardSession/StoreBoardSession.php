<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\BoardSessionRespository;
use Closure;

final class StoreBoardSession implements IPipeHandler
{
    protected BoardSessionRespository $boardSessionRepository;

    public function __construct()
    {
        $this->boardSessionRepository = app()->make(BoardSessionRespository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $session = $this->boardSessionRepository->store([
            'title' => $payload['title'],
            'submitted_by' => auth()->user()->id,
        ]);

        $payload = array_merge($payload, ['session' => $session]);

        return $next($payload);
    }
}
