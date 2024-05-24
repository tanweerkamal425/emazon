<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ProductController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $products = Product::query();
        $q = $request->input('q');
        $price_order = (int) $request->input('price_order');
        $category_id = (int) $request->input('category_id');

        if ($q) {
            $products->where('title', 'LIKE', "%{$q}%");
        }
        if ($price_order) {
            $products->orderBy('price_sp', $price_order == 1 ? 'asc' : 'desc');
        }
        if ($category_id) {
            $products->where('category_id', $category_id);
        }
        if ($v = $request->input('from_date')) {
            $products->whereDate('created_at', '>=', date("Y-m-d 00:00:00", strtotime($v)));
        }

        if ($v = $request->input('to_date')) {
            $products->whereDate('created_at', '<=', date("Y-m-d 23:59:59", strtotime($v)));
        }
        if (!$price_order) {
            $products->orderBy('id', 'desc');
        }

        $products = $products->with('category')->paginate(10);

        return ProductResource::collection($products);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'code'              =>  'required|unique:products,code',
            'title'             =>  'required|min:4|max:256',
            'subtitle'          =>  'required|min:32|max:512',
            'description'       =>  'required|min:32|max:1024',
            'price_sp'          =>  'required|integer',
            'price_mp'          =>  'required|integer',
            'category_id'       =>  'required|integer|exists:categories,id',
            'is_returnable'     =>  'nullable|bool',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . random_int(1000, 9999);
        $validated['image_url'] = env('DEFAULT_IMG_URL');

        $product = Product::create($validated);

        return new ProductResource($product);
    }

    public function show(Request $request, int $id)
    {
        $product = Product::query();
        $product = $product->where('id', $id)->with('category')->first();
        if (is_null($product)) {
            throw new NotFoundResourceException("Product with ID '$id' does not exist");
        }

        $sizes = [];
        $colors = [];
        $images = [];
        $product_colors = $product->productColors()->get();
        $product_sizes = $product->productSizes()->get();
        $product_images = $product->productImages()->get();

        $color_ids = $product_colors->map(function($item) {
            return $item->color_id;
        });

        $size_ids = $product_sizes->map(function($item) {
            return $item->size_id;
        });

        $image_ids = $product_images->map(function($item) {
            return $item->size_id;
        });

        $colors = Color::whereIn('id', $color_ids->toArray())->get();
        $sizes  = Size::whereIn('id', $size_ids->toArray())->get();
        // $images = ProductImage::whereIn('id', $image_ids->toArray())->get();
        $images = $product_images;

        $data = [
            'product'   =>  $product,
            'sizes'     =>  $sizes,
            'colors'    =>  $colors,
            'images'    =>  $images,
        ];

        return $data;
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'code'              =>  'required|unique:products,code,'.$id,
            'title'             =>  'required|min:4|max:256',
            'subtitle'          =>  'required|min:32|max:512',
            'description'       =>  'required|min:32|max:1024',
            'price_sp'          =>  'required|integer',
            'price_mp'          =>  'required|integer',
            'category_id'       =>  'required|integer|exists:categories,id',
            'is_returnable'     =>  'nullable|bool',
        ]);

        $product = Product::find($id);
        if (is_null($product)) {
            throw new NotFoundResourceException("The product with ID '$id' does not exist");
        }

        $product->update($validated);

        return new ProductResource($product);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'image_url' =>  'required|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $product = Product::find($id);
        if (is_null($product)) {
            throw new NotFoundResourceException("The product with ID '$id' does not exist");
        }

        $old_image = $product->image_url;
        $validated['image_url'] = $old_image;

        if ($file = $request->file('image_url')) {
            $name = time() . Str::random(10) .'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        // Delete old image
        // if ($product->image_url !== env('DEFAULT_PRODUCT_IMAGE_URL')) {
        //     unlink(public_path("uploads") . "/" . basename($product->image_url));
        // }

        $product->update($validated);

        //ask logic from sir
        // if (!is_null($old_image) && $request->hasFile('image_url')) {
        //     $file_name = strrchr($old_image, "/");
        //     if ($file_name !== false && !strstr($file_name, "default-image.jpg")) {
        //         $image_path = public_path('uploads' . $file_name);
        //         unlink($image_path);
        //     }
        // }

        return new ProductResource($product);
    }

    public function colorVariants(Request $request, int $id)
    {
        $validated = $request->validate([
            'colors.*' => 'required|integer|exists:colors,id',
        ]);

        if ($validated == []) {
            $validated = [
                'colors'    =>  [],
            ];
        }

        $product = Product::find($id);
        if (is_null($product)) {
            throw new NotFoundResourceException("Product with ID '$id' does not exist");
        }

        $color_ids = $validated['colors'];

        ProductColor::where('product_id', $id)->delete();

        $product_colors = [];

        for ($i = 0; $i < count($color_ids); ++$i) {
            $product_colors[] = [
                'product_id'    =>  $id,
                'color_id' =>  $color_ids[$i],
            ];
        }

        $product->productColors()->createMany($product_colors);

        return new ProductResource($product);

    }

    public function sizeVariants(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'sizes.*' =>  'required|integer|exists:sizes,id',
        ]);

        if ($validated == []) {
            $validated = [
                'sizes'    =>  [],
            ];
        }

        $product = Product::find($id);
        if (is_null($product)) {
            throw new NotFoundResourceException("Product with ID '$id' does not exist");
        }

        $size_ids = $validated['sizes'];

        ProductSize::where('product_id', $id)->delete();

        $product_sizes = [];

        for ($i = 0; $i < count($size_ids); ++$i) {
            $product_sizes[] = [
                'product_id'    =>  $id,
                'size_id'  =>  $size_ids[$i],
            ];
        }

        $product->productSizes()->createMany($product_sizes);

        return new ProductResource($product);
    }

    public function multiImageUpload(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'image' =>  'required|file|mimes:jpeg,png,jpg|max:1024',
            'is_default'    => 'nullable|in:0,1',
        ]);

        $product = Product::find($id);
        if (is_null($product)) {
            throw new NotFoundResourceException("The product with ID '$id' does not exist");
        }

        if ($file = $request->file('image')) {
            $name = time() . Str::random(10) .'.jpg';
            $file->move('uploads', $name);
            $validated['image'] = env('ASSETS_CDN') . $name;
        }

        $product->productImages()->create([
            'product_id'    =>  $id,
            'image' =>  $validated['image'],
            'is_default'    =>  data_get($validated, 'is_default', 0),
        ]);

        return new ProductResource($product);
    }
}
