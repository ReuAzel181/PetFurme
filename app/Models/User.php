<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // A user can have many pets
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    // A user can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
