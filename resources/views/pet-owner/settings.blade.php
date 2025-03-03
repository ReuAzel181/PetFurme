@extends('layouts.mobile-app')

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('pet-owner.dashboard') }}" class="text-gray-600 mr-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-800">Settings</h1>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Notifications Settings -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Notifications</h2>
            
            <form action="{{ route('pet-owner.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                
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

                <div class="flex items-center justify-between">
                    <div>
                        <label class="font-medium text-gray-700">SMS Notifications</label>
                        <p class="text-sm text-gray-500">Receive text messages</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="sms_notifications" class="sr-only peer"
                               {{ auth()->user()->settings?->sms_notifications ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                  peer-focus:ring-blue-300 rounded-full peer 
                                  peer-checked:after:translate-x-full peer-checked:after:border-white 
                                  after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                  after:bg-white after:border-gray-300 after:border after:rounded-full 
                                  after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium 
                                   hover:bg-blue-700 focus:outline-none focus:ring-2 
                                   focus:ring-blue-500 focus:ring-offset-2">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- App Settings -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">App Settings</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="font-medium text-gray-700">Language</label>
                        <p class="text-sm text-gray-500">Choose your preferred language</p>
                    </div>
                    <select name="language" class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="en">English</option>
                        <option value="es">Español</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="font-medium text-gray-700">Theme</label>
                        <p class="text-sm text-gray-500">Choose light or dark mode</p>
                    </div>
                    <select name="theme" class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-red-600 mb-4">Danger Zone</h2>
            
            <div class="space-y-4">
                <button type="button" 
                        class="w-full border border-red-600 text-red-600 px-4 py-2 rounded-lg 
                               font-medium hover:bg-red-50 focus:outline-none focus:ring-2 
                               focus:ring-red-500 focus:ring-offset-2">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>
@endsection 