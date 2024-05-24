<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedCoupon extends Model
{
    use HasFactory;

    protected $table = 'applied_coupons';
    
    protected $fillable = [
        'coupon_id',
        'order_id',
        'user_id',
    ];

    public $timestamps = false;
}
