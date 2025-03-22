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
        'confirmed_at',
        'actions',
        'other_reason'
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

    // Update the mutator to properly handle different input formats
    public function setReasonForVisitAttribute($value)
    {
        // If it's already a string with commas, just encode it as an array
        if (is_string($value) && strpos($value, ',') !== false) {
            $reasons = array_map('trim', explode(',', $value));
            $this->attributes['reason_for_visit'] = json_encode($reasons);
            return;
        }

        // If it's a string that looks like JSON, decode and re-encode to clean it
        if (is_string($value) && (strpos($value, '[') === 0 || strpos($value, '{') === 0)) {
            try {
                $decoded = json_decode($value, true);
                if (is_array($decoded)) {
                    // Flatten and clean the array
                    $reasons = [];
                    array_walk_recursive($decoded, function($item) use (&$reasons) {
                        if (is_string($item)) {
                            $reasons[] = trim($item);
                        }
                    });
                    $this->attributes['reason_for_visit'] = json_encode(array_values(array_unique($reasons)));
                    return;
                }
            } catch (\Exception $e) {
                // If JSON decode fails, treat as single reason
            }
        }

        // If it's an array, clean and encode it
        if (is_array($value)) {
            $reasons = [];
            array_walk_recursive($value, function($item) use (&$reasons) {
                if (is_string($item)) {
                    $reasons[] = trim($item);
                }
            });
            $this->attributes['reason_for_visit'] = json_encode(array_values(array_unique($reasons)));
            return;
        }

        // Single reason case
        $this->attributes['reason_for_visit'] = json_encode([$value]);
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
        return $this->belongsTo(User::class, 'created_by');
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

    // Add these relationships to your existing Appointment model
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    public function groomingSessions()
    {
        return $this->hasMany(GroomingSession::class);
    }

    public function surgeries()
    {
        return $this->hasMany(Surgery::class);
    }

    public function laboratoryTests()
    {
        return $this->hasMany(LaboratoryTest::class);
    }

    public function vaccination()
    {
        return $this->hasOne(Vaccination::class);
    }

    /**
     * Get the formatted reason for visit.
     *
     * @return string
     */
    public function getFormattedReasonAttribute()
    {
        $reasons = $this->reason_for_visit;
        
        // If it's already a string, decode it
        if (is_string($reasons)) {
            $reasons = json_decode($reasons, true);
        }
        
        // If it's not an array after decoding or wasn't a string to begin with
        if (!is_array($reasons)) {
            return $reasons;
        }
        
        // Process each reason
        $processed = array_map(function($reason) {
            // If it's a string that looks like JSON
            if (is_string($reason) && (strpos($reason, '[') === 0 || strpos($reason, '{') === 0)) {
                try {
                    $decoded = json_decode($reason, true);
                    if (is_array($decoded)) {
                        return implode(', ', $decoded);
                    }
                } catch (\Exception $e) {
                    // Just continue if decode fails
                }
            }
            return $reason;
        }, $reasons);
        
        // Join with commas
        return implode(', ', $processed);
    }

    public function chargeSlips()
    {
        return $this->hasMany(ChargeSlip::class);
    }

    public function findings()
    {
        return $this->hasMany(Finding::class);
    }
}
