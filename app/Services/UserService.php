<?php

namespace App\Services;

use App\Repositories\UserRepository;

final class UserService extends AccountService
{
    public function __construct(private UserRepository $userRepository)
    {
    }
}
