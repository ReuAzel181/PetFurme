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
                    <h4 class="text-center py-3">Pet Owners</h4>
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

                <!-- Placeholder for Chat Window -->
                <div class="col-md-8 d-flex align-items-center justify-content-center" style="height: calc(100vh - 14rem); background-color: #f9f9f9;">
                    <h5 class="text-muted">Select a chat to start messaging</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
