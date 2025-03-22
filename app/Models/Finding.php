<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'created_by',
        'findings_data',
        'additional_notes',
        'recommendations',
        'diagnosis',
        'treatment_plan',
        'follow_up_date',
        'status'
    ];

    protected $casts = [
        'findings_data' => 'array',
        'follow_up_date' => 'date'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
} 