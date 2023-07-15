<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Resolution;
use Illuminate\Database\Seeder;

class ResolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Seed resolutions
        for ($i = 1; $i <= 10; $i++) {
            $date = Carbon::now()->addDays($i);
            $resolution = new Resolution([
                'file' => fake()->word . '.pdf',
                'author' => fake()->numberBetween(1, 10),
                'session_date' => $date
            ]);
            $resolution->save();
        }
    }
}
