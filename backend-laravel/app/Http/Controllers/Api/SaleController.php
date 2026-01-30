<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaleController extends Controller
{
    public function __construct(
        private SaleService $saleService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->get('per_page', 15);
        $sales = $this->saleService->getAllSales($perPage);

        return SaleResource::collection($sales);
    }

    public function store(StoreSaleRequest $request): JsonResponse
    {
        try {
            $sale = $this->saleService->createSale($request->validated());

            return response()->json([
                'message' => 'Venta registrada exitosamente',
                'data' => new SaleResource($sale)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la venta',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function show(int $id): JsonResponse
    {
        $sale = $this->saleService->getSaleById($id);

        if (!$sale) {
            return response()->json([
                'message' => 'Venta no encontrada'
            ], 404);
        }

        return response()->json([
            'data' => new SaleResource($sale)
        ]);
    }

    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $report = $this->saleService->getSalesReport(
            $request->start_date,
            $request->end_date
        );

        return response()->json($report);
    }
}
