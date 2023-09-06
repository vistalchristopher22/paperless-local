<?php

namespace App\Pipes\Schedule;

use App\Repositories\ScheduleRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateSchedule implements IPipeHandler
{
    public function __construct(private readonly ScheduleRepository $scheduleRepository)
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $reference = $payload['reference'];

        $payload['schedule'] = $this->scheduleRepository->createSchedule($payload, $reference['id']);
        return $next($payload);
    }
}
