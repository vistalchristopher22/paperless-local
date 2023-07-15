<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Ordinance as OrdinanceModel;
use Illuminate\Database\Seeder;

class OrdinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed ordinances
        for ($i = 1; $i <= 10; $i++) {
            $date = Carbon::now()->addDays($i);
            $ordinance = new OrdinanceModel([
                'file' => fake()->word . '.pdf',
                'author' => fake()->numberBetween(1, 10),
                'session_date' => $date
            ]);
            $ordinance->save();
        }
    }
}
