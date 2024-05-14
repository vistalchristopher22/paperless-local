<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'TANDAG CITY',
                'address' => 'THE LEGISLATIVE BUILDING SESSION HALL, CAPITOL HILLS, BARANGAY TELAJE, TANDAG CITY, PROVINCE OF SURIGAO DEL SUR',
            ],
            [
                'name' => 'BISLIG CITY',
            ],
        ];

        foreach ($data as $item) {
            Venue::create($item);
        }
    }
}
