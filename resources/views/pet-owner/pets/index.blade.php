@extends('layouts.mobile-app')

@section('content')
<div class="px-4 py-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-medium text-gray-900">Your Pets</h1>
    </div>

    <!-- Pet Grid -->
    <div class="grid grid-cols-4 gap-4">
        @foreach($pets as $pet)
        <a href="{{ route('pet-owner.pets.show', $pet) }}" class="flex flex-col items-center">
            <div class="pet-avatar-circle">
                @if($pet->photo_path)
                    <img src="{{ Storage::url($pet->photo_path) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-paw text-lg text-gray-400"></i>
                @endif
            </div>
            <span class="pet-name">{{ $pet->name }}</span>
        </a>
        @endforeach

        <!-- Add Pet Button -->
        <a href="{{ route('pet-owner.pets.create') }}" class="flex flex-col items-center">
            <div class="add-pet-circle">
                <i class="fas fa-plus"></i>
            </div>
            <span class="pet-name">Add new</span>
        </a>
    </div>

    @if($pets->isEmpty() && !request()->routeIs('pet-owner.pets.create'))
    <div class="text-center mt-8">
        <div class="bg-gray-100 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-paw text-xl text-gray-400"></i>
        </div>
        <h3 class="text-gray-600 font-medium mb-2">No Pets Yet</h3>
        <p class="text-gray-500 text-sm mb-4">Add your first pet to get started</p>
        <a href="{{ route('pet-owner.pets.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Add Your First Pet
        </a>
    </div>
    @endif
</div>

@if(session('success'))
<div class="fixed bottom-20 inset-x-4">
    <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg">
        <p class="text-center">{{ session('success') }}</p>
    </div>
</div>
@endif

@push('styles')
<link href="{{ asset('css/pet-owner.css') }}" rel="stylesheet">
@endpush
@endsection 