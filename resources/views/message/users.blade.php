@extends('layouts.tabler')

<!-- Eto yung design layout -->

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-4 bg-light border-end" style="height: 100vh; overflow-y: auto;">
            <h4 class="text-center py-3">Pet Owners</h4>
            <ul class="list-group list-group-flush">
                @foreach ($users as $user)
                    <a href="{{ route('messages.chat', $user->id) }}" class="list-group-item d-flex align-items-center text-decoration-none">
                        <div>
                            <strong>{{ $user->name }}</strong>
                            <br><small class="text-muted">{{ $user->phone ?? 'None' }}</small>
                        </div>
                    </a>
                @endforeach
            </ul>
        </div>

        <!-- Placeholder for Chat Window -->
        <div class="col-md-8 d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f9f9f9;">
            <h5 class="text-muted">Select a chat to start messaging</h5>
        </div>
    </div>
</div>
@endsection
