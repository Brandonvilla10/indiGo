<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $products = Product::all();

        if (!$user || $products->isEmpty()) {
            return;
        }

        // Crear 10 ventas de ejemplo en diferentes fechas
        for ($i = 0; $i < 10; $i++) {
            $saleDate = now()->subDays(rand(0, 30));
            
            $sale = Sale::create([
                'user_id' => $user->id,
                'sale_date' => $saleDate,
                'total' => 0,
            ]);

            $total = 0;
            $numItems = rand(1, 5);

            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $subtotal = $quantity * $product->price;
                $total += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            $sale->update(['total' => $total]);
        }
    }
}
