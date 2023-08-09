<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class LegislationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'CLASSIFIED',
            ],
            [
                'name' => 'UNCLASSIFIED'
            ]
        ];

        foreach($data as $type) {
            Type::create($type);
        }
    }
}
