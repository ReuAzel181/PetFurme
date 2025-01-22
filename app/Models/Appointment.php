<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    protected $fillable = [
        'user_id',
        'pet_id',
        'owner_name',
        'pet_name',
        'appointment_date',
        'appointment_time',
        'reason_for_visit',
    ];

    // Automatically cast `reason_for_visit` to array when accessed
    protected $casts = [
        'reason_for_visit' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
