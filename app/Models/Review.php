<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'city',
        'initials',
        'category',
        'product_name',
        'product_slug',
        'rating',
        'title',
        'comment',
        'image',
        'helpful',
        'verified',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful' => 'integer',
        'verified' => 'boolean',
    ];
}
