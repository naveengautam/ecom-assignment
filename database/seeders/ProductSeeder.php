<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3-4 products for each vendor
        Product::create([
            'vendor_id' => 1,
            'name' => 'Product A',
            'description' => 'Description for Product A',
            'price' => 100.00,
            'stock' => 50,
        ]);

        Product::create([
            'vendor_id' => 1,
            'name' => 'Product B',
            'description' => 'Description for Product B',
            'price' => 150.00,
            'stock' => 30,
        ]);

        Product::create([
            'vendor_id' => 2,
            'name' => 'Product C',
            'description' => 'Description for Product C',
            'price' => 200.00,
            'stock' => 20,
        ]);

        Product::create([
            'vendor_id' => 2,
            'name' => 'Product D',
            'description' => 'Description for Product D',
            'price' => 250.00,
            'stock' => 10,
        ]);

        Product::create([
            'vendor_id' => 3,
            'name' => 'Product E',
            'description' => 'Description for Product E',
            'price' => 300.00,
            'stock' => 5,
        ]);

        Product::create([
            'vendor_id' => 3,
            'name' => 'Product F',
            'description' => 'Description for Product F',
            'price' => 350.00,
            'stock' => 2,
        ]);

    }
}
