<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Administrator',
            'last_name' => 'Account',
            'username' => 'admin',
            'password' => 'christopher',
            'account_type' => UserTypes::ADMIN->value,
            'status' => UserStatus::Active,
        ]);

        User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Vistal',
            'username' => 'tooshort01',
            'password' => 'christopher',
            'account_type' => UserTypes::USER->value,
            'status' => UserStatus::Active,
        ]);

        $user = User::create([
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'username' => 'tooshort02',
            'password' => 'christopher',
            'account_type' => UserTypes::USER->value,
            'status' => UserStatus::Active,
        ]);

        DB::table('user_accesses')->insert([
            'user' => $user->id,
            'agenda' => 1,
        ]);

        DB::table('user_accesses')->insert([
            'user' => $user->id,
            'agenda' => 2,
        ]);

        DB::table('user_accesses')->insert([
            'user' => $user->id,
            'agenda' => 3,
        ]);

        DB::table('user_accesses')->insert([
            'user' => $user->id,
            'agenda' => 4,
        ]);

        DB::table('user_accesses')->insert([
            'user' => $user->id,
            'agenda' => 5,
        ]);

    }
}
