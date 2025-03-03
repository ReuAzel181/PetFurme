<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    // Add role constants
    const ROLE_PET_OWNER = 'pet_owner';
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'uuid',
        'role',
        'address',
        'phone',
        'photo',
        'store_name',
        'store_address',
        'store_email',
        'email_verified_at',
        'verified_by',
    ];

    // Hidden fields when the user is serialized
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified' => 'boolean',
        'profile_completed' => 'boolean',
        'role' => 'string',
    ];

    // Add a scope for pet owners
    public function scopePetOwners($query)
    {
        return $query->where('role', self::ROLE_PET_OWNER);
    }

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

    // A user can send many messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // A user can receive many messages
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')
            ->where(function($query) {
                $query->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => $this->id])]);
            });
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user who deleted this user
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Add a helper method to check role
    public function isPetOwner()
    {
        return $this->role === 'pet_owner';
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isStaff()
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }

    /**
     * Route notifications for the Twilio channel.
     *
     * @param  \Notification  $notification
     * @return string
     */
    public function routeNotificationForTwilio($notification)
    {
        // Format the phone number to E.164 format
        // Remove any non-numeric characters and add the country code
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        return '+63' . ltrim($phone, '0'); // Assuming Philippines (+63)
    }

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? 
            asset('storage/' . $this->photo) : 
            asset('storage/defaults/no-avatar.jpg');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'sender_id')
            ->latest('created_at')
            ->withDefault();
    }

    public function allMessages()
    {
        return Message::where(function ($query) {
            $query->where('sender_id', $this->id)
                  ->orWhere('receiver_id', $this->id);
        });
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->whereNull('read_at');
    }

    public function hasUnreadMessages()
    {
        return $this->receivedMessages()
            ->whereNull('read_at')
            ->where(function($query) {
                $query->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])]);
            })
            ->exists();
    }
}
