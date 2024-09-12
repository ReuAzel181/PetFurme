<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // Define the relationship with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Define participants relationship (many-to-many with users)
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
