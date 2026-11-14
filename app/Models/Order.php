<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'postal_code',
        'order_notes',
        'payment_method',
        'payment_receipt',
        'transaction_id',
        'payment_details',
        'payment_status',
        'order_status',
        'is_read',
        'courier_name',
        'tracking_number',
        'tracking_url',
        'dispatched_at',
        'return_reason',
        'return_courier_charge',
        'returned_at',
        'delivered_at',
        'confirmed_at',
        'subtotal',
        'shipping_fee',
        'discount',
        'total',
        'items',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'shipping_fee' => 'float',
        'discount' => 'float',
        'total' => 'float',
        'items' => 'array',
        'is_read' => 'boolean',
        'confirmed_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'returned_at' => 'datetime',
        'delivered_at' => 'datetime',
        'return_courier_charge' => 'float',
    ];

    public function scopeConfirmed($query)
    {
        return $query->where('order_status', 'confirmed');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeDelivered($query)
    {
        return $query->whereIn('order_status', ['completed', 'delivered']);
    }

    public function scopeReturned($query)
    {
        return $query->where('order_status', 'returned');
    }

    public function scopeDispatched($query)
    {
        return $query->where('order_status', 'dispatched');
    }

    /**
     * Calculate Total Product Purchase Cost (COGS) for this order
     */
    public function getTotalCostAttribute(): float
    {
        if (empty($this->items) || !is_array($this->items)) {
            return round($this->subtotal * 0.40, 2);
        }

        $cost = 0;
        foreach ($this->items as $item) {
            $qty = (int)($item['quantity'] ?? $item['qty'] ?? 1);
            $itemCost = (float)($item['cost_price'] ?? 0);

            if ($itemCost <= 0 && !empty($item['id'])) {
                $prod = Product::find($item['id']);
                if ($prod && $prod->cost_price > 0) {
                    $itemCost = (float)$prod->cost_price;
                }
            }

            // Fallback: If product has no cost price set, default to 40% of item price
            if ($itemCost <= 0) {
                $itemCost = round(((float)($item['price'] ?? 0)) * 0.40, 2);
            }

            $cost += ($itemCost * $qty);
        }

        return round($cost, 2);
    }

    /**
     * Real Net Profit on this Order
     */
    public function getNetProfitAttribute(): float
    {
        if ($this->order_status === 'returned') {
            // Direct loss: Return courier fees + forward courier fees
            return -round((float)($this->return_courier_charge > 0 ? $this->return_courier_charge : 250), 2);
        }

        if ($this->order_status === 'cancelled') {
            return 0.0;
        }

        if (in_array($this->order_status, ['completed', 'delivered'])) {
            // Profit = Total received - Product Purchase Cost
            return round($this->total - $this->total_cost, 2);
        }

        // For pending/dispatched orders, estimated prospective profit
        return round($this->total - $this->total_cost, 2);
    }

    /**
     * Clean WhatsApp phone number in international format (e.g. 923214700545).
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
     * Automated or custom tracking link for couriers in Pakistan.
     */
    public function getTrackingLinkAttribute(): string
    {
        if (!empty($this->tracking_url)) {
            return $this->tracking_url;
        }

        $code = trim($this->tracking_number ?? '');
        if (empty($code)) {
            return url('/contact');
        }

        $courier = strtolower($this->courier_name ?? '');

        if (str_contains($courier, 'tcs')) {
            return "https://www.tcsexpress.com/tracking?tracking_no={$code}";
        }
        if (str_contains($courier, 'trax')) {
            return "https://sonic.pk/tracking?tracking_number={$code}";
        }
        if (str_contains($courier, 'leopard')) {
            return "https://www.leopardscourier.com/leopards-tracking/?track_no={$code}";
        }
        if (str_contains($courier, 'call')) {
            return "https://callcourier.com.pk/tracking/?tc={$code}";
        }
        if (str_contains($courier, 'postex')) {
            return "https://postex.pk/tracking?cn={$code}";
        }
        if (str_contains($courier, 'm&p') || str_contains($courier, 'mnp')) {
            return "https://mulphilog.com/tracking?consignment={$code}";
        }
        if (str_contains($courier, 'rider')) {
            return "https://withrider.com/track/{$code}";
        }

        return "https://sonic.pk/tracking?tracking_number={$code}";
    }

    /**
     * Standardized Luxury Atelier WhatsApp Dispatch message.
     */
    public function getWhatsappDispatchMessageAttribute(): string
    {
        $courier = $this->courier_name ?: 'TCS Express';
        $tracking = $this->tracking_number ?: 'BZ-TRK-' . rand(100000, 999999);
        $link = $this->tracking_link;

        return "Dear {$this->customer_name}, your By Zunash order #{$this->order_number} has been dispatched via {$courier}. Tracking ID: {$tracking}. Track here: {$link}";
    }

    /**
     * Polite, Anti-RTO WhatsApp Order Confirmation Message for Pakistani Customers.
     */
    public function getWhatsappConfirmMessageAttribute(): string
    {
        $itemNames = [];
        if (is_array($this->items)) {
            foreach ($this->items as $it) {
                $qty = $it['quantity'] ?? $it['qty'] ?? 1;
                $itemNames[] = ($it['name'] ?? 'Leather Item') . ' (x' . $qty . ')';
            }
        }
        $summary = !empty($itemNames) ? implode(', ', $itemNames) : 'Handcrafted Leather Selection';
        $totalFormatted = number_format($this->total);
        $payMode = $this->payment_method === 'COD' ? 'Cash on Delivery (COD)' : $this->payment_method;

        return "Assalam-o-Alaikum {$this->customer_name}!\n\n"
             . "Thank you for choosing By Zunash Luxury Leather. We have recorded your order #{$this->order_number}:\n\n"
             . "📦 Items: {$summary}\n"
             . "💰 Total Amount: PKR {$totalFormatted} ({$payMode})\n"
             . "📍 Delivery Address: {$this->shipping_address}, {$this->city}\n\n"
             . "Kindly reply *YES* or *CONFIRM* to this message so our atelier can verify and pack your parcel for priority dispatch today.\n\n"
             . "Warm regards,\nBy Zunash Atelier\nLahore, Pakistan";
    }
}
