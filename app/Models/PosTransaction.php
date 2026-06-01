<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PosTransaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'cashier',
        'user_id',
        'member_name',
        'total',
        'items_count',
        'status',
        'status_class',
        'transacted_at',
    ];

    protected $casts = [
        'transacted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
