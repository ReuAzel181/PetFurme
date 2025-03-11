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
                <div class="row g-0 h-100">
                    <!-- Message List -->
                    <div class="col-12 col-md-6 col-lg-4 bg-white border-end" style="height: calc(100vh - 13rem);">
                        <div class="p-3 border-bottom" style="background-color: #f8f9fa;">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="messageSearch" placeholder="Search messages...">
                                <button class="btn btn-primary btn-sm" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                </button>
                            </div>
                            <div id="searchFeedback" class="mt-2 text-muted d-none">
                                Searching messages from: <span id="searchUser"></span>
                            </div>
                        </div>
                        <div class="chat-users">
                            @foreach ($users->where('role', 'pet_owner') as $user)
                                @php
                                    $hasUnreadMessages = $user->receivedMessages
                                        ->filter(function($message) {
                                            return is_array($message->receivers) && 
                                                   collect($message->receivers)->contains('id', auth()->id()) &&
                                                   is_null($message->read_at);
                                        })
                                        ->count() > 0;
                                @endphp
                                <a href="{{ route('messages.chat', $user->id) }}" 
                                   class="chat-user-item position-relative d-flex align-items-center text-decoration-none border-bottom
                                          {{ $hasUnreadMessages ? 'unread-messages' : '' }}">
                                    <div class="me-3 position-relative">
                                        @if($user->photo)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($user->photo) }}" 
                                                 alt="{{ $user->name }}" 
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
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 text-truncate {{ $hasUnreadMessages ? 'fw-bold' : '' }}" 
                                                    style="font-size: 0.95rem;">
                                                    {{ $user->name }}
                                                </h5>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.8rem;">
                                                @if($user->lastMessage)
                                                    {{ \Carbon\Carbon::parse($user->lastMessage->created_at)
                                                        ->timezone(config('app.timezone'))
                                                        ->format('h:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                        <p class="mb-0 text-truncate {{ $hasUnreadMessages ? 'fw-semibold' : '' }}" 
                                           style="font-size: 0.85rem;">
                                            @if($user->lastMessage)
                                                @if($user->lastMessage->sender_id === auth()->id())
                                                    You: {{ $user->lastMessage->message }}
                                                @else
                                                    {{ $user->lastMessage->message }}
                                                @endif
                                            @else
                                                No messages yet
                                            @endif
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Empty State for Chat Window -->
                    <div class="col-md-6 col-lg-8 d-none d-md-flex flex-column bg-light">
                        <!-- Chat Header -->
                        <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="placeholder-glow">
                                    <div class="placeholder rounded-circle" style="width: 40px; height: 40px;"></div>
                                </div>
                                <div class="ms-3">
                                    <div class="placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State Body -->
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center p-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                    </svg>
                                </div>
                                <h3 class="text-muted">Select a conversation</h3>
                                <p class="text-muted">Choose a contact from the left to start messaging</p>
                            </div>
                        </div>

                        <!-- Chat Footer -->
                        <div class="p-3 bg-white border-top">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message..." disabled>
                                <button class="btn btn-primary" type="button" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>
                            </div>
                        </div>
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
        height: calc(100vh - 13rem);
        overflow: hidden !important;
        border-radius: 0;
    }

    .chat-users {
        height: calc(100% - 60px);
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
        transition: all 0.2s ease;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .chat-user-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    .chat-user-item:hover {
        background-color: rgba(32, 107, 196, 0.03);
    }

    .chat-user-item.active {
        background-color: rgba(32, 107, 196, 0.06);
    }

    .icon-tabler-messages {
        width: 80px;
        height: 80px;
    }

    h3.text-muted {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    p.text-muted {
        font-size: 0.9rem;
    }

    .input-group {
        font-size: 0.875rem;
    }

    .input-group .form-control {
        height: 32px;
    }

    .input-group .btn {
        padding: 0.25rem 0.5rem;
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

    .chat-user-item.unread-messages h5 {
        color: #206bc4;
    }

    .chat-user-item.unread-messages p {
        color: #1a1a1a;
        font-weight: 500;
    }

    .chat-user-item:not(.unread-messages) h5 {
        color: #1a1a1a;
    }

    .chat-user-item:not(.unread-messages) p {
        color: #6c757d;
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
        const searchFeedback = document.getElementById('searchFeedback');
        const searchUser = document.getElementById('searchUser');
        
        // Message search functionality
        const messageSearch = document.getElementById('messageSearch');
        const chatUserItems = document.querySelectorAll('.chat-user-item');

        messageSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatUserItems.forEach(item => {
                const userName = item.querySelector('h5').textContent.toLowerCase();
                const lastMessage = item.querySelector('p').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                    item.style.display = 'flex';
                    if (searchTerm !== '') {
                        searchFeedback.classList.remove('d-none');
                        searchUser.textContent = item.querySelector('h5').textContent;
                    }
                } else {
                    item.style.display = 'none';
                }
            });

            if (searchTerm === '') {
                searchFeedback.classList.add('d-none');
                chatUserItems.forEach(item => {
                    item.style.display = 'flex';
                });
            }
        });

        // Highlight active user
        const currentPath = window.location.pathname;
        
        chatUserItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });

        // Message form submission
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const messagesContainer = document.getElementById('messages-container');

        if (messageForm) {
            messageForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                if (!message) return;

                try {
                    const response = await fetch('/messages/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            message: message,
                            receiver_id: currentChatUserId // You'll need to set this based on selected user
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        // Add message to chat
                        appendMessage({
                            message: message,
                            sent_at: new Date(),
                            sender_id: {{ auth()->id() }}
                        });
                        messageInput.value = '';
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                }
            });
        }

        function appendMessage(message) {
            const messageElement = document.createElement('div');
            messageElement.className = `message mb-3 ${message.sender_id == {{ auth()->id() }} ? 'sent' : 'received'}`;
            
            const time = new Date(message.sent_at).toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            messageElement.innerHTML = `
                <div class="message-bubble p-3 rounded-3 ${message.sender_id == {{ auth()->id() }} ? 'bg-primary text-white' : 'bg-white'}">
                    <p class="mb-1">${message.message}</p>
                    <small class="text-${message.sender_id == {{ auth()->id() }} ? 'light' : 'muted'}">${time}</small>
                </div>
            `;

            messagesContainer.appendChild(messageElement);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Auto-scroll to bottom of messages
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Fetch messages periodically
        setInterval(async function() {
            if (currentChatUserId) {
                try {
                    const response = await fetch(`/messages/get/${currentChatUserId}`);
                    const data = await response.json();
                    updateMessages(data.messages);
                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }
        }, 5000); // Fetch every 5 seconds

        // Add this function to mark messages as read
        async function markMessagesAsRead(userId) {
            try {
                await fetch(`/messages/mark-as-read/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
            } catch (error) {
                console.error('Error marking messages as read:', error);
            }
        }

        // Add click event listener to chat items
        chatUserItems.forEach(item => {
            item.addEventListener('click', function() {
                const userId = this.getAttribute('href').split('/').pop();
                markMessagesAsRead(userId);
            });
        });
    });
</script>
@endpush

<style>
    .page-wrapper {
        display: flex;
        flex-direction: column;
    }
    .hover-bg-light:hover {
        background-color: rgba(0,0,0,0.05);
    }
    .chat-users {
        overflow-y: auto;
        border-top: 1px solid rgba(0,0,0,0.1);
    }
    .chat-users::-webkit-scrollbar {
        width: 8px;
    }
    .chat-users::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .chat-users::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    .chat-user-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
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
    .badge {
        font-size: 1rem;
        padding: 0.4rem 0.8rem;
        min-width: 1.75rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .text-muted {
        color: #6c757d !important;
    }
    .input-group-lg .form-control {
        height: calc(3.5rem + 2px);
        font-size: 1.2rem;
        border-radius: 8px 0 0 8px !important;
    }
    .input-group-lg .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0 8px 8px 0 !important;
    }
    .card {
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 12px;
        overflow: hidden;
    }
    .chat-header {
        height: 72px;
    }
    .chat-footer {
        height: 85px;
    }
    .placeholder {
        background-color: #dee2e6;
    }
</style>
@endsection

