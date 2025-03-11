@extends('layouts.tabler')

@section('content')
<div class="page-wrapper" style="min-height: 100vh;">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Messages'),
                        'section' => 'OVERVIEW'
                    ])
                </div>
            </div>
            @include('partials._breadcrumbs')
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <!-- Message List -->
                    <div class="col-12 col-md-6 col-lg-4 border-end">
                        <div class="p-3" style="background-color: #f8f9fa;">
                            <div class="input-group">
                                <input type="text" class="form-control" id="messageSearch" placeholder="Search messages...">
                                <button class="btn btn-secondary" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                </button>
                            </div>
                        </div>
                        <div class="chat-users">
                            @foreach ($users as $user)
                                <a href="{{ route('messages.chat', $user->id) }}" 
                                   class="chat-user-item d-flex align-items-center text-decoration-none border-bottom p-3
                                          {{ $user->id == $receiver->id ? 'active' : '' }}">
                                    <div class="me-3">
                                        @if($user->photo)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($user->photo) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="avatar avatar-sm rounded-circle"
                                                 width="32" height="32">
                                        @else
                                            <img src="{{ asset('assets/img/default-avatar.png') }}" 
                                                 alt="No Profile" 
                                                 class="avatar avatar-sm rounded-circle"
                                                 width="32" height="32">
                                        @endif
                                    </div>    
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ $user->name }}</h5>
                                            <small class="text-muted">
                                                @if(isset($user->lastMessage))
                                                    {{ \Carbon\Carbon::parse($user->lastMessage->created_at)
                                                        ->timezone(config('app.timezone'))
                                                        ->format('h:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                        <div class="text-muted text-truncate">
                                            @if(isset($user->lastMessage))
                                                {{ $user->lastMessage->message }}
                                            @else
                                                No messages yet
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Chat Window -->
                    <div class="col-md-6 col-lg-8 d-flex flex-column">
                        @if(isset($receiver))
                            <!-- Chat Header -->
                            <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($receiver->photo)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($receiver->photo) }}" 
                                                 alt="{{ $receiver->name }}" 
                                                 class="rounded-circle shadow-sm"
                                                 width="40" height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/default-avatar.png') }}" 
                                                 alt="No Profile" 
                                                 class="rounded-circle shadow-sm"
                                                 width="40" height="40">
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="mb-0" style="font-size: 0.95rem;">{{ $receiver->name }}</h5>
                                        <small class="text-muted" style="font-size: 0.8rem;">{{ $receiver->phone ?? 'No Phone Number' }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Chat Messages -->
                            <div class="chat-body flex-grow-1 p-4" style="background-color: #f8f9fa; overflow-y: auto;">
                                <div class="chat-messages">
                                    @foreach($messages as $message)
                                        <div class="message mb-3 {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                                            <div class="message-bubble p-3 rounded-3 {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-white' }}">
                                                <p class="mb-1">{{ $message->message }}</p>
                                                <small class="text-{{ $message->sender_id === auth()->id() ? 'light' : 'muted' }}">
                                                    {{ \Carbon\Carbon::parse($message->created_at)
                                                        ->timezone(config('app.timezone'))
                                                        ->format('h:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Chat Footer -->
                            <div class="p-3 bg-white border-top">
                                <form method="POST" action="{{ route('messages.send', $receiver->id) }}" class="m-0">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                                        <button class="btn btn-primary" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                                </div>
                                <h3>Select a conversation</h3>
                                <p>Choose a contact from the left to start messaging</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .page-body {
        flex: 1;
        overflow: hidden;
    }

    .container-xl {
        overflow: hidden;
        padding: 0;
    }

    .card {
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 12px;
        overflow: hidden;
        margin: 1rem;
    }

    .chat-users {
        height: calc(100vh - 20rem);
        overflow-y: auto;
    }

    .chat-users::-webkit-scrollbar {
        width: 4px;
    }

    .chat-users::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-users::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 4px;
    }

    .chat-user-item {
        padding: 1rem;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .chat-user-item:hover {
        transform: translateX(5px);
        background-color: #f8f9fa;
        border-left: 4px solid #206bc4;
    }

    .chat-user-item.active {
        background-color: #f0f0f0;
        border-left: 4px solid #206bc4;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
    }

    .chat-user-item.active h5 {
        color: #206bc4;
    }

    .chat-user-item {
        position: relative;
        overflow: hidden;
    }

    .chat-user-item::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background-color: #206bc4;
        transform: translateX(-4px);
        transition: transform 0.2s ease;
    }

    .chat-user-item:hover::after {
        transform: translateX(0);
    }

    .avatar {
        object-fit: cover;
    }

    .text-muted {
        font-size: 0.875rem;
    }

    .message {
        max-width: 80%;
    }

    .message.sent {
        margin-left: auto;
    }

    .message.received {
        margin-right: auto;
    }

    .message-bubble {
        display: inline-block;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .sent .message-bubble {
        border-radius: 15px 15px 0 15px !important;
    }

    .received .message-bubble {
        border-radius: 15px 15px 15px 0 !important;
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .chat-body {
        height: calc(100vh - 23rem);
        overflow-y: auto;
        background-color: #f8f9fa;
    }

    .chat-header {
        height: 72px;
    }

    .chat-footer {
        height: 85px;
    }

    .row {
        margin: 0;
    }

    .col-12, .col-md-6, .col-lg-4, .col-lg-8 {
        padding: 0;
    }

    .page-header {
        margin: 0;
        padding: 1rem 0;
    }

    .page-body {
        padding: 0;
    }

    .container-xl > .card {
        margin: 0;
    }

    /* Add shadow to images */
    .rounded-circle.shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to bottom of chat
        const chatBody = document.querySelector('.chat-body');
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Message search functionality
        const messageSearch = document.getElementById('messageSearch');
        const chatUserItems = document.querySelectorAll('.chat-user-item');

        messageSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatUserItems.forEach(item => {
                const userName = item.querySelector('h5').textContent.toLowerCase();
                const lastMessage = item.querySelector('div').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
