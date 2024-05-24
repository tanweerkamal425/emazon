<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Event\Code\NoTestCaseObjectOnCallStackException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SizeController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $sizes = Size::query();

        if ($v = request('size')) {
            $sizes->where('size', 'LIKE', "%{$v}%");
        }

        $sizes = $sizes->orderBy('id', 'desc')->paginate($items);

        return SizeResource::collection($sizes);
    }

    public function allSizes(): JsonResource
    {
        $sizes = Size::all();

        return SizeResource::collection($sizes);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'size'  =>  'required|max:10|unique:sizes',
        ]);

        $size = Size::create($validated);

        return new SizeResource($size);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $size = Size::find($id);
        if (is_null($size)) {
            throw new NotFoundResourceException("Size with ID '$id' does not exist");
        }

        return new SizeResource($size);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'size'  =>  'required|max:10|unique:sizes,'.$id,
        ]);

        $size = Size::find($id);
        if (is_null($size)) {
            throw new NotFoundResourceException("Size with ID '$id' does not exist");
        }

        $size->update($validated);

        return new SizeResource($size);
    }

    public function delete(Request $request, int $id): JsonResource
    {
        $size = Size::find($id);
        if (is_null($size)) {
            throw new NotFoundResourceException("Size with ID '$id' does not exist");
        }

        $size->where('id', $id)->delete();

        return new SizeResource($size);
    }
}
