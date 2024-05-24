<?php

namespace App\Models;

use App\Models\Coupon;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";


    protected $fillable = [
        "user_id", "coupon_id",
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function destroyCart()
    {
        // 1. Delete all the cart items of this cart first
        $cart_items = $this->cartItems()->get();
        foreach ($cart_items as $ci) {
            $ci->delete();
        }
        // 2. Delete the cart itself
        return $this->delete();
    }

    public function applyCoupon($coupon)
    {
        $this->coupon_id = $coupon->id;

        return $this;
    }

    public function removeCoupon()
    {
        $this->coupon_id = null;

        return $this;
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
