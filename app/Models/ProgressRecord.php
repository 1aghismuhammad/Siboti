<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressRecord extends Model
{
    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'muscle_mass',
        'fat_percentage',
        'notes',
    ];

    protected $casts = [
        'weight' => 'float',
        'height' => 'float',
        'muscle_mass' => 'float',
        'fat_percentage' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
