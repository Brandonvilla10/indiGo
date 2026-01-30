<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): ?Product;
    public function delete(int $id): bool;
}
