<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    public $timestamps = false;

    protected $fillable = [
        'color',
        'code',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
