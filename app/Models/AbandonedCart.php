<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_token',
        'customer_name',
        'customer_phone',
        'customer_email',
        'city',
        'shipping_address',
        'items',
        'subtotal',
        'total',
        'status',
        'recovery_discount_code',
        'contacted_at',
        'recovered_at',
        'notes',
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'float',
        'total' => 'float',
        'contacted_at' => 'datetime',
        'recovered_at' => 'datetime',
    ];

    /**
     * International WhatsApp phone (923xxxxxxxxx).
     */
    public function getWhatsappPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone ?? '');
        if (str_starts_with($phone, '03')) {
            $phone = '92' . substr($phone, 1);
        } elseif (str_starts_with($phone, '3')) {
            $phone = '92' . $phone;
        }
        return $phone;
    }

    /**
     * Get item summary names string.
     */
    public function getItemsSummaryAttribute(): string
    {
        if (!is_array($this->items) || empty($this->items)) {
            return 'Handcrafted Leather Selection';
        }
        $names = [];
        foreach ($this->items as $it) {
            $names[] = ($it['name'] ?? 'Leather Article') . ' (x' . ($it['quantity'] ?? $it['qty'] ?? 1) . ')';
        }
        return implode(', ', $names);
    }

    /**
     * Template 1: Gentle Bag Reminder WhatsApp text.
     */
    public function getGentleReminderMessageAttribute(): string
    {
        $name = $this->customer_name ?: 'Valued Patron';
        $items = $this->items_summary;
        $url = url('/checkout');

        return "Assalam o Alaikum {$name}, we noticed you left your bespoke selection ({$items}) in your By Zunash shopping bag. Would you like our client concierge to assist you with sizing, leather choice, or arranging door-to-door Cash on Delivery? Resume your order here: {$url}";
    }

    /**
     * Template 2: Exclusive 5% Courtesy Voucher WhatsApp text.
     */
    public function getSpecialDiscountMessageAttribute(): string
    {
        $name = $this->customer_name ?: 'Valued Patron';
        $items = $this->items_summary;
        $code = $this->recovery_discount_code ?: 'ATELIER5';
        $url = url('/checkout?coupon=' . $code);

        return "Dear {$name}, as a warm welcome from By Zunash, here is an exclusive 5% courtesy discount voucher [{$code}] to complete your handcrafted order for ({$items}). Resume your order with 5% off here: {$url}";
    }
}
