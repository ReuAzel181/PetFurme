<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    protected static function booted()
    {
        static::creating(function ($message) {
            if (!$message->conversation_id) {
                // Get or create conversation
                $conversation = Conversation::firstOrCreate(
                    [
                        'pet_owner_id' => auth()->id(),
                    ],
                    [
                        'unique_key' => Conversation::generateUniqueKey(),
                        'admin_id' => $message->receiver_id
                    ]
                );
                $message->conversation_id = $conversation->id;
            }
        });
    }
}