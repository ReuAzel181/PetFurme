<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApptVaccination extends Model
{
    protected $table = 'appt_vaccinations';
    
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'type',
        'batch_number',
        'date_given',
        'next_due_date',
        'administered_by'
    ];

    protected $dates = [
        'date_given',
        'next_due_date'
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