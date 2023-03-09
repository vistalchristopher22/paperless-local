<?php

namespace App\Contracts;


interface IUserService
{
    public function isUserWantToChangePassword(array $data = []): mixed;
}
