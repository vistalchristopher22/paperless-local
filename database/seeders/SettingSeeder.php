<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'name' => 'prepared_by',
                'value' => 'Merlita S. Deligero',
            ],
            [
                'name' => 'noted_by',
                'value' => 'Gemma M. Picasales',
            ],
            [
                'name' => 'libre_office_path',
                'value' => 'C:\\Program Files\\LibreOffice\\program\\soffice',
            ],
            [
                'name' => 'current_session',
                'value' => '52',
            ],
            [
                'name' => 'current_session_increment',
                'value' => 3,
            ],
            [
                'name' => 'first_reading',
                'value' => 'FIRST_READING',
            ],
            [
                'name' => 'second_reading',
                'value' => 'SECOND_READING',
            ],
            [
                'name' => 'third_reading',
                'value' => 'THIRD_READING',
            ],
            [
                'name' => 'unassigned_business',
                'value' => '{unassigned}',
            ],
            [
                'name' => 'announcement',
                'value' => '{announcement}',
            ],
            [
                'name' => 'source_folder',
                'value' => 'C:\laragon\www\paperless\storage\app\source',
            ],
            [
                'name' => 'announcement_running_speed',
                'value' => '25',
            ],
            [
                'name' => 'display_announcement',
                'value' => 'place your text here',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create([
                'name' => $setting['name'],
                'value' => $setting['value'],
            ]);
        }
    }
}
