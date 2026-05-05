<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@iot.com'],
            [
                'name' => 'Admin IoT',
                'password' => Hash::make('password123'),
            ]
        );
    }
}