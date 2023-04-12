<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use App\Models\SanggunianMember;

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
