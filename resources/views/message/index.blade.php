@extends('layouts.tabler')

@section('content')
<div class="page-wrapper" style="min-height: 100vh;">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                @include('partials._page_header', [
                    'title' => __('Messages'),
                    'section' => 'OVERVIEW'
                ])
            </div>
        </div>
    </div>

    <div class="page-body" style="flex: 1;">
        <div class="container-fluid p-4">
            <div class="card shadow-sm" style="height: calc(100vh - 11rem);">
                <div class="row g-0 h-100">
                    <!-- Message List -->
                    <div class="col-12 col-md-6 col-lg-4 bg-white border-end d-flex flex-column" style="height: 100%; overflow: hidden;">
                        <div class="p-3 border-bottom" style="background-color: #f8f9fa;">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control border shadow-none" id="messageSearch" placeholder="Search messages..." style="font-size: 1.2rem;">
                                <button class="btn btn-primary" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                </button>
                            </div>
                            <div id="searchFeedback" class="mt-2 text-muted d-none" style="font-size: 1.1rem;">
                                Searching messages from: <span id="searchUser"></span>
                            </div>
                        </div>
                        <div class="chat-users flex-grow-1">
                            @foreach ($users as $user)
                                <a href="{{ route('messages.chat', $user->id) }}" class="chat-user-item d-flex align-items-center text-decoration-none text-dark p-4 border-bottom hover-bg-light">
                                    <div class="me-3 position-relative">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm" width="64" height="64" style="object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/default-avatar.png') }}" alt="No Profile" class="rounded-circle shadow-sm" width="64" height="64">
                                        @endif
                                        @if($user->unread_count > 0)
                                            <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger shadow-sm" style="font-size: 1rem;">
                                                {{ $user->unread_count }}
                                            </span>
                                        @endif
                                    </div>    
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 text-truncate fw-bold" style="font-size: 1.35rem;">{{ $user->name }}</h5>
                                                @if($user->unread_count > 0)
                                                    <span class="badge bg-secondary rounded-pill ms-2 shadow-sm" style="font-size: 1rem;">{{ $user->unread_count }}</span>
                                                @endif
                                            </div>
                                            <small class="text-muted ms-2" style="font-size: 1.1rem;">
                                                @if($user->lastMessage)
                                                    {{ \Carbon\Carbon::parse($user->lastMessage->sent_at)->format('h:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                        <p class="text-muted mb-0 text-truncate" style="font-size: 1.15rem;">
                                            @if($user->lastMessage)
                                                {{ $user->lastMessage->message }}
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
                    <div class="col-md-6 col-lg-8 d-none d-md-flex flex-column" style="height: 100%; overflow: hidden;">
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

                        <!-- Chat Body -->
                        <div class="chat-body flex-grow-1 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages mb-4" width="120" height="120" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                </svg>
                                <h2 class="text-muted mb-3" style="font-size: 1.75rem;">Select a conversation</h2>
                                <p class="text-muted" style="font-size: 1.25rem;">Choose a contact from the left to start messaging</p>
                            </div>
                        </div>

                        <!-- Chat Footer -->
                        <div class="chat-footer bg-white border-top p-3">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control border-0" placeholder="Type your message..." disabled style="font-size: 1.2rem;">
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
