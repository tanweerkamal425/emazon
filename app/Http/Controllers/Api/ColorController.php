<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ColorController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;
        $color = request('color');

        $colors = Color::query();

        if ($v = request('color')) {
            $colors->where('color', 'LIKE', "%{$v}%");
        }

        $colors = $colors->orderBy('id', 'desc')->paginate($items);

        return ColorResource::collection($colors);
    }

    public function allColors(): JsonResource
    {
        $colors = Color::all();

        return ColorResource::collection($colors);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'color' =>  'nullable|max:64|unique:colors',
            'code'  => 'required|size:6|unique:colors',
        ]);

        $color = Color::create($validated);

        return new ColorResource($color);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $color = Color::find($id);
        if (is_null($color)) {
            throw new NotFoundResourceException("Color with ID '$id' does not exist");
        }

        return new ColorResource($color);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'color' =>  'required|max:64|unique:colors,color,'.$id,
            'code'  => 'required|size:6|unique:colors,code,'.$id,
        ]);

        $color = Color::find($id);
        if (is_null($color)) {
            throw new NotFoundResourceException("Color with ID '$id' does not exist");
        }

        $color->update($validated);

        return new ColorResource($color);
    }

    public function delete(Request $request, int $id): JsonResource
    {
        $color = Color::find($id);
        if (is_null($color)) {
            throw new NotFoundResourceException("Color with ID '$id' does not exist");
        }

        $color->where('id', $id)->delete();

        return new ColorResource($color);
    }
}
