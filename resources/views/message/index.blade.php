@extends('layouts.tabler')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Conversations</h1>
    <ul class="list-group">
        @foreach ($conversations as $conversation)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $conversation->user->name }}</strong>
                    <br><small>Last Message: {{ $conversation->last_message }}</small>
                </div>
                <a href="{{ route('messages.chat', $conversation->user->id) }}" class="btn btn-primary btn-sm">View</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
