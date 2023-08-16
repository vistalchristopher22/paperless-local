<?php

namespace App\Repositories;

use App\Models\Type;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

final class TypeRepository extends BaseRepository
{
    public function __construct(Type $model)
    {
        parent::__construct($model);
    }
}
