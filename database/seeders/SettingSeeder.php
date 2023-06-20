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
        ];

        foreach($settings as $setting) {
            Setting::create([
                'name' => $setting['name'],
                'value' => $setting['value'],
            ]);
        }
    }
}
