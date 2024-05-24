<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";


    protected $fillable = [
        "code",
        "title",
        "subtitle",
        "description",
        "price_mp",
        "price_sp",
        "slug",
        "image_url",
        "category_id",
        "is_returnable",
        "is_published",
        "deleted_at",
        "published_at"

    ];

    public function size(): HasMany
    {
        return $this->hasMany(Size::class);
    }

    public function productSizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public function productColors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
}
