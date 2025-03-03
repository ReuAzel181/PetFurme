@extends('layouts.mobile-app')

@section('content')
<div class="container px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('pet-owner.dashboard') }}" class="text-gray-600 mr-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-800">Settings</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('pet-owner.settings.update') }}" method="POST">
            @csrf
            
            <!-- Notifications -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notifications</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-700">Push Notifications</label>
                            <p class="text-sm text-gray-500">Receive app notifications</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notifications_enabled" class="sr-only peer" 
                                   {{ auth()->user()->settings?->notifications_enabled ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                      peer-focus:ring-blue-300 rounded-full peer 
                                      peer-checked:after:translate-x-full peer-checked:after:border-white 
                                      after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                      after:bg-white after:border-gray-300 after:border after:rounded-full 
                                      after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-700">Email Notifications</label>
                            <p class="text-sm text-gray-500">Receive email updates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_notifications" class="sr-only peer"
                                   {{ auth()->user()->settings?->email_notifications ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                      peer-focus:ring-blue-300 rounded-full peer 
                                      peer-checked:after:translate-x-full peer-checked:after:border-white 
                                      after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                      after:bg-white after:border-gray-300 after:border after:rounded-full 
                                      after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Preferences</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Theme</label>
                        <select name="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                  focus:border-blue-500 focus:ring-blue-500">
                            <option value="light" {{ auth()->user()->settings?->theme === 'light' ? 'selected' : '' }}>Light</option>
                            <option value="dark" {{ auth()->user()->settings?->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Language</label>
                        <select name="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                     focus:border-blue-500 focus:ring-blue-500">
                            <option value="en" {{ auth()->user()->settings?->language === 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ auth()->user()->settings?->language === 'es' ? 'selected' : '' }}>Español</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 