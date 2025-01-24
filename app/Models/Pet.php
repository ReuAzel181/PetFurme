<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'size',
        'allergies',
        'notes',
        'photo',
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
}
