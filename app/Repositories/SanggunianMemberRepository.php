<?php

namespace App\Repositories;

use App\Models\SanggunianMember;

final class SanggunianMemberRepository extends BaseRepository
{
    public function __construct(SanggunianMember $model)
    {
        parent::__construct($model);
    }
}
