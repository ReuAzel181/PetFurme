<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointment';

    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'user_id',
        'pet_id',
        'owner_name',
        'pet_name',
        'pet_type',
        'pet_age',
        'appointment_date',
        'appointment_time',
        'reason_for_visit',
        'deleted_by',
        'notes',
        'status',
        'created_by_type',
        'created_by_id',
        'confirmed_by',
        'confirmed_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'appointment_date',
        'confirmed_at'
    ];

    protected $casts = [
        'reason_for_visit' => 'array',
        'appointment_date' => 'datetime',
        'deleted_at' => 'datetime',
        'scheduled_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'pending',  // Set default status
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // Update the mutator
    public function setReasonForVisitAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['reason_for_visit'] = $value ? json_encode(explode(',', $value)) : json_encode([]);
        } else {
            $this->attributes['reason_for_visit'] = is_array($value) ? json_encode($value) : json_encode([]);
        }
    }

    // Add an accessor
    public function getReasonForVisitAttribute($value)
    {
        if (empty($value)) return [];
        
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Add this relationship
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getAgeDisplayAttribute()
    {
        if ($this->pet_age >= 12) {
            $years = floor($this->pet_age / 12);
            $months = $this->pet_age % 12;
            if ($months > 0) {
                return "{$years}y {$months}m";
            }
            return "{$years}y";
        }
        return "{$this->pet_age}m";
    }

    public function getIsWalkInAttribute()
    {
        return $this->user_id === null;
    }

    public function getAppointmentDateDisplayAttribute()
    {
        return $this->appointment_date->format('Y-m-d');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    // Add an accessor for creator type
    public function getCreatorTypeAttribute()
    {
        return $this->created_by_type;
    }

    // Helper method to determine if appointment needs confirmation
    public function needsConfirmation()
    {
        return $this->status === 'pending' && $this->created_by_type === 'user';
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
