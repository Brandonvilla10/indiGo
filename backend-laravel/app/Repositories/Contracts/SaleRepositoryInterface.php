<?php

namespace App\Repositories\Contracts;

use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SaleRepositoryInterface
{
    public function getAll(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Sale;
    public function create(array $data): Sale;
    public function getSalesByDateRange(string $startDate, string $endDate): Collection;
}
