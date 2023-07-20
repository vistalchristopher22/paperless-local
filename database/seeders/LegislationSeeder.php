<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Ordinance;
use App\Models\Resolution;
use App\Models\Legislation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LegislationSeeder extends Seeder
{
    public function run()
    {
        // $faker = \Faker\Factory::create();

        // // Seed ordinances
        // for ($i = 1; $i <= 5; $i++) {
        //     $date = Carbon::now()->addDays($i);
        //     $ordinance = new Ordinance([
        //         'file' => $faker->word . '.pdf',
        //         'author' => $faker->numberBetween(1, 10),
        //         'session_date' => $date
        //     ]);
        //     $ordinance->save();

        //     $legislation = new Legislation([
        //         'no' => 'ORD-' . str_pad($i, 4, '0', STR_PAD_LEFT),
        //         'title' => $faker->sentence,
        //         'description' => $faker->paragraph,
        //         'type' => 'ordinance'
        //     ]);
        //     $legislation->legislable()->associate($ordinance);
        //     $legislation->save();
        // }

        // // Seed resolutions
        // for ($i = 1; $i <= 5; $i++) {
        //     $date = Carbon::now()->addDays($i);
        //     $resolution = new Resolution([
        //         'file' => $faker->word . '.pdf',
        //         'author' => $faker->numberBetween(1, 10),
        //         'session_date' => $date
        //     ]);
        //     $resolution->save();

        //     $legislation = new Legislation([
        //         'no' => 'RES-' . str_pad($i, 4, '0', STR_PAD_LEFT),
        //         'title' => $faker->sentence,
        //         'description' => $faker->paragraph,
        //         'type' => 'resolution'
        //     ]);
        //     $legislation->legislable()->associate($resolution);
        //     $legislation->save();
        // }
    }
}
