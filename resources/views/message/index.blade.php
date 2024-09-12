@extends('layouts.tabler')

@section('content')
    <div class="page">
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Your Conversations</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($conversations as $conversation)
                                <li class="list-group-item">
                                    <a href="{{ route('messages.show', $conversation->id) }}">
                                        Conversation #{{ $conversation->id }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">Start New Conversation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
