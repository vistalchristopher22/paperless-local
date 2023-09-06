<?php

namespace App\Repositories;

use App\Models\ScheduleGuest;
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
