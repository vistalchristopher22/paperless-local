<?php

namespace App\Repositories;

use App\Models\Type;

final class TypeRepository extends BaseRepository
{
    public function __construct(Type $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate($perPage);
    }
}
