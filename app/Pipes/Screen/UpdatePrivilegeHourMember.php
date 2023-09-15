<?php

namespace App\Pipes\Screen;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;

final class UpdatePrivilegeHourMember implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        SettingRepository::setNewValue(key: 'member', databaseKey: 'privilege_hour_member', data: $payload);
        return $next($payload);
    }
}
