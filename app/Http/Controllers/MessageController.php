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
                $query->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])])
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
                    $query->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])])
                          ->whereNull('read_at');
                }
            ])
            ->with(['lastMessage' => function ($query) {
                $query->latest('created_at');
            }])
            ->get();

        $receiver = User::findOrFail($receiverId);
        
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())
                  ->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => $receiverId])]);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])]);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->sortBy('created_at');

        // Mark messages as read
        Message::where('sender_id', $receiverId)
              ->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])])
              ->whereNull('read_at')
              ->update(['read_at' => now()]);

        return view('message.chat', compact('users', 'receiver', 'messages'));
    }
    

    public function sendMessage(Request $request, $receiverId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        $receiver = User::findOrFail($receiverId);
        
        // Use the current timestamp in the application's timezone
        $now = now()->setTimezone(config('app.timezone'));
        
        Message::create([
            'sender_id' => auth()->id(),
            'receivers' => [
                [
                    'id' => $receiverId,
                    'role' => $receiver->role
                ]
            ],
            'message' => $validated['message'],
            'sent_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    
        return redirect()->route('messages.chat', $receiverId)
            ->with('success', 'Message sent!');
    }
    
    public function markAsRead($userId)
    {
        Message::where('sender_id', $userId)
              ->whereRaw('JSON_CONTAINS(receivers, ?)', [json_encode(['id' => auth()->id()])])
              ->whereNull('read_at')
              ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
