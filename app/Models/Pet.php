<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'owner_name',
        'name',
        'category',
        'type',
        'breed',
        'gender',
        'age',
        'weight',
        'allergies',
        'notes',
        'photo'
    ];

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
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
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
}
