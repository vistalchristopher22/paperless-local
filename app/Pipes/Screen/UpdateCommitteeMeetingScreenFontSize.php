<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdateCommitteeMeetingScreenFontSize implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'screen_font_size', databaseKey: 'screen_font_size', data: $payload);
        return $next($payload);
    }
}
