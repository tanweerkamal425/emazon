<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';
    public $timestamps = false;

    protected $fillable = [
        'size',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
