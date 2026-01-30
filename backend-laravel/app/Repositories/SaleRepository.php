<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Sale::with(['user', 'items.product'])
            ->latest('sale_date')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Sale
    {
        return Sale::with(['user', 'items.product'])->find($id);
    }

    public function create(array $data): Sale
    {
        return Sale::create($data);
    }

    public function getSalesByDateRange(string $startDate, string $endDate): Collection
    {
        return Sale::with(['user', 'items.product'])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->orderBy('sale_date', 'desc')
            ->get();
    }
}
