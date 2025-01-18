@extends('layouts.tabler')

@section('content')
    <div class="page">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col">
                        @include('partials._page_header', [
                            'title' => __('Notifications'),
                            'section' => 'OVERVIEW'
                        ])
                    </div>
                    <div class="col-auto ms-auto">
                        <div class="btn-list">
                            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    {{ __('Mark All as Read') }}
                                </button>
                            </form>
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                </svg>
                                {{ __('Refresh') }}
                            </a>
                        </div>
                    </div>
                </div>
                @include('partials._breadcrumbs')
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Low Stock Alerts') }}</h3>
                        <span class="badge bg-red ms-2">{{ $notifications->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($notifications->isEmpty())
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <p class="empty-title">{{ __('All Good!') }}</p>
                                <p class="empty-subtitle text-muted">{{ __('No products need attention.') }}</p>
                            </div>
                        @else
                            <div class="list-group">
                                @foreach($notifications as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1">{{ $product->name }}</h3>
                                            <p class="mb-1">{{ __('Quantity: ') }} {{ $product->quantity }} / {{ __('Alert Level: ') }} {{ $product->quantity_alert }}</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge @if($product->quantity <= 5) bg-danger @else bg-warning @endif rounded-pill">
                                                @if($product->quantity <= 5)
                                                    {{ __('Very Low Stock') }}
                                                @else
                                                    {{ __('Stock Alert') }}
                                                @endif
                                            </span>
                                            <a href="{{ route('products.edit', ['product' => $product->uuid]) }}" class="btn btn-sm btn-outline-primary">
                                                {{ __('Update Stock') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- New Expiration Alerts Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Expiration Alerts') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($expiringProducts->isEmpty())
                            <p>{{ __('No products are near expiration.') }}</p>
                        @else
                            <div class="list-group">
                                @foreach($expiringProducts as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1">{{ $product->name }}</h3>
                                            <p class="mb-1">
                                                {{ __('Expires: ') }} {{ $product->expiry_date->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $product->expiry_date->diffForHumans() }}
                                                </small>
                                            </p>
                                        </div>
                                        <span class="badge 
                                            @if($product->expiry_date->isPast()) 
                                                bg-danger
                                            @elseif($product->expiry_date->diffInDays(now()) <= 30) 
                                                bg-warning
                                            @else 
                                                bg-info
                                            @endif 
                                            rounded-pill">
                                            @if($product->expiry_date->isPast())
                                                {{ __('Expired') }}
                                            @elseif($product->expiry_date->diffInDays(now()) <= 30)
                                                {{ __('Expires Soon') }}
                                            @else
                                                {{ __('Upcoming Expiration') }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS: Enhanced styling for warning alert -->
    @push('styles')
    <style>

        /* Badge color overrides */
        .badge {
            font-size: 2.00rem; /* Larger font size for better readability */
            padding: 0.75rem 1rem; /* Moderate padding for the badge */
            border-radius: 30px; /* Slightly rounded pill shape */
            color: white !important; /* White text color */
        }

        /* Adjust colors for each alert type */
        .badge.bg-danger {
            background-color: #d9534f !important; /* More formal red */
        }

        .badge.bg-warning {
            background-color: #f39c12 !important; /* Orange for alert */
        }

        .badge.bg-success {
            background-color: #28a745 !important; /* Green for sufficient stock */
        }

        .badge.bg-danger:hover {
            background-color: #c9302c !important; /* Slightly darker red */
        }

        .badge.bg-warning:hover {
            background-color: #e67e22 !important; /* Slightly darker orange */
        }

        .badge.bg-success:hover {
            background-color: #218838 !important; /* Darker green for hover */
        }

        /* Additional styles for expiration badges */
        .badge.bg-info {
            background-color: #17a2b8 !important;
        }

        .badge.bg-info:hover {
            background-color: #138496 !important;
        }

        /* Add some spacing between list items */
        .list-group-item {
            margin-bottom: 0.5rem;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* Improve text readability */
        .text-muted {
            color: #6c757d !important;
        }
    </style>
    @endpush
@endsection
