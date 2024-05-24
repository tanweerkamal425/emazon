<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PGPayment extends Model
{
    use HasFactory;


    protected $table = "pg_payments";
    protected $fillable = [
        "amount",
        "order_group_id",
        "pg_payment_id",
        "pg_order_id",
        "mode",
        "status",
    ];
}

