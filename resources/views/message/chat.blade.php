@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
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

    <div class="page-body">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Sidebar -->
                <div class="col-md-4 bg-light border-end" style="height: calc(100vh - 14rem); overflow-y: auto;">
                    <h4 class="text-center py-3">Chats</h4>
                    <ul class="list-group list-group-flush">
                        @foreach ($users as $user)
                            <a href="{{ route('messages.chat', $user->id) }}" class="list-group-item d-flex align-items-center text-decoration-none">
                                <div class="me-3">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="rounded-circle" width="60" height="60">
                                    @else
                                        <img src="{{ asset('assets/img/default-avatar.png') }}" alt="No Profile" class="rounded-circle" width="60" height="60">
                                    @endif
                                </div>    
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <br><small class="text-muted">{{ $user->phone ?? 'None' }}</small>
                                </div>
                            </a>
                        @endforeach
                    </ul>
                </div>

                <!-- Chat Window -->
                <div class="col-md-8 d-flex flex-column" style="height: calc(100vh - 14rem);">
                    <!-- Chat Header -->
                    <div class="chat-header bg-primary text-white p-3 d-flex align-items-center">
                        <h5 class="mb-0">Chat with {{ $receiver->name }}</h5>
                    </div>

                    <!-- Chat Body -->
                    <div class="chat-body flex-grow-1 p-3 d-flex flex-column justify-content-end" style="overflow-y: auto; background-color: #f9f9f9;">
                        <ul class="list-unstyled mb-0">
                            @foreach ($messages as $message)
                                <li class="mb-3">
                                    <div class="d-flex {{ $message->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                        <div class="rounded px-3 py-2 {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 60%;">
                                            <p class="mb-1">{{ $message->message }}</p>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($message->sent_at)->format('d M, Y h:i A') }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Chat Footer -->
                    <div class="chat-footer bg-light p-3">
                        <form action="{{ route('messages.send', $receiver->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
