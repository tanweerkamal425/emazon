<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = "refunds";
    protected $fillable = [
        "user_id",
        "order_id",
        "order_item_id",
        "payment_id",
        "amount",
        "pg_refund_id",
        "pg_status",
    ];
}
