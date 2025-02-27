<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroomingSession extends Model
{
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'date',
        'services_done',
        'products_used',
        'notes',
    ];

    protected $dates = [
        'date',
    ];

    protected $casts = [
        'services_done' => 'array',
        'products_used' => 'array',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
} 