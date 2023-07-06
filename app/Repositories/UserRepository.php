<?php

namespace App\Repositories;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class UserRepository extends BaseRepository
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get all users where account type is normal user.
     */
    public function getAllNormalUsers(): Collection
    {
        return $this->model->where('account_type', UserTypes::USER->value)->get();
    }

    public function getWithDivision()
    {
        return parent::get()->load('division_information');
    }

    public static function accessibleAgendas(User $user)
    {
        return $user->access()->pluck('agenda')->toArray();
    }
}
