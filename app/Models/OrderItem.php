<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = "order_items";

    protected $fillable = [
        "order_id",
        "cart_id",
        "user_id",
        "product_id",
        "qty",
        "price_mp",
        "price_sp",
        "discount",
        "status",
        "flags",
        "shipped_at",
        "dilivered_at",
        "ancellation_requested_at",
        "cancealled_at",
        "return_requested_at",
        "returned_at",
        "refund_requested_at",
        "refunded_at",
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
