<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'badge',
        'description',
        'image',
        'deal_price',
        'original_price',
        'discount_percentage',
        'is_active',
        'is_featured',
        'start_date',
        'end_date',
        'sort_order',
    ];

    protected $casts = [
        'deal_price' => 'float',
        'original_price' => 'float',
        'discount_percentage' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'sort_order' => 'integer',
    ];

    /**
     * Associated products in this deal bundle
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'deal_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Active deals query scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            });
    }

    /**
     * Calculate effective original price from products if not explicitly set
     */
    public function getEffectiveOriginalPriceAttribute(): float
    {
        if ($this->original_price && $this->original_price > 0) {
            return (float) $this->original_price;
        }

        $sum = 0;
        foreach ($this->products as $product) {
            $qty = $product->pivot->quantity ?? 1;
            $sum += ((float) $product->price) * $qty;
        }

        return (float) $sum;
    }

    /**
     * Calculate total rupee savings
     */
    public function getSavingsAmountAttribute(): float
    {
        $orig = $this->effective_original_price;
        return max(0, $orig - (float) $this->deal_price);
    }

    /**
     * Calculate savings percentage
     */
    public function getSavingsPercentageAttribute(): int
    {
        if ($this->discount_percentage && $this->discount_percentage > 0) {
            return (int) $this->discount_percentage;
        }

        $orig = $this->effective_original_price;
        if ($orig > 0 && $orig > $this->deal_price) {
            return (int) round((($orig - (float) $this->deal_price) / $orig) * 100);
        }

        return 0;
    }
}

