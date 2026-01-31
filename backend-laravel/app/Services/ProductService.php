<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function getAllProducts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->getAll($perPage);
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): Product
    {
        if (isset($data['image']) && is_file($data['image'])) {
            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): ?Product
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return null;
        }

        if (isset($data['image']) && is_file($data['image'])) {
            
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return false;
        }

       
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->productRepository->delete($id);
    }
}
