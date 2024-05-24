<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CouponController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $coupons = Coupon::query();
        $value = (int) $request->input('value');
        $is_active = (int) $request->input('is_active');
        $coupon = $request->input('coupon');

        if ($value) {
            $coupons->orderBy('value', $value == 1 ? 'asc' : 'desc');
        }
        if ($is_active) {
            $coupons->where('is_active', $is_active - 1);
        }
        if ($coupon) {
            $coupons->where('coupon', 'LIKE', "%{$coupon}%");
        }
        if (!$value) {
            $coupons->orderBy('id', 'desc');
        }


        $coupons = $coupons->paginate($items);

        return CouponResource::collection($coupons);
    }

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'coupon'    =>  'required|max:16|unique:coupons,coupon',
            'value'     =>  'required|integer|min:0',
            'is_active' =>  'in:0,1',
        ]);

        $coupon = Coupon::create($validated);

        return new CouponResource($coupon);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $coupon = Coupon::find($id);
        if (is_null($coupon)) {
            throw new NotFoundResourceException("Coupon with ID '$id' does not exist");
        }

        return new CouponResource($coupon);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'coupon'    =>  'required|max:16|unique:coupons,coupon,'.$id,
            'value'     =>  'required|integer|min:0',
            'is_active' =>  'required|in:0,1',
        ]);

        $coupon = Coupon::find($id);
        if (is_null($coupon)) {
            throw new NotFoundResourceException("Coupon with ID '$id' does not exist");
        }

        $coupon->update($validated);

        return new CouponResource($coupon);
    }

    public function delete(Request $request, int $id): JsonResource
    {
        $coupon = Coupon::find($id);
        if (is_null($coupon)) {
            throw new NotFoundResourceException("Coupon with ID '$id' does not exist");
        }

        $coupon->where('id', $id)->delete();

        return new CouponResource($coupon);
    }
}
