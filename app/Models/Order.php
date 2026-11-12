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
        'courier_name',
        'tracking_number',
        'tracking_url',
        'dispatched_at',
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
        'dispatched_at' => 'datetime',
    ];

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
}
