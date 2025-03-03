@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Deleted Orders</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Deleted At</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->invoice_no }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->order_date->format('M d, Y') }}</td>
                                <td>₱{{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->deleted_at->format('M d, Y H:i') }}</td>
                                <td>{{ $order->deletion_reason }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No deleted orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 