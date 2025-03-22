<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeSlip extends Model
{
    protected $fillable = [
        'invoice_number',
        'appointment_id',
        'patient_name',
        'attending_physician',
        'services',
        'products',
        'services_total',
        'products_total',
        'discount_type',
        'discount_amount',
        'grand_total',
        'notes',
    ];

    protected $casts = [
        'services' => 'array',
        'products' => 'array',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
} 