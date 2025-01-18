<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'breed',
        'age',
        'owner_name',
        'allergies',
        'notes',
        'category',
        'gender',
        'weight',
        'photo',
    ];

    public static function getTotalCount()
    {
        return self::count();
    }

    public static function getTodayCount()
    {
        return self::whereDate('created_at', now()->toDateString())->count();
    }


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Appointment
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
}
