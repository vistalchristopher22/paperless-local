<?php

namespace App\Repositories;

use App\Models\Type;

final class TypeRepository extends BaseRepository
{
    public function __construct(Type $model)
    {
        parent::__construct($model);
    }
}
