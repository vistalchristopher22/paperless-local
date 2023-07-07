<?php

namespace App\Pipes\User;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Support\Arr;

final class UpdateUser implements IPipeHandler
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->userRepository->update($payload['account'], Arr::except($payload, ['account', '_token', '_method', 'image']));

        return $next($payload);
    }
}
