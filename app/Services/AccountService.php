<?php

namespace App\Services;

abstract class AccountService
{
    public function isUserWantToChangePassword(array $data = []): mixed
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }
}
