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
        'allowed_payment_methods',
        'custom_shipping_charge',
        'weight_kg',
        'is_free_shipping',
        'lead_time',
        'stock_quantity',
        'rating',
        'reviews_count',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'image',
        'gallery',
        'features',
        'specifications',
        'colors',
        'has_engraving',
        'engraving_price',
        'engraving_placeholder',
        'engraving_note',
        'has_addons',
        'addon_product_ids',
        'addon_discount_percent',
        'has_gift_set',
        'gift_deal_id',
        'gift_set_title',
        'gift_set_subtitle',
        'gift_set_price',
        'gift_set_original_price',
        'gift_set_image',
        'whatsapp_reviews',
    ];

    protected $casts = [
        'price' => 'float',
        'cost_price' => 'float',
        'original_price' => 'float',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'in_stock' => 'boolean',
        'is_free_shipping' => 'boolean',
        'custom_shipping_charge' => 'float',
        'weight_kg' => 'float',
        'stock_quantity' => 'integer',
        'rating' => 'float',
        'reviews_count' => 'integer',
        'gallery' => 'array',
        'features' => 'array',
        'specifications' => 'array',
        'colors' => 'array',
        'has_engraving' => 'boolean',
        'engraving_price' => 'float',
        'has_addons' => 'boolean',
        'addon_product_ids' => 'array',
        'addon_discount_percent' => 'integer',
        'has_gift_set' => 'boolean',
        'gift_deal_id' => 'integer',
        'gift_set_price' => 'float',
        'gift_set_original_price' => 'float',
        'whatsapp_reviews' => 'array',
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

    /**
     * Associated Deal for Gift Set Upgrade
     */
    public function giftDeal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'gift_deal_id');
    }

    /**
     * Resolved Addon Products collection
     */
    public function getResolvedAddonsAttribute()
    {
        if (!$this->has_addons || empty($this->addon_product_ids)) {
            return collect();
        }

        $ids = is_array($this->addon_product_ids) ? $this->addon_product_ids : json_decode($this->addon_product_ids, true);
        if (empty($ids)) {
            return collect();
        }

        return static::whereIn('id', $ids)->where('id', '!=', $this->id)->get();
    }
}
