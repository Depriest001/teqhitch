<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'superadmin@teqhitch.com'],
            [
                'name' => 'Super Administrator',
                'phone' => '08100000000',
                'password' => Hash::make('Admin@123'),
                'role' => 'superadmin',
                'status' => 'active',
            ]
        );
    }
}
