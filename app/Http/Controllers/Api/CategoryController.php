<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $categories = Category::query();

        if ($v = $request->input('from_date')) {
            $categories->whereDate('created_at', '>=', date("Y-m-d 00:00:00", strtotime($v)));
        }

        if ($v = $request->input('to_date')) {
            $categories->whereDate('created_at', '<=', date("Y-m-d 23:59:59", strtotime($v)));
        }
        if ($v = request('search')) {
            $categories->where('name', 'LIKE', "%{$v}%");
        }

        $categories = $categories->orderBy('id', 'desc')->paginate($items);

        return CategoryResource::collection($categories);

    }

    public function allCategories(): JsonResource
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'name'  => 'required|max:64|unique:categories,name',
            'parent_id' =>  'nullable|integer|exists:categories,id',
        ]);

        $category = Category::create($validated);

        return new CategoryResource($category);
    }

    public function show(Request $request, int $id)
    {
        $category = Category::query();

        $category = $category->where('id', $id)->first();
        $products = $category->products()->get();
        if (is_null($category)) {
            throw new NotFoundResourceException("Category with ID '$id' does not exist");
        }

        $data = [
            'category'  =>  $category,
            'products'  =>  $products,
        ];

        return $data;
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'name'  => 'required|max:64|unique:categories,name,'.$id,
            'parent_id' =>  'nullable|integer|exists:categories,id',
        ]);

        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundResourceException("Category with ID '$id' does not exist'");
        }

        $category->update($validated);

        return new CategoryResource($category);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'image_url' =>  'required|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundResourceException("The category with ID '$id' does not exist");
        }

        $old_image = $category->image_url;
        $validated['image_url'] = $old_image;

        if ($file = $request->file('image_url')) {
            $name = time() . Str::random(10) .'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        $category->update($validated);

        //ask logic from sir
        // if (!is_null($old_image) && $request->hasFile('image_url')) {
        //     $file_name = strrchr($old_image, "/");
        //     if ($file_name !== false && !strstr($file_name, "default-image.jpg")) {
        //         $image_path = public_path('uploads' . $file_name);
        //         unlink($image_path);
        //     }
        // }

        return new CategoryResource($category);
    }
}
