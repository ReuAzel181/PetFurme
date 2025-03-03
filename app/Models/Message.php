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
        'receivers',
        'message',
        'sent_at',
        'read_at',
        'is_automated',
        'bot_context'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'receivers' => 'array',
        'is_automated' => 'boolean'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
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
                        'admin_id' => $message->receivers[0]
                    ]
                );
                $message->conversation_id = $conversation->id;
            }
        });
    }
}