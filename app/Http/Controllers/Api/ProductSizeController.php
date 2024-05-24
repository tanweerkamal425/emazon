<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSizeResource;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ProductSizeController extends Controller
{
    public function index(): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $product_sizes = ProductSize::query();

        $product_sizes = $product_sizes->orderBy('id', 'desc')->paginate($items);

        return ProductSizeResource::collection($product_sizes);
    }

    public function show(Request $request, int $id)
    {
        $product_size = ProductSize::find($id);
        if (is_null($product_size)) {
            throw new NotFoundResourceException("product color with ID '$id'  does not exist");
        }

        return new ProductSizeResource($product_size);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'product_id'    =>  'required|integer|exists:products,id',
            'size_id'   =>  'required|integer|exists:sizes,id'
        ]);

        $product_color = ProductSize::create($validated);

        return new ProductSizeResource($product_color);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'product_id'    =>  'required|integer|exists:products,id',
            'size_id'   =>  'required|integer|exists:sizes,id'
        ]);

        $product_size = ProductSize::find($id);
        if (is_null($product_size)) {
            throw new NotFoundResourceException("product size with ID '$id' does not exist");
        }

        return new ProductSizeResource($product_size);
    }
}
