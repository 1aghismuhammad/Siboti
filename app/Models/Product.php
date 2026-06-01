<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'description',
        'price',
        'stock',
        'badge',
        'badge_class',
        'icon',
        'sales_count',
    ];
}
