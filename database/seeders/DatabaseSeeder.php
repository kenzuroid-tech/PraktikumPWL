<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 3 products
        Product::factory()->create([
            'name' => 'Laptop Pro',
            'sku' => 'LAPTOP-001',
            'description' => 'High-performance laptop dengan processor terbaru',
            'price' => 15000000,
            'stock' => 10,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::factory()->create([
            'name' => 'Mouse Wireless',
            'sku' => 'MOUSE-001',
            'description' => 'Mouse ergonomis dengan koneksi wireless stabil',
            'price' => 250000,
            'stock' => 50,
            'is_active' => true,
            'is_featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Keyboard Mechanical',
            'sku' => 'KEYBOARD-001',
            'description' => 'Keyboard mekanik RGB dengan 104 key',
            'price' => 850000,
            'stock' => 25,
            'is_active' => true,
            'is_featured' => true,
        ]);
    }
}
