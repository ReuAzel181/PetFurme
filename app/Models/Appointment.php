<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'appointment';

    protected $fillable = [
        'user_id',
        'pet_id',
        'reason_for_visit',
        'appointment_date',
        'appointment_time',
    ];

    // An appointment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An appointment belongs to a pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
