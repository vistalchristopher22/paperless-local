<?php

namespace App\Services;

use App\Contracts\IUserService;
use App\Models\User;
use App\Repositories\UserRepository;

final class UserService implements IUserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function isUserWantToChangePassword(array $data = []): mixed
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }
}
