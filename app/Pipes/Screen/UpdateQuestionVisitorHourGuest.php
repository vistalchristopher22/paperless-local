<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdateQuestionVisitorHourGuest implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'question_of_hour_guest', databaseKey: 'question_of_hour_guest', data: $payload);
        return $next($payload);
    }
}
