<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\BoardSessionRespository;
use Closure;

final class GetBoardSession implements IPipeHandler
{
    private BoardSessionRespository $boardSessionRepository;

    public function __construct()
    {
        $this->boardSessionRepository = app()->make(BoardSessionRespository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        // Fetch the record
        $payload = $this->boardSessionRepository->get();

        return $next($payload);
    }
}
