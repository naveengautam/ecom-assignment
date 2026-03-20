<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add 3 vendors for testing
        Vendor::create([
            'name' => 'Vendor One',
            'email' => 'vendor1@example.com',
            'phone' => '1234567890',
            'address' => 'Mumbai, India',
        ]);
        Vendor::create([
            'name' => 'Vendor Two',
            'email' => 'vendor2@example.com',
            'phone' => '1234567891',
            'address' => 'Delhi, India',
        ]);
        Vendor::create([
            'name' => 'Vendor Three',
            'email' => 'vendor3@example.com',
            'phone' => '1234567892',
            'address' => 'Bangalore, India',
        ]);
    }
}
