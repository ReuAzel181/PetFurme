@extends('layouts.mobile-app')

@section('content')
<div class="flex flex-col h-screen">
    <!-- Chat Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-3 flex items-center">
            <a href="{{ route('messages.index') }}" class="text-gray-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <img src="{{ $conversation->vet->photo_url }}" 
                 alt="Vet Photo"
                 class="w-10 h-10 rounded-full object-cover">
            <div class="ml-3">
                <h1 class="font-semibold">Dr. {{ $conversation->vet->name }}</h1>
                <p class="text-xs text-gray-500">
                    @if($conversation->vet->is_online)
                        <span class="text-green-500">● Online</span>
                    @else
                        Last seen {{ $conversation->vet->last_seen_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto px-4 py-4 bg-gray-50" id="messages-container">
        @foreach($messages as $message)
            <div class="mb-4 {{ $message->sender_type === 'pet_owner' ? 'flex justify-end' : 'flex justify-start' }}">
                <div class="{{ $message->sender_type === 'pet_owner' ? 
                    'bg-blue-600 text-white' : 'bg-white text-gray-800' }} 
                    rounded-lg px-4 py-2 max-w-[80%] shadow-sm">
                    <p class="text-sm">{{ $message->content }}</p>
                    <span class="text-xs {{ $message->sender_type === 'pet_owner' ? 
                        'text-blue-100' : 'text-gray-500' }} block mt-1">
                        {{ $message->created_at->format('g:i A') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t p-4">
        <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex items-center">
            @csrf
            <input type="text" 
                   name="message" 
                   placeholder="Type your message..." 
                   class="flex-1 border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500 mr-3"
                   required>
            <button type="submit" 
                    class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-700">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
});
</script>
@endpush 