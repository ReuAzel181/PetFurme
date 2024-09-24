<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ApiMessageController extends Controller
{
    // Fetch all messages
    public function index()
    {
        return Message::with(['user', 'conversation'])->get();
    }

    // Store a new message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', // Validate user_id
            'conversation_id' => 'required|exists:conversations,id', // Validate conversation_id
        ]);

        $message = Message::create($validated);
        return response()->json($message, 201);
    }
}
