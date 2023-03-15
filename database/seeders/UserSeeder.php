<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            'division' => 'Provincial Government'
        ]);
    }
}
