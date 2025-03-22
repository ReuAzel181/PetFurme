<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'breed',
        'age',
        'weight',
        'gender',
        'photo',
        'photo_data',
        'user_id',
        'verified_by'
    ];

    protected $appends = ['photo_url'];

    protected $casts = [
        'age' => 'integer',
        'weight' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(\App\Models\ApptVaccination::class, 'pet_id');
    }

    public static function getTotalCount()
    {
        return self::count();
    }

    public static function getTodayCount()
    {
        return self::whereDate('created_at', today())->count();
    }

    public function getPhotoUrlAttribute()
    {
        try {
            if ($this->photo_data) {
                $base64Data = base64_encode($this->photo_data);
                if ($base64Data) {
                    return 'data:image/jpeg;base64,' . $base64Data;
                }
            }
            
            if ($this->photo && Storage::disk('public')->exists($this->photo)) {
                return asset('storage/' . $this->photo);
            }
        } catch (\Exception $e) {
            \Log::warning('Error getting pet photo URL:', [
                'pet_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return asset('storage/defaults/paw.png');
    }

    /**
     * Get the owner (user) that owns the pet.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
