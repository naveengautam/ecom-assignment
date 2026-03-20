<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users, Vendors, and Products for testing
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
