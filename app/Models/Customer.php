<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'address',
        'is_vip',
        'total_orders',
        'total_spent',
    ];

    protected $casts = [
        'is_vip' => 'boolean',
        'total_orders' => 'integer',
        'total_spent' => 'float',
    ];
}
