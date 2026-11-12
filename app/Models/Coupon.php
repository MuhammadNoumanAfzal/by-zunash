<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'min_spend',
        'max_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'float',
        'min_spend' => 'float',
        'max_discount' => 'float',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope only currently active, unexpired, and unexhausted coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    /**
     * Check if coupon has expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if usage limit has been exceeded.
     */
    public function getIsLimitReachedAttribute(): bool
    {
        return $this->usage_limit !== null && $this->used_count >= $this->usage_limit;
    }

    /**
     * Formatted discount tag (e.g. "15% OFF" or "Rs. 1,000 OFF").
     */
    public function getBadgeTextAttribute(): string
    {
        if ($this->type === 'percentage') {
            return rtrim(rtrim(number_format($this->value, 1), '0'), '.') . '% OFF';
        }
        return 'Rs. ' . number_format($this->value) . ' OFF';
    }

    /**
     * Remaining days or countdown text.
     */
    public function getExpiryTextAttribute(): string
    {
        if (!$this->expires_at) {
            return 'Never expires';
        }
        if ($this->is_expired) {
            return 'Expired ' . $this->expires_at->diffForHumans();
        }
        return 'Expires in ' . $this->expires_at->diffForHumans(['parts' => 2]);
    }

    /**
     * Validate coupon against cart subtotal with informative error reason.
     */
    public function validateForCart(float $subtotal, ?string &$error = null): bool
    {
        if (!$this->is_active) {
            $error = 'This promotional code is currently inactive.';
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            $error = 'This promotion begins on ' . $this->starts_at->format('M d, Y') . '.';
            return false;
        }

        if ($this->is_expired) {
            $error = 'This promotional code expired on ' . $this->expires_at->format('M d, Y') . '.';
            return false;
        }

        if ($this->is_limit_reached) {
            $error = 'This promotion has reached its maximum redemption limit of ' . $this->usage_limit . ' uses.';
            return false;
        }

        if ($this->min_spend > 0 && $subtotal < $this->min_spend) {
            $error = 'This coupon is valid on orders of at least Rs. ' . number_format($this->min_spend) . ' (Cart is Rs. ' . number_format($subtotal) . ').';
            return false;
        }

        return true;
    }

    /**
     * Calculate exact PKR discount.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            $discount = ($subtotal * $this->value) / 100.0;
            if ($this->max_discount !== null && $this->max_discount > 0) {
                $discount = min($discount, $this->max_discount);
            }
            return round($discount, 2);
        }

        // Fixed amount discount cannot exceed subtotal
        return round(min($this->value, $subtotal), 2);
    }
}
