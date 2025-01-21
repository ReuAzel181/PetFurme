@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Ongoing Orders
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @foreach($orders as $order)
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order #{{ $order->invoice_no }}</h3>
                        <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
                    </div>
                    <div class="card-body">
                        <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
                        <p><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('orders.show', $order->uuid) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 