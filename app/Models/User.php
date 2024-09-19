<?php

/**
 * The User model represents application users and handles authentication.
 * 
 * - Implements MustVerifyEmail for email verification.
 * - Uses $fillable for mass-assignable attributes like name, email, and phone.
 * - Hides sensitive data (password, remember_token) via $hidden.
 * - Casts date fields like email_verified_at and timestamps using $casts.
 * - Includes a search scope for querying by name or email.
 * - Uses 'name' for route model binding.
 */

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'uuid',
        'photo',
        'role',
        'name',
        'pet_name',
        'pet_type',
        'username',
        'email',
        'password',
        'phone',
        "store_name",
        "store_address",
        "store_email",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
