<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(
        private SaleRepositoryInterface $saleRepository
    ) {}

    public function getAllSales(int $perPage = 15): LengthAwarePaginator
    {
        return $this->saleRepository->getAll($perPage);
    }

    public function getSaleById(int $id): ?Sale
    {
        return $this->saleRepository->findById($id);
    }

    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            // Create sale
            $sale = $this->saleRepository->create([
                'user_id' => $data['user_id'],
                'total' => 0,
                'sale_date' => $data['sale_date'] ?? now(),
            ]);

            $total = 0;

            // Create sale items and update stock
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Validate stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }

                $subtotal = $item['quantity'] * $product->price;
                $total += $subtotal;

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Update product stock
                $product->decrement('stock', $item['quantity']);
            }

            // Update sale total
            $sale->update(['total' => $total]);

            return $sale->fresh(['user', 'items.product']);
        });
    }

    public function getSalesReport(string $startDate, string $endDate): array
    {
        $sales = $this->saleRepository->getSalesByDateRange($startDate, $endDate);

        $totalSales = $sales->count();
        $totalRevenue = $sales->sum('total');
        $averageTicket = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Top products sold
        $topProducts = [];
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $productId = $item->product_id;
                if (!isset($topProducts[$productId])) {
                    $topProducts[$productId] = [
                        'product' => $item->product->name,
                        'quantity' => 0,
                        'revenue' => 0,
                    ];
                }
                $topProducts[$productId]['quantity'] += $item->quantity;
                $topProducts[$productId]['revenue'] += $item->subtotal;
            }
        }

        // Sort by quantity sold
        usort($topProducts, fn($a, $b) => $b['quantity'] <=> $a['quantity']);
        $topProducts = array_slice($topProducts, 0, 10);

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'summary' => [
                'total_sales' => $totalSales,
                'total_revenue' => round($totalRevenue, 2),
                'average_ticket' => round($averageTicket, 2),
            ],
            'top_products' => $topProducts,
            'sales' => $sales,
        ];
    }
}
