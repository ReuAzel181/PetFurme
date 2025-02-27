<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'pet_owner')
            ->with(['receivedMessages' => function($query) {
                $query->where('receiver_id', auth()->id())
                      ->whereNull('read_at');
            }])
            ->with(['lastMessage' => function ($query) {
                $query->latest('sent_at');
            }])
            ->get();

        return view('message.index', compact('users'));
    }

    public function chat($receiverId)
    {
        $users = User::where('role', 'pet_owner')
            ->withCount([
                'receivedMessages as unread_messages_count' => function ($query) {
                    $query->where('receiver_id', auth()->id())
                          ->whereNull('read_at');
                }
            ])
            ->with(['lastMessage' => function ($query) {
                $query->latest('sent_at');
            }])
            ->get();

        $receiver = User::findOrFail($receiverId);
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        // Mark messages as read when opening chat
        Message::where('sender_id', $receiverId)
              ->where('receiver_id', auth()->id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);

        return view('message.chat', compact('users', 'receiver', 'messages'));
    }
    

    public function sendMessage(Request $request, $receiverId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $validated['message'],
            'sent_at' => now(),
        ]);
    
        return redirect()->route('messages.chat', $receiverId)->with('success', 'Message sent!');
    }
    
    public function markAsRead($userId)
    {
        Message::where('sender_id', $userId)
              ->where('receiver_id', auth()->id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
