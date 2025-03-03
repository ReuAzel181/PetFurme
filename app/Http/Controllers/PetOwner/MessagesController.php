<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessagesController extends Controller
{
    public function index()
    {
        // Get the first admin as default receiver
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            abort(404, 'No admin found to handle messages');
        }

        // Get or create a single conversation for the pet owner
        $conversation = Conversation::firstOrCreate(
            ['pet_owner_id' => auth()->id()],
            [
                'unique_key' => Conversation::generateUniqueKey(),
                'admin_id' => $admin->id
            ]
        );

        // Get all messages for this conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->orWhere(function($query) use ($admin) {
                $query->whereNull('conversation_id')
                    ->where('sender_id', auth()->id())
                    ->where('receiver_id', $admin->id);
            })
            ->orderBy('created_at')
            ->get();

        // Update any messages that don't have a conversation_id
        Message::whereNull('conversation_id')
            ->where('sender_id', auth()->id())
            ->where('receiver_id', $admin->id)
            ->update(['conversation_id' => $conversation->id]);

        // Add conversation data to clinic contact
        $clinicContact = new User([
            'id' => $admin->id,
            'name' => 'VetCare Clinic',
            'role' => 'admin',
            'photo' => $admin->photo
        ]);

        $clinicContact->conversation = $conversation;
        $clinicContact->unreadCount = $messages->where('receiver_id', auth()->id())
            ->where('sent_at', null)
            ->count();
        $clinicContact->lastMessage = $messages->first();

        // Redirect directly to chat if there are messages
        if ($messages->isNotEmpty()) {
            return redirect()->route('pet-owner.messages.show');
        }

        return view('pet-owner.messages.index', [
            'clinicContact' => $clinicContact
        ]);
    }

    public function show()
    {
        $cacheKey = 'messages_' . auth()->id();
        
        return Cache::remember($cacheKey, now()->addSeconds(30), function () {
            // Get the first admin as default receiver
            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                abort(404, 'No admin found to handle messages');
            }

            // Get or create a single conversation
            $conversation = Conversation::firstOrCreate(
                ['pet_owner_id' => auth()->id()],
                [
                    'unique_key' => Conversation::generateUniqueKey(),
                    'admin_id' => $admin->id
                ]
            );

            // Get messages with caching
            $messages = Cache::remember(
                'conversation_' . $conversation->id, 
                now()->addSeconds(30), 
                function () use ($conversation) {
                    return Message::where(function($query) use ($conversation) {
                        $query->where('conversation_id', $conversation->id)
                              ->orWhere(function($q) use ($conversation) {
                                  $q->whereNull('conversation_id')
                                    ->where(function($q2) use ($conversation) {
                                        $q2->where('sender_id', $conversation->pet_owner_id)
                                           ->orWhere('sender_id', $conversation->admin_id);
                                    })
                                    ->where(function($q2) use ($conversation) {
                                        $q2->where('receiver_id', $conversation->pet_owner_id)
                                           ->orWhere('receiver_id', $conversation->admin_id);
                                    });
                              });
                    })
                    ->with(['sender'])
                    ->orderBy('created_at')
                    ->get();
                }
            );

            return view('pet-owner.messages.show', compact('conversation', 'messages'));
        });
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Get the first admin as default receiver
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            abort(404, 'No admin found to handle messages');
        }

        // Get or create conversation
        $conversation = Conversation::firstOrCreate(
            ['pet_owner_id' => auth()->id()],
            [
                'unique_key' => Conversation::generateUniqueKey(),
                'admin_id' => $admin->id
            ]
        );

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $admin->id,
            'message' => $request->message
        ]);

        // Clear relevant caches
        Cache::forget('messages_' . auth()->id());
        Cache::forget('conversation_' . $conversation->id);

        return back();
    }
} 