<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdateAnnouncementRunningSpeed implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'announcement_running_speed', databaseKey: 'announcement_running_speed', data: $payload);
        return $next($payload);
    }
}
