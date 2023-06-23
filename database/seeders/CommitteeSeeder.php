<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agenda;
use App\Enums\UserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20000) as $range) {
            echo "Insert #{$range} committee record\n";
            $user = User::where('account_type', UserTypes::USER->value)->get()->random()->first()->id;
            $data = [
                 'name' => "Test #{$range}",
                //  'priority_number' => $range,
                 'lead_committee' => 1,
                 'expanded_committee' => 1,
                 'file_path' => null,
                 'date' => now(),
                 'created_at' => now(),
                 'updated_at' => now(),
                 'status' => 'review',
                 'submitted_by' => $user,
             ];


            DB::table('committees')->insert($data);
        }
    }
}
