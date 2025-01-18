<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'user_id',
        'owner_name',
        'name',
        'category',
        'gender',
        'breed',
        'age',
        'weight',
        'allergies',
        'notes',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
