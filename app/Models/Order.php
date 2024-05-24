<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_group_id',
        'amount',
        'gross_total',
        'sub_total',
        'discount',
        'user_id',
        'tax',
        'shipment',
        'applied_coupon_id',
        'status',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
        // return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function findByRazorpayOrderId($rzp_order_id)
    {
        return static::where('rzp_order_id', $rzp_order_id)->first();
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'applied_coupon_id');
    }
}
