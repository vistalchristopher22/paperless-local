<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

final class AgendaRepository extends BaseRepository
{
    // You can change the model
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}