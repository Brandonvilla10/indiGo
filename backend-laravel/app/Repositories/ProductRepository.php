<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with('category')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::with('category')->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): ?Product
    {
        $product = Product::find($id);
        
        if (!$product) {
            return null;
        }

        $product->update($data);
        return $product->fresh('category');
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);
        
        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}
