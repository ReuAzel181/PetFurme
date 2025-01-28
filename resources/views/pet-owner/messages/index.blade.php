@extends('layouts.mobile-app')

@section('content')
<div class="flex flex-col h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-3 flex items-center">
            <a href="{{ route('pet-owner.dashboard') }}" class="text-gray-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-lg font-semibold">Contact Clinic</h1>
        </div>
    </div>

    <!-- Clinic Contact -->
    <div class="flex-1 overflow-y-auto">
        <a href="{{ route('pet-owner.messages.show') }}" 
           class="block bg-white hover:bg-gray-50 transition-colors duration-200">
            <div class="flex items-center px-4 py-3 border-b">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/defaults/clinic-logo.png') }}" 
                         alt="Clinic Logo" 
                         class="w-12 h-12 rounded-full object-cover">
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-900 truncate">
                            VetCare Clinic
                            <span class="text-xs text-gray-500 ml-1">
                                (Support)
                            </span>
                        </h3>
                        @if($clinicContact->lastMessage)
                            <span class="text-xs text-gray-500">
                                {{ $clinicContact->lastMessage->created_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-sm text-gray-500 truncate">
                            {{ $clinicContact->lastMessage ? 
                                Str::limit($clinicContact->lastMessage->message, 50) : 
                                'Start a conversation with our clinic staff' }}
                        </p>
                        @if($clinicContact->unreadCount > 0)
                            <span class="ml-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $clinicContact->unreadCount }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection 