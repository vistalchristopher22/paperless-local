<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            UserSeeder::class,
            AgendaSeeder::class,
            AgendaMemberSeeder::class,
//            CommitteeSeeder::class,
        ]);
    }
}
