@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Search Results for "{{ $query }}"
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @if($appointments->isEmpty() && $pets->isEmpty() && $products->isEmpty() && $users->isEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="mb-3">No results found</h3>
                            <p class="text-muted">Try adjusting your search terms or browse through categories</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Appointments Section -->
                @if($appointments->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Appointments</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($appointments as $appointment)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="{{ route('appointment.show', $appointment->id) }}" class="text-reset">{{ $appointment->title }}</a>
                                                <div class="text-muted">{{ $appointment->description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pets Section -->
                @if($pets->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Pets</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($pets as $pet)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="{{ route('pet.show', $pet->id) }}" class="text-reset">{{ $pet->name }}</a>
                                                <div class="text-muted">{{ $pet->breed }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Products Section -->
                @if($products->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Products</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($products as $product)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="{{ route('products.show', $product->id) }}" class="text-reset">{{ $product->name }}</a>
                                                <div class="text-muted">{{ $product->description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Users Section -->
                @if($users->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Users</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($users as $user)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="text-reset">{{ $user->name }}</span>
                                                <div class="text-muted">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Orders Section -->
                @if($orders->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Orders</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($orders as $order)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="{{ route('orders.show', $order->id) }}" class="text-reset">Order #{{ $order->order_no }}</a>
                                                <div class="text-muted">Total: {{ $order->total }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Customers Section -->
                @if($customers->isNotEmpty())
                    <div class="col-12 mb-3">
                        <h3 class="mb-3">Customers</h3>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                @foreach($customers as $customer)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="text-reset">{{ $customer->name }}</span>
                                                <div class="text-muted">{{ $customer->email }} | {{ $customer->phone }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection 