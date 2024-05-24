<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductColorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ProductColorController extends Controller
{
    public function index(): JsonResource
    {
        $items = request('items') ? request('items') : 10;
        $product_colors = ProductColor::query();

        $product_colors = $product_colors->orderBy('id', 'desc')->paginate($items);

        return ProductColorResource::collection($product_colors);
    }

    public function show(Request $request, int $id)
    {
        $product_color = ProductColor::find($id);
        if (is_null($product_color)) {
            throw new NotFoundResourceException("product color with ID '$id'  does not exist");
        }

        return new ProductColorResource($product_color);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'product_id'    => 'required|integer|exists:products,id',
            'color_id'  =>  'required|integer|exists:colors,id',
        ]);

        $product_color = ProductColor::create($validated);

        return new ProductColorResource($product_color);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'product_id'    => 'required|integer|exists:products,id',
            'color_id'  =>  'required|integer|exists:colors,id',
        ]);

        $product_color = ProductColor::find($id);
        if (is_null($product_color)) {
            throw new NotFoundResourceException("Produt color with ID '$id' does not exist");
        }

        $product_color->update($validated);

        return new ProductColorResource($product_color);
    }
}
