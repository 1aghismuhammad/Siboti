<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'trainer_id',
        'booking_date',
        'booking_time',
        'session_type',
        'status',
        'is_direct',
        'admin_approved',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'is_direct' => 'boolean',
        'admin_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
