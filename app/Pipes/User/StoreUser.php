<?php

namespace App\Pipes\User;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\UserRepository;

final class StoreUser implements IPipeHandler
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $this->userRepository->store($payload);
        return $next($payload);
    }
}
