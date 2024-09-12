@extends('layouts.tabler')

@section('content')
<div class="container">
    <h1>Conversation #{{ $conversation->id }}</h1>

    <div id="messages" style="border: 1px solid #ccc; padding: 10px; height: 400px; overflow-y: scroll;">
        @foreach($messages as $message)
            <p><strong>{{ $message->user->name }}:</strong> {{ $message->message }}</p>
        @endforeach
    </div>

    <form method="POST" action="{{ route('messages.send', $conversation->id) }}">
        @csrf
        <div class="input-group mt-3">
            <input type="text" name="message" class="form-control" placeholder="Type your message" required>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>
@endsection
