<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryTest extends Model
{
    protected $fillable = [
        'appointment_id',
        'pet_id',
        'test_type',
        'results',
        'interpretation',
        'recommendations',
        'date_performed',
        'follow_up_date',
    ];

    protected $dates = [
        'date_performed',
        'follow_up_date',
    ];

    protected $table = 'appt_laboratory';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
} 