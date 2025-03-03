@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Pet Owner Messages</h1>
    </div>

    <div class="bg-white rounded-lg shadow">
        <!-- Conversations List -->
        <div class="divide-y">
            @forelse($conversations as $conversation)
                @php
                    $unreadCount = $conversation->messages
                        ->where('receiver_id', auth()->id())
                        ->where('sent_at', null)
                        ->count();
                    $latestMessage = $conversation->messages->first();
                @endphp
                
                <a href="{{ route('admin.messages.show', $conversation->id) }}" 
                   class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start">
                        <img src="{{ $conversation->petOwner->photo_url ?? asset('images/default-avatar.png') }}" 
                             alt="Pet Owner Photo" 
                             class="w-12 h-12 rounded-full object-cover">
                        
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-gray-900">
                                    {{ $conversation->petOwner->name }}
                                </h3>
                                @if($latestMessage)
                                    <span class="text-sm text-gray-500">
                                        {{ $latestMessage->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $latestMessage ? Str::limit($latestMessage->message, 50) : 'No messages yet' }}
                            </p>
                            
                            @if($unreadCount > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                                    {{ $unreadCount }} new
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <p class="text-gray-500">No conversations yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 