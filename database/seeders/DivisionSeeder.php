<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\SanggunianMember;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'Division Test',
            'division_code' => 10001,
            'description' => 'Division Test Description',
            'board' => SanggunianMember::first()->id,
        ]);
    }
}
