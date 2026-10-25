<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'category_slug',
        'category_name',
        'price',
        'original_price',
        'sku',
        'badge',
        'is_bestseller',
        'is_new',
        'in_stock',
        'availability',
        'stock_quantity',
        'rating',
        'reviews_count',
        'short_description',
        'description',
        'image',
        'gallery',
        'features',
        'specifications',
        'colors',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'in_stock' => 'boolean',
        'stock_quantity' => 'integer',
        'rating' => 'float',
        'reviews_count' => 'integer',
        'gallery' => 'array',
        'features' => 'array',
        'specifications' => 'array',
        'colors' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
