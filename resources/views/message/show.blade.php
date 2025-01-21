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
                    <!-- Chat Window -->
                    <div class="col-12 d-flex flex-column" style="height: 100%; overflow: hidden;">
                        <!-- Chat Header -->
                        <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($receiver->photo)
                                        <img src="{{ asset('storage/' . $receiver->photo) }}" alt="{{ $receiver->name }}" class="rounded-circle shadow-sm" width="48" height="48" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/img/default-avatar.png') }}" alt="No Profile" class="rounded-circle shadow-sm" width="48" height="48">
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">{{ $receiver->name }}</h5>
                                    <p class="mb-0 text-muted">{{ $receiver->phone ?? 'No Phone Number' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="chat-body flex-grow-1 p-4" style="background-color: #f8f9fa; overflow-y: auto;">
                            <div class="chat-messages">
                                @foreach($messages as $message)
                                    <div class="chat-bubble mb-3 {{ $message->user->id === auth()->id() ? 'chat-bubble-me ms-auto' : '' }}" 
                                         style="max-width: 80%; width: fit-content; {{ $message->user->id === auth()->id() ? 'background-color: #206bc4; color: white;' : 'background-color: #fff;' }}">
                                        <div class="chat-bubble-body">
                                            {{ $message->message }}
                                        </div>
                                        <div class="chat-bubble-footer mt-2">
                                            <small class="{{ $message->user->id === auth()->id() ? 'text-white-50' : 'text-muted' }}">
                                                {{ $message->created_at->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="chat-footer bg-white border-top p-3">
                            <form method="POST" action="{{ route('messages.send', $conversation->id) }}" class="m-0">
                                @csrf
                                <div class="input-group input-group-lg">
                                    <input type="text" name="message" class="form-control border-0" placeholder="Type your message..." style="font-size: 1.2rem;" required>
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    </button>
                                </div>
                            </form>
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
        // Scroll to bottom of chat messages
        const chatBody = document.querySelector('.chat-body');
        chatBody.scrollTop = chatBody.scrollHeight;
    });
</script>
@endpush

<style>
    .page-wrapper {
        display: flex;
        flex-direction: column;
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
    .chat-bubble {
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .chat-bubble-me {
        border-bottom-right-radius: 0.25rem;
    }
    .chat-bubble:not(.chat-bubble-me) {
        border-bottom-left-radius: 0.25rem;
    }
    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>
@endsection
