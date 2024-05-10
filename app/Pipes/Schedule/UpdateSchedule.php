<?php

namespace App\Pipes\Schedule;

use App\Repositories\ScheduleRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateSchedule implements IPipeHandler
{
    private readonly ScheduleRepository $scheduleRepository;
    public function __construct()
    {
        $this->scheduleRepository = app()->make(ScheduleRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload['schedule'] = $this->scheduleRepository->updateSchedule($payload);
        return $next($payload);
    }
}
