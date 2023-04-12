<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

abstract class AccountService
{
    public function isUserWantToChangePassword(array $data = []): mixed
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    public function verify(string $key, User $account)
    {
        return Hash::check($key, $account->password);
    }
}
