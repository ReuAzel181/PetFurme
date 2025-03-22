<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $table = 'appt_vaccinations';

    protected $fillable = [
        'appointment_id',
        'pet_id',
        'type',
        'batch_number',
        'date_given',
        'next_due_date',
        'administered_by',
        'reactions',
    ];

    protected $casts = [
        'date_given' => 'date',
        'next_due_date' => 'date',
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