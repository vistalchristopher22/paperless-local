<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sanggunian_member_ids = DB::table('sanggunian_members')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('attendance_logs')->insert([
                'time_in' => now(),
                'time_out' => now(),
                'sanggunian_member_id' => $sanggunian_member_ids[array_rand($sanggunian_member_ids)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
