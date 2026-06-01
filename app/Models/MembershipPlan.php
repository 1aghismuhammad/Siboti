<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_days',
        'price',
        'is_active',
    ];
}
