@extends('layouts.tabler')

@section('content')
    <div class="page">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <h2 class="page-title">
                            {{ __('Product Alerts') }}
                        </h2>
                    </div>
                </div>
                @include('partials._breadcrumbs')
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Low Stock Alerts') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($notifications->isEmpty())
                            <p>{{ __('No products need attention.') }}</p>
                        @else
                            <div class="list-group">
                                @foreach($notifications as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1">{{ $product->name }}</h3>
                                            <p class="mb-1">{{ __('Quantity: ') }} {{ $product->quantity }} / {{ __('Alert Level: ') }} {{ $product->quantity_alert }}</p>
                                        </div>
                                        <span class="badge 
                                            @if($product->quantity <= 5) 
                                                bg-danger 
                                            @elseif($product->quantity <= $product->quantity_alert) 
                                                bg-warning 
                                            @else 
                                                bg-success 
                                            @endif 
                                            rounded-pill">
                                            @if($product->quantity <= 5)
                                                {{ __('Very Low Stock') }}
                                            @elseif($product->quantity <= $product->quantity_alert)
                                                {{ __('Stock Alert') }}
                                            @else
                                                {{ __('Sufficient Stock') }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-primary" href="{{ url()->previous() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            {{ __('Back') }}
                        </a>
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
    </style>
    @endpush
@endsection
