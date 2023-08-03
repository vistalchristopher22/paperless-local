<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public static function getValueByName(string $column)
    {
        return Setting::where('name', $column)?->first()?->value;
    }

    public function getByNames(string $column, array $values = [])
    {
        return $this->model->whereIn($column, $values)->get();
    }

    /**
     *
     * @return  Collection
     */
    public function get(): Collection
    {
        return $this->model->get();
    }

    public function updateNewSettings(array $data = [])
    {
        DB::transaction(function () use ($data) {
            $this->model->truncate();

            foreach ($data as $setting => $value) {
                Setting::updateOrCreate(
                    [
                        'name' => $setting,
                    ],
                    [
                        'name' => $setting,
                        'value' => $value,
                    ]
                );
            }
        });
    }
}
