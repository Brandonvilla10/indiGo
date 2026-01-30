<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->get('per_page', 15);
        $products = $this->productService->getAllProducts($perPage);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => new ProductResource($product)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => new ProductResource($product)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->deleteProduct($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}
