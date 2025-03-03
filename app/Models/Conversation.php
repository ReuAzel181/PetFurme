<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'pet_owner_id',
        'admin_id'
    ];

    public function petOwner()
    {
        return $this->belongsTo(User::class, 'pet_owner_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Define participants relationship (many-to-many with users)
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    // Helper method to generate unique key
    public static function generateUniqueKey()
    {
        return uniqid('conv_', true);
    }
}
