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
                'name' => 'Tandag City',
            ],
            [
                'name' => 'Bislig City',
            ],
        ];

        foreach ($data as $item) {
            Venue::create($item);
        }
    }
}
