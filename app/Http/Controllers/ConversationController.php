<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()->get();
        return view('conversations.index', compact('conversations'));
    }

    public function show($id)
    {
        $conversation = Conversation::findOrFail($id);
        $messages = $conversation->messages()->with('user')->get();
        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);

        $conversation = new Conversation();
        $conversation->name = $request->name;
        $conversation->save();

        // Add the authenticated user to the conversation
        $conversation->participants()->attach(Auth::id());

        return redirect()->route('conversations.index');
    }
}
