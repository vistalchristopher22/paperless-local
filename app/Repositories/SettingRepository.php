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

    public static function getSettingsForBoardSession(): array
    {
        $missingStatus = [];

        $settingNames = ['unassigned_business', 'announcement'];

        foreach ($settingNames as $settingName) {
            $settingValue = self::getValueByName($settingName);
            if ($settingValue === null) {
                $missingStatus[$settingName] = false;
            }
        }
        return $missingStatus;
    }


    public static function getValueByName(string $column)
    {
        return Setting::where('name', $column)?->first()?->value;
    }

    public static function getAvailableRegularSessionThisYear(): array
    {
        return collect(range(SettingRepository::getValueByName('current_session'), SettingRepository::getValueByName('current_session') + SettingRepository::getValueByName('current_session_increment')))
            ->toArray();
    }

    public function getByNames(string $column, array $values = [])
    {
        return $this->model->whereIn($column, $values)->get();
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function getPresidingOfficer(): string
    {
        return Setting::where('name', 'presiding_officer')->first();
    }

    public function updateNewSettings(array $data = [])
    {
        DB::transaction(function () use ($data) {
            $this->model->truncate();
            foreach ($data as $setting => $value) {
                Setting::create(
                    [
                        'name' => $setting,
                        'value' => $value,
                    ]
                );
            }
        });
    }

    public static function setNewValue(string $key, string $databaseKey, array $data = [])
    {
        if (array_key_exists($key, $data)) {
            Setting::updateOrCreate(['name' => $databaseKey], ['value' => $data[$key]]);
        }
    }
}
