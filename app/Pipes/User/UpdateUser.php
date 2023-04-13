<?php

namespace App\Pipes\User;

use Closure;
use Illuminate\Support\Arr;
use App\Repositories\UserRepository;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateUser implements IPipeHandler
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $this->userRepository->update($payload['account'], Arr::except($payload, ['account', '_token', '_method']));
        return $next($payload);
    }
}
