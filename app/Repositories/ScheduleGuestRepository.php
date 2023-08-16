<?php

namespace App\Repositories;

use App\Models\ScheduleGuest;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class ScheduleGuestRepository extends BaseRepository
{
    public function __construct(ScheduleGuest $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->oldest()->get();
    }

}
