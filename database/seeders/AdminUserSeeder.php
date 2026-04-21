<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@salon.co.nz'],
            [
                'name' => 'Salon Admin',
                'password' => Hash::make('Admin@12345'),
            ]
        );
    }
}
