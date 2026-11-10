<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'sku',
        'admin_name',
        'change_type',
        'quantity_change',
        'previous_stock',
        'new_stock',
        'reason',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
