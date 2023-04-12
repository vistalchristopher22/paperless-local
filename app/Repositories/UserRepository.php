<?php

namespace App\Repositories;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Database\Eloquent\Collection;

final class UserRepository extends BaseRepository
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get all users where account type is normal user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllNormalUsers(): Collection
    {
        return $this->model->where('account_type', UserTypes::USER->value)->get();
    }

    public function getWithDivision()
    {
        return parent::get()->load('division_information');
    }

}
