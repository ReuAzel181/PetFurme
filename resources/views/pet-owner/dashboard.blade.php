@extends('layouts.mobile-app')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Profile Setup Alert -->
    @if(!auth()->user()->profile_completed)
    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl p-4 shadow-sm mb-8 border-l-4 border-yellow-400 transform hover:scale-102 transition-transform duration-200">
        <div class="flex items-start">
            <div class="flex-shrink-0 bg-yellow-200 rounded-full p-2">
                <i class="fas fa-user-edit text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-sm font-semibold text-gray-800">Complete Your Profile</h3>
                <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                    Please complete your profile to better serve you and your pets.
                </p>
                <div class="mt-4">
                    <a href="{{ route('pet-owner.profile.setup') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-yellow-700 bg-yellow-200 hover:bg-yellow-300 transition-colors duration-200">
                        Complete Profile <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="text-center mb-8">
        <div class="relative inline-block">
            @php
                $defaultAvatarPath = asset('storage/user_photos/no-avatar.jpg');
                $avatarUrl = auth()->user()->photo ? 
                    asset('storage/' . auth()->user()->photo) : 
                    $defaultAvatarPath;
            @endphp
            
            <img src="{{ $avatarUrl }}" 
                 alt="{{ auth()->user()->name }}" 
                 class="w-24 h-24 mx-auto mb-4 rounded-full shadow-lg object-cover"
                 data-fallback="{{ $defaultAvatarPath }}"
                 onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
            
            <div class="absolute -bottom-2 -right-2 bg-green-500 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center">
                <i class="fas fa-check text-white text-xs"></i>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500 mt-2">Let's take care of your pets today</p>
    </div>

    <!-- Stats Grid -->
    <div class="mb-8">
        <!-- My Pets Card -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center text-indigo-600">
                    <div class="bg-indigo-100 rounded-full p-2 mr-3">
                        <i class="fas fa-paw text-xl"></i>
                    </div>
                    <span class="font-semibold">My Pets</span>
                </div>
            </div>

            <div class="flex space-x-4 overflow-x-auto pb-2">
                @foreach($pets as $pet)
                    <div class="flex-shrink-0">
                        <div class="relative w-16 h-16">
                            <img src="{{ $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/pet_photos/no-image.jpg') }}"
                                 alt="{{ $pet->name }}"
                                 class="w-full h-full rounded-full object-cover border-2 border-indigo-100"
                                 data-fallback="{{ asset('storage/pet_photos/no-image.jpg') }}"
                                 onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
                            <p class="text-xs text-center mt-1 text-gray-600 font-medium">{{ $pet->name }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Add New Pet Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('pet-owner.pets.create') }}" 
                       class="w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center border-2 border-dashed border-indigo-200 hover:bg-indigo-100 transition-colors duration-200">
                        <i class="fas fa-plus text-indigo-400 text-xl"></i>
                    </a>
                    <p class="text-xs text-center mt-1 text-indigo-600 font-medium">Add Pet</p>
                </div>
            </div>
        </div>

        <!-- Featured Products Card -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center text-blue-600">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                    <span class="font-semibold">Featured Products</span>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center">
                    View All 
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>

            @if($products->isNotEmpty())
                <div class="space-y-4">
                    @foreach($products as $product)
                        <div class="flex items-center space-x-4 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <!-- Product Image -->
                            <div class="relative w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover rounded-lg"
                                     data-fallback="{{ asset('storage/products/no-image.jpg') }}"
                                     onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                @if(isset($product->description))
                                <div class="text-sm text-gray-500 truncate">
                                    {{ Str::limit($product->description, 50) }}
                                </div>
                                @endif
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-indigo-600 font-semibold">
                                        ₱{{ number_format($product->price, 2) }}
                                    </span>
                                    @if($product->stock > 0)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                            In Stock ({{ $product->stock }})
                                        </span>
                                    @else
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-box text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm">No products available</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Visits Card -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center text-purple-600 mb-3">
                <div class="bg-purple-100 rounded-full p-2 mr-3">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
                <span class="font-semibold">Visits</span>
            </div>
            <div class="text-3xl font-bold text-gray-800 mb-1">
                {{ $appointments->where('appointment_date', '>=', now())->count() }}
            </div>
            <div class="text-sm text-gray-500 mb-4">Scheduled Visits</div>
            <a href="{{ route('pet-owner.appointments.create') }}" 
               class="text-purple-600 text-sm flex items-center hover:text-purple-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Book Visit
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="space-y-3">
            <a href="{{ route('pet-owner.appointments.create') }}" 
               class="flex items-center bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <i class="fas fa-calendar-plus text-blue-600 text-lg"></i>
                </div>
                <span class="text-gray-700 font-medium">Book Appointment</span>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>
            
            <a href="{{ route('pet-owner.pets.create') }}" 
               class="flex items-center bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <i class="fas fa-plus text-green-600 text-lg"></i>
                </div>
                <span class="text-gray-700 font-medium">Add New Pet</span>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>
            
            <a href="{{ route('messages.index') }}" 
               class="flex items-center bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <i class="fas fa-comments text-purple-600 text-lg"></i>
                </div>
                <div class="flex-1">
                    <span class="text-gray-700 font-medium">Chat with Vet</span>
                    @if($unreadMessages > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $unreadMessages }}
                        </span>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">
                        @if($latestMessage)
                            {{ Str::limit($latestMessage->content, 30) }}
                        @else
                            Start a conversation with our vets
                        @endif
                    </p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>
            
            <a href="tel:+1234567890" 
               class="flex items-center bg-gradient-to-r from-red-50 to-red-100 p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                <div class="bg-red-200 rounded-full p-3 mr-4">
                    <i class="fas fa-phone text-red-600 text-lg"></i>
                </div>
                <div class="flex-1">
                    <span class="text-red-700 font-medium">Emergency Call</span>
                    <p class="text-red-500 text-sm mt-1">24/7 Support Available</p>
                </div>
                <i class="fas fa-chevron-right text-red-400 ml-auto"></i>
            </a>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Appointments</h2>
        @if($appointments->isEmpty())
            <div class="bg-white rounded-xl p-8 text-center shadow-sm">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-day text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 mb-6">No appointments scheduled yet</p>
                <a href="{{ route('pet-owner.appointments.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>
                    Book Your First Appointment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 