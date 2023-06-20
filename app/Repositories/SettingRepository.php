<?php

namespace App\Repositories;

use App\Models\Setting;

final class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function getByNames(string $column, array $values = [])
    {
        return $this->model->whereIn($column, $values)->get();
    }
}
