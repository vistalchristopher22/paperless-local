<?php

namespace App\Pipes\BoardSession;

use App\Repositories\ScheduleRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class MoveBoardSessionFileToRootDirectory implements IPipeHandler
{
    public function __construct(private readonly ScheduleRepository $scheduleRepository)
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $schedule = $this->scheduleRepository->findById($payload['schedule_id']);

        $scheduleRootDirectory = $schedule->root_directory;

        rename($payload['session']['file_path'], $scheduleRootDirectory . '/' . 'SESSION/' . basename($payload['session']['file_path']));
        rename($payload['session']['file_template'], $scheduleRootDirectory . '/' . 'SESSION/' . basename($payload['session']['file_template']));

        $payload['session']['file_path'] = $scheduleRootDirectory . DIRECTORY_SEPARATOR . 'SESSION' . DIRECTORY_SEPARATOR . basename($payload['session']['file_path']);
        $payload['session']['file_template'] = $scheduleRootDirectory . DIRECTORY_SEPARATOR . 'SESSION' . DIRECTORY_SEPARATOR . basename($payload['session']['file_template']);

        $payload['session']->save();
        $payload['schedule'] = $schedule;

        return $next($payload);
    }
}
