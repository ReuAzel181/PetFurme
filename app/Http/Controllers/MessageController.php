<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        // List all pet owners
        $users = User::where('role', 'pet_owner')->get();
        return view('message.users', compact('users'));
    }

    public function chat($receiverId)
    {
        $users = User::where('role', 'pet_owner')->get();
        $receiver = User::findOrFail($receiverId);
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();
    
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
    
}
