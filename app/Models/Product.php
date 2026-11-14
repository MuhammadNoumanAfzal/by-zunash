<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'category_slug',
        'category_name',
        'subcategory_id',
        'price',
        'cost_price',
        'original_price',
        'sku',
        'badge',
        'is_bestseller',
        'is_new',
        'in_stock',
        'availability',
        'lead_time',
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
        'cost_price' => 'float',
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

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    /**
     * Deals / bundles that include this product
     */
    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'deal_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Active deals for this product
     */
    public function activeDeals()
    {
        return $this->deals()->where('is_active', true);
    }

    /**
     * Estimated Profit Per Unit (Selling Price - Cost/Purchase Price)
     */
    public function getProfitPerUnitAttribute(): float
    {
        return max(0, (float)$this->price - (float)($this->cost_price ?? 0));
    }

    /**
     * Profit Margin Percentage
     */
    public function getMarginPercentageAttribute(): float
    {
        if ((float)$this->price <= 0) return 0.0;
        return round((($this->price - (float)($this->cost_price ?? 0)) / $this->price) * 100, 1);
    }
}
