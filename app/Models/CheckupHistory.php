<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupHistory extends Model
{
    protected $fillable = [
        'pet_id',
        'category',
        'checkup_date',
        'results',
        'existing_symptoms',
        'current_medication',
        'new_medication',
    ];

    protected $casts = [
        'checkup_date' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}