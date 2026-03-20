<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        // add customers
        User::create([
            'name' => 'Ajay Kumar',
            'email' => 'ajay@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        User::create([
            'name' => 'Priya Singh',
            'email' => 'priya@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

    }
}
