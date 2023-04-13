<?php

namespace App\Pipes\User;

use Closure;
use Illuminate\Support\Arr;
use App\Repositories\UserRepository;
use App\Contracts\Pipes\IPipeHandler;

final class StoreUser implements IPipeHandler
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $this->userRepository->store(Arr::except($payload, ['_token']));
        return $next($payload);
    }
}
