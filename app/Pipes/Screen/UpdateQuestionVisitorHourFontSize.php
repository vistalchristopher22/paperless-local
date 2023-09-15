<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdateQuestionVisitorHourFontSize implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'question_of_hour_font_size', databaseKey: 'question_of_hour_font_size', data: $payload);
        return $next($payload);
    }
}
