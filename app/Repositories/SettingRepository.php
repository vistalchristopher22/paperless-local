<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\ReferenceSession;
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
        // $usedReferenceSessions = ReferenceSession::where('year', date('Y'))->get()->map(fn ($session) => (int) $session->number)->toArray();
        return collect(range(SettingRepository::getValueByName('current_session'), SettingRepository::getValueByName('current_session') + SettingRepository::getValueByName('current_session_increment')))
                    // ->filter(fn ($session) => !in_array($session, $usedReferenceSessions))
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
