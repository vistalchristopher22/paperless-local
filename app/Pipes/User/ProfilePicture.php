<?php

namespace App\Pipes\User;

use App\Contracts\Pipes\IPipeHandler;
use App\Services\UploadImageService;
use App\Services\UserService;
use Closure;

final class ProfilePicture implements IPipeHandler
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        if (!isset($payload['profile_picture'])) {
            return $next($payload);
        }

        $payload = $this->userService->isUserWantToChangeProfilePicture($payload, new UploadImageService());

        return $next($payload);
    }
}
