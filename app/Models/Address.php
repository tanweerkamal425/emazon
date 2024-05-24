<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'title', 
        'full_name', 
        'phone', 
        'address_line_1', 
        'user_id', 
        'town_id'
    ];
}
