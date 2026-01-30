<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop HP', 'description' => 'Laptop HP Core i5, 8GB RAM, 256GB SSD', 'price' => 599.99, 'stock' => 15, 'category_id' => 1],
            ['name' => 'Mouse Logitech', 'description' => 'Mouse inalámbrico Logitech M185', 'price' => 19.99, 'stock' => 50, 'category_id' => 1],
            ['name' => 'Teclado Mecánico', 'description' => 'Teclado mecánico RGB', 'price' => 89.99, 'stock' => 25, 'category_id' => 1],
            ['name' => 'Camiseta Nike', 'description' => 'Camiseta deportiva Nike Dri-FIT', 'price' => 29.99, 'stock' => 100, 'category_id' => 2],
            ['name' => 'Pantalón Adidas', 'description' => 'Pantalón deportivo Adidas', 'price' => 49.99, 'stock' => 75, 'category_id' => 2],
            ['name' => 'Café Premium', 'description' => 'Café colombiano 500g', 'price' => 12.99, 'stock' => 200, 'category_id' => 3],
            ['name' => 'Aceite de Oliva', 'description' => 'Aceite de oliva extra virgen 1L', 'price' => 15.99, 'stock' => 80, 'category_id' => 3],
            ['name' => 'Lámpara LED', 'description' => 'Lámpara LED de escritorio', 'price' => 34.99, 'stock' => 40, 'category_id' => 4],
            ['name' => 'Almohada Memory Foam', 'description' => 'Almohada de memory foam', 'price' => 39.99, 'stock' => 60, 'category_id' => 4],
            ['name' => 'Balón de Fútbol', 'description' => 'Balón de fútbol profesional', 'price' => 24.99, 'stock' => 35, 'category_id' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
