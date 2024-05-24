<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ProductImageController extends Controller
{
    // $table->id();
    // $table->unsignedBigInteger('product_id');
    // $table->string('image', 64);
    // $table->tinyInteger('is_default')->default(1);

    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;
        $product_images = ProductImage::query();

        $product_images = $product_images->orderBy('id', 'desc')->paginate($items);

        return ProductImageResource::collection($product_images);
    }

    public function getLatestImage(Request $request, int $id): JsonResource
    {
        $image = ProductImage::where('product_id', $id)->first();

        return new ProductImageResource($image);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'product_id'    =>  'required|exists:products,id',
            'is_default'    => 'required|integer|in:0,1',
        ]);

        $validated['image'] = env('DEFAULT_PRODUCT_IMAGE_URL');

        $product_image = ProductImage::create($validated);

        return new ProductImageResource($product_image);
    }

    public function allImages(Request $request, int $id)
    {
        $product_image = ProductImage::find($id);
        if (is_null($product_image)) {
            throw new NotFoundResourceException("product image with ID '$id' does not exist");
        }

        $all_product_images = ProductImage::where('product_id', $product_image->id)->get();

        return $all_product_images;
    }

    public function show(Request $request, int $id): JsonResource
    {
        $product_image = ProductImage::find($id);
        if (is_null($product_image)) {
            throw new NotFoundResourceException("Product image with ID '$id' does not exist");
        }

        return new ProductImageResource($product_image);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'product_id'    =>  'required|exists:products,id',
            'is_default'    => 'required|integer|in:0,1',
        ]);

        $product_image = Productimage::find($id);
        if (is_null($product_image)) {
            throw new NotFoundResourceException("Product image with ID '$id' does not exist");
        }

        $product_image->update($validated);

        return new ProductImageResource($product_image);
    }

    public function delete(Request $request, int $id): JsonResource
    {
        $product_image = ProductImage::find($id);
        if (is_null($product_image)) {
            throw new NotFoundResourceException("Product image with ID '$id' does not exist");
        }

        $product_image->where('id', $id)->delete();

        return new ProductImageResource($product_image);

    }
}
