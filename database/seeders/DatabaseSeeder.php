<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BoardMemberIdentificationCardSeeder;

// use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SanggunianMemberSeeder::class,
            DivisionSeeder::class,
            AgendaSeeder::class,
            AgendaMemberSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            VenueSeeder::class,
           ....... // BoardMemberIdentificationCardSeeder::class,
        ]);
    }
}
