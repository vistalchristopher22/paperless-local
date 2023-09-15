<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdateAnnouncement implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'announcement', databaseKey: 'display_announcement', data: $payload);
        return $next($payload);
    }
}
