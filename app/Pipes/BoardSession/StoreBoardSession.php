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
            'unassigned_title' => $payload['unassigned_title'],
            'announcement_title' => $payload['announcement_title'],
            'announcement_content' => $payload['announcement_content'],
        ]);

        $payload = array_merge($payload, ['session' => $session]);

        return $next($payload);
    }
}
