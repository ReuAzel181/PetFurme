@extends('layouts.mobile-app')

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('pet-owner.dashboard') }}" class="text-gray-600 mr-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-800">Profile Setup</h1>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Complete your profile for full access.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('pet-owner.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Photo -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <img src="{{ auth()->user()->profile_photo ?? asset('assets/img2/default-avatar.png') }}" 
                         alt="Profile" 
                         class="h-24 w-24 rounded-full object-cover border-4 border-white shadow">
                    <button type="button" 
                            class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="space-y-4">
                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="tel" 
                               name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}"
                               class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <textarea name="address" 
                                  rows="3"
                                  class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  required>{{ old('address', auth()->user()->address) }}</textarea>
                    </div>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emergency Contact Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Emergency Info</h3>
                    
                    <!-- Emergency Contact Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="emergency_contact_name" 
                                   value="{{ old('emergency_contact_name', auth()->user()->emergency_contact_name) }}"
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" 
                                   name="emergency_contact_phone" 
                                   value="{{ old('emergency_contact_phone', auth()->user()->emergency_contact_phone) }}"
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>
                        @error('emergency_contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Complete Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 