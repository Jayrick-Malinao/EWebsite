<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's initial system administrator.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@esperanza.local',
            ],
            [
                'name' => 'System Administrator',
                'password' => 'Admin@12345',
                'role' => 'System Administrator',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'System Administrator',
                'password' => 'Admin@123',
                'role' => 'System Administrator',
                'status' => 'active',
            ]
        );
    }
}
