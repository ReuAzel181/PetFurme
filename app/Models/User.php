<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Add role constants
    const ROLE_PET_OWNER = 'pet_owner';
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'photo',
        'password',
        'role',
    ];

    // Hidden fields when the user is serialized
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    // Add a scope for pet owners
    public function scopePetOwners($query)
    {
        return $query->where('role', self::ROLE_PET_OWNER);
    }

    // A user can have many pets
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    // A user can have many appointments
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // A user can send many messages
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // A user can receive many messages
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
