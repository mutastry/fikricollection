<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin/Inventory user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@songketpalembang.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        // Create Cashier user
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@songketpalembang.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CASHIER,
            'email_verified_at' => now(),
        ]);

        // Create Employee user
        User::create([
            'name' => 'Employee User',
            'email' => 'employee@songketpalembang.com',
            'password' => Hash::make('password'),
            'role' => UserRole::EMPLOYEE,
            'email_verified_at' => now(),
        ]);

        // Create Owner user
        User::create([
            'name' => 'Owner User',
            'email' => 'owner@songketpalembang.com',
            'password' => Hash::make('password'),
            'role' => UserRole::OWNER,
            'email_verified_at' => now(),
        ]);
    }
}
