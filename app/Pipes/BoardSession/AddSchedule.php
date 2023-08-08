<?php

namespace App\Pipes\BoardSession;

use App\Repositories\BoardSessionRespository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class AddSchedule implements IPipeHandler
{
    public function __construct(private readonly BoardSessionRespository $boardSessionRepository)
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $boardSession = $this->boardSessionRepository->addSchedule($payload['board_session_id'], $payload['schedule_id']);
        $payload['session'] = $boardSession;
        return $next($payload);
    }
}
