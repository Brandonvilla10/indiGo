<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónica',
                'description' => 'Productos electrónicos y tecnología',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Prendas de vestir y accesorios',
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios y bebidas',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar',
            ],
            [
                'name' => 'Deportes',
                'description' => 'Equipamiento deportivo y fitness',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
