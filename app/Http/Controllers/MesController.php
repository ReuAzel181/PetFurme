<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesController extends Controller
{
    // Display list of conversations
    public function index()
    {
        // Get all conversations for the authenticated user (assume users have conversations)
        $conversations = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('message.index', compact('conversations'));
    }

    // Display messages in a specific conversation
    public function show($conversationId)
    {
        $conversation = Conversation::where('id', $conversationId)
                                    ->whereHas('participants', function ($query) {
                                        $query->where('user_id', Auth::id());
                                    })
                                    ->firstOrFail();
    
        $messages = $conversation->messages()->with('user')->get();
    
        return view('message.show', compact('conversation', 'messages'));
    }
    

    // Send a new message
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
    
        $message = new Message();
        $message->conversation_id = $conversationId;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();
    
        return redirect()->route('messages.show', $conversationId)
                        ->with('success', 'Message sent successfully!');
    }
    
}
