<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();
        $categories = Category::all();
        // $products = Product::with('category')->get();
        // dd($products);

        $query = $request->input('query');
        $q = $request->input('q');
        $price_order = (int) $request->input('price_order');
        $category_id = (int) $request->input('category_id');



        // if ($query) {
        //     $products->where('title', 'LIKE', "%{$query}%")
        //             ->orwhere('name', 'LIKE', "{$query}");
        // }

        if ($q) {
            $products->where('title', 'LIKE', "%{$q}%");
        }
        if ($price_order) {
            $products->orderBy('price_sp', $price_order == 1 ? 'asc' : 'desc');
        }
        if ($category_id) {
            $products->where('category_id', $category_id);
        }
        if (!$price_order) {
            $products->orderBy('id', 'desc');
        }

        $products = $products->paginate(20);


        return view('product.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (is_null($product)) {
            abort(404);
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

        $colors = Color::whereIn('id', $color_ids->toArray())->get();
        $sizes  = Size::whereIn('id', $size_ids->toArray())->get();


        return view('product.show', [
            'product' => $product,
            'sizes'   => $sizes,
            'colors'  => $colors,
            'images'  => $product_images,
        ]);
    }
}
