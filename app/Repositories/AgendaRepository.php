<?php

namespace App\Repositories;

use App\Models\Agenda;
use App\Repositories\BaseRepository;

final class AgendaRepository extends BaseRepository
{
    public function __construct(Agenda $model)
    {
        parent::__construct($model);
    }
}
