<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'surgery_type',
        'pre_surgery_notes',
        'anesthesia_used',
        'procedure_notes',
        'recovery_notes',
        'post_surgery_care',
        'follow_up_date',
    ];

    protected $dates = [
        'follow_up_date',
    ];

    protected $table = 'appt_surgeries';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
} 