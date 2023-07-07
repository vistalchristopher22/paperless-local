<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Support\Facades\DB;

final class UserAccessRepository extends BaseRepository
{
    public function __construct(UserAccess $access)
    {
        parent::__construct($access);
    }

    public function getAllAccessByUser(User $user)
    {
        return $user->load('access');
    }

    public function grantAccess(array|null $agendas, User $user)
    {
        return DB::transaction(function () use ($agendas, $user) {
            if (isset($agendas)) {
                $user->load('access');
                $user->access()->delete();
                foreach ($agendas as $agenda) {
                    $this->model->create([
                        'agenda' => $agenda,
                        'user' => $user->id,
                    ], [
                        'agenda' => $agenda,
                        'user' => $user->id,
                    ]);
                }
            }
        });
    }
}
