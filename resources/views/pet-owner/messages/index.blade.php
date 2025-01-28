@extends('layouts.mobile-app')

@section('content')
<div class="flex flex-col h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-3 flex items-center">
            <a href="{{ route('pet-owner.dashboard') }}" class="text-gray-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-lg font-semibold">Messages</h1>
        </div>
    </div>

    <!-- Chat List -->
    <div class="flex-1 overflow-y-auto px-4 py-4">
        @forelse($conversations as $conversation)
            <a href="{{ route('messages.show', $conversation) }}" 
               class="block bg-white rounded-xl p-4 mb-3 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <img src="{{ $conversation->vet->photo_url }}" 
                             alt="Vet Photo"
                             class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium text-gray-900">Dr. {{ $conversation->vet->name }}</h3>
                            <span class="text-xs text-gray-500">
                                {{ $conversation->latestMessage->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ Str::limit($conversation->latestMessage->content, 50) }}
                        </p>
                        @if($conversation->unreadCount > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                                {{ $conversation->unreadCount }} new
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-8">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comments text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-gray-600 font-medium mb-2">No Messages Yet</h3>
                <p class="text-gray-500 text-sm mb-4">Start a conversation with our veterinary team</p>
                <a href="{{ route('messages.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    New Conversation
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection 