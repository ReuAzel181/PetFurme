<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        // Get all conversations with pet owners
        $conversations = Conversation::with(['petOwner', 'messages' => function($query) {
                $query->latest();
            }])
            ->whereHas('petOwner')
            ->latest()
            ->get();

        return view('admin.messages.index', compact('conversations'));
    }

    public function show($conversationId)
    {
        $conversation = Conversation::with(['petOwner', 'messages.sender'])->findOrFail($conversationId);
        
        // Mark unread messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', auth()->id())
            ->whereNull('sent_at')
            ->update(['sent_at' => now()]);

        return view('admin.messages.show', compact('conversation'));
    }

    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $conversation->pet_owner_id,
            'message' => $request->message
        ]);

        return back();
    }
} 