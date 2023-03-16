<?php

namespace App\Pipes\User;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Services\UploadImageService;
use App\Services\UserService;

final class ProfilePicture implements IPipeHandler
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = app()->make(UserService::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload = $this->userService->isUserWantToChangeProfilePicture($payload, new UploadImageService());
        return $next($payload);
    }
}