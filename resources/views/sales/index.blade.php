@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Sales History</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Summary Cards -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Today's Sales</div>
                        </div>
                        <div class="h1 mb-3">₱{{ number_format($todaySales, 2) }}</div>
                        <div class="d-flex mb-2">
                            <div>Orders: {{ $todayOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Weekly Sales</div>
                        </div>
                        <div class="h1 mb-3">₱{{ number_format($weeklySales, 2) }}</div>
                        <div class="d-flex mb-2">
                            <div>Orders: {{ $weeklyOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Monthly Sales</div>
                        </div>
                        <div class="h1 mb-3">₱{{ number_format($monthlySales, 2) }}</div>
                        <div class="d-flex mb-2">
                            <div>Orders: {{ $monthlyOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Sales</div>
                        </div>
                        <div class="h1 mb-3">₱{{ number_format($totalSales, 2) }}</div>
                        <div class="d-flex mb-2">
                            <div>Orders: {{ $totalOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Orders</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->invoice_no }}</td>
                                <td>{{ $sale->user->name }}</td>
                                <td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                <td>₱{{ number_format($sale->total, 2) }}</td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('orders.show', $sale->uuid) }}" class="btn btn-icon btn-ghost-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No sales records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
