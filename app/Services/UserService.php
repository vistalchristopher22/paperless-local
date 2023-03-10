<?php

namespace App\Services;

use App\Contracts\IUserService;
use App\Models\User;
use App\Repositories\UserRepository;

final class UserService extends AccountService
{
    public function __construct(private UserRepository $userRepository)
    {
    }
}
