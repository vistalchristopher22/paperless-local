<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\BoardSessionRespository;

final class StoreBoardSession implements IPipeHandler
{
    protected BoardSessionRespository $boardSessionRepository;

    public function __construct()
    {
        $this->boardSessionRepository = app()->make(BoardSessionRespository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload = $this->boardSessionRepository->store([
            'title'        => $payload['title'],
            'content'      => $payload['content'],
            'is_published' => @$payload['published'] == 'on' ? 1 : 0,
        ]);
        return $next($payload);
    }
}
