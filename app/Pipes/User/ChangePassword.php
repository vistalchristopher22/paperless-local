<?php

namespace App\Pipes\User;

use App\Contracts\Pipes\IPipeHandler;
use App\Services\UserService;
use Closure;

final class ChangePassword implements IPipeHandler
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $payload = $this->userService->isUserWantToChangePassword($payload);

        return $next($payload);
    }
}
