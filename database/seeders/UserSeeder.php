<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatus;
use App\Enums\UserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'password' => 'password',
            'account_type' => UserTypes::ADMIN->value,
            'status' => UserStatus::Active,
        ]);
    }
}
