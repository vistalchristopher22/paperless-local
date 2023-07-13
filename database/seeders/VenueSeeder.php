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
                'name' => 'TSP - Session Hall',
            ],
            [
                'name' => 'Second District',
            ],
        ];

        foreach ($data as $item) {
            Venue::create($item);
        }
    }
}
