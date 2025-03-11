<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\SystemNotification;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'owner_name',
        'name',
        'category',
        'type',
        'gender',
        'breed',
        'age',
        'weight',
        'allergies',
        'notes',
        'photo',
        'size',
        'created_by',
        'verified_by'
    ];

    protected $casts = [
        'age' => 'integer',
        'weight' => 'float',
        'photo_data' => 'string',
        'photo' => 'string',
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
        if (!$this->photo) {
            return asset('images/default-pet.png');
        }

        if (Str::startsWith($this->photo, ['http://', 'https://'])) {
            return $this->photo;
        }

        if (Str::startsWith($this->photo, 'uploads/')) {
            return Storage::disk('public')->exists($this->photo) 
                ? asset('storage/' . $this->photo)
                : asset('images/default-pet.png');
        }

        return asset('images/default-pet.png');
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

    protected static function booted()
    {
        static::created(function ($pet) {
            Notification::create([
                'id' => Str::uuid(),
                'type' => 'new_pet',
                'notifiable_type' => 'App\\Models\\Pet',
                'notifiable_id' => $pet->id,
                'data' => [
                    'message' => "New pet registered: {$pet->name}",
                    'pet_id' => $pet->id
                ],
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}
