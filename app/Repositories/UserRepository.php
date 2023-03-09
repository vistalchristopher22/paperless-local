<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends BaseRepository
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    public function temporaryDelete(Model $account)
    {
        return parent::delete($account);
    }
}
