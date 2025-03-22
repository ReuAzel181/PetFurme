<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'date',
        'service_type',
        'findings',
        'vital_signs',
        'treatment',
        'medications',
        'next_visit',
        'notes',
    ];

    protected $dates = [
        'date',
        'next_visit',
    ];

    protected $table = 'appt_checkups';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
} 