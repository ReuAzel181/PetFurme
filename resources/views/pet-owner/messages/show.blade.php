@extends('layouts.mobile-app')

@section('content')
<div class="flex flex-col h-screen">
    <!-- Chat Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-3 flex items-center">
            <a href="{{ route('pet-owner.messages.index') }}" class="text-gray-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <img src="{{ asset('storage/defaults/clinic-logo.png') }}" 
                 alt="Clinic Logo"
                 class="w-10 h-10 rounded-full object-cover">
            <div class="ml-3">
                <h1 class="font-semibold">VetCare Clinic</h1>
                <p class="text-xs text-gray-500">Support</p>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto px-4 py-4 bg-gray-50" id="messages-container">
        @foreach($messages as $message)
            <div class="mb-4 {{ $message->sender_id === auth()->id() ? 'flex justify-end' : 'flex justify-start' }}">
                <div class="{{ $message->sender_id === auth()->id() ? 
                    'bg-blue-600 text-white' : 'bg-white text-gray-800' }} 
                    rounded-lg px-4 py-2 max-w-[80%] shadow-sm">
                    <p class="text-sm">{{ $message->message }}</p>
                    <span class="text-xs {{ $message->sender_id === auth()->id() ? 
                        'text-blue-100' : 'text-gray-500' }} block mt-1">
                        {{ $message->created_at->format('g:i A') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t p-4">
        <form action="{{ route('pet-owner.messages.store') }}" method="POST" class="flex items-center">
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