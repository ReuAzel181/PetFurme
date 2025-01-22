@extends('layouts.tabler')

@push('page-styles')
<style>
    /* Increase table row height */
    .table > tbody > tr > td {
        padding-top: 1.5rem;    /* Increased from 1rem */
        padding-bottom: 1.5rem;  /* Increased from 1rem */
        vertical-align: middle;  /* Center content vertically */
    }
    
    /* Make table header taller */
    .table > thead > tr > th {
        padding-top: 1.25rem;    /* Increased padding */
        padding-bottom: 1.25rem;
        vertical-align: middle;
        background-color: #f8fafc;  /* Light background for header */
        border-bottom: 2px solid #e9ecef;
    }
    
    /* Adjust status badge */
    .status-badge {
        padding: 0.75rem 1.25rem;  /* Larger padding */
        font-size: 0.9rem;        /* Slightly larger text */
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Make avatar larger */
    .avatar.customer-avatar {
        width: 3rem;          /* Increased from 2.5rem */
        height: 3rem;         /* Increased from 2.5rem */
        font-size: 1.2rem;    /* Increased from 1rem */
    }

    /* Make the dropdown button taller */
    .btn-outline-secondary.btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    /* Add some spacing to the card */
    .card {
        margin-bottom: 2rem;
    }

    /* Make the table more spacious */
    .table-responsive {
        padding: 0.5rem;
    }

    /* Adjust text sizes */
    .table td {
        font-size: 1rem;
    }

    /* Add hover effect to rows */
    .table > tbody > tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Make the card taller by setting a minimum height */
    .card-table-container {
        min-height: 800px;  /* Increased height */
    }

    /* Ensure the table fills the available space */
    .table-responsive {
        height: auto !important; /* Remove fixed height */
        overflow-x: auto;
        padding: 0;
    }

    /* Keep the header at the top */
    .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Keep the footer at the bottom */
    .card-footer {
        background-color: white;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Compact dropdown menu */
    .dropdown-menu-compact {
        min-width: 180px;  /* Reduce minimum width */
        padding: 0.25rem 0;
    }

    .dropdown-menu-compact .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dropdown-menu-compact .icon {
        width: 18px;
        height: 18px;
    }

    /* Card and table styles */
    .card-table-container {
        min-height: 800px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* Table styles */
    .sales-table {
        width: 100%;
        margin-bottom: 0;
    }

    .sales-table thead th {
        background: #f8fafc;
        padding: 1rem;
        font-weight: 600;
        color: #1e293b;
        border-bottom: 2px solid #e2e8f0;
    }

    .sales-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Status badge */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Actions dropdown */
    .actions-dropdown {
        position: relative;
        display: inline-block;
    }

    .actions-btn {
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #475569;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .actions-btn:hover {
        background: #f8fafc;
    }

    .actions-menu {
        min-width: 200px;
        padding: 0.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .actions-menu .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #475569;
        font-weight: 500;
    }

    .actions-menu .dropdown-item:hover {
        background: #f1f5f9;
    }
</style>
@endpush

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
                    <div class="col-auto ms-auto">
                        <div class="btn-list">
                            <a href="{{ route('sales.export') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                    <path d="M7 11l5 5l5 -5"></path>
                                    <path d="M12 4l0 12"></path>
                                </svg>
                                Export Report
                            </a>
                        </div>
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

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('sales.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" name="customer" value="{{ request('customer') }}" placeholder="Search customer...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="">All</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('sales.index') }}" class="btn btn-link">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card card-table-container">
            <div class="card-header border-bottom p-4">
                <h3 class="card-title m-0" style="font-size: 1.25rem; font-weight: 600;">Completed Orders</h3>
            </div>
            <div class="table-responsive">
                <table class="table sales-table">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Customer</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="fw-medium">{{ $sale->invoice_no }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                            {{ strtoupper(substr($sale->user->name, 0, 1)) }}
                                        </span>
                                        <span>{{ $sale->user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-center">{{ $sale->details->count() }}</td>
                                <td class="text-end fw-bold">₱{{ number_format($sale->total, 2) }}</td>
                                <td class="text-center">
                                    <span class="status-badge bg-{{ $sale->payment_status_color }} text-white">
                                        {{ $sale->payment_status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="actions-dropdown">
                                        <button type="button" class="actions-btn" data-bs-toggle="dropdown">
                                            Actions
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M6 9l6 6l6 -6" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu actions-menu dropdown-menu-end">
                                            <a href="{{ route('orders.show', $sale->uuid) }}" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                                View Details
                                            </a>
                                            @if(!$sale->is_paid)
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $sale->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                        <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                                                    </svg>
                                                    Record Payment
                                                </a>
                                                <a href="{{ route('orders.revert-status', $sale->uuid) }}" 
                                                   class="dropdown-item"
                                                   onclick="return confirm('Are you sure you want to revert this order to pending?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                                                    </svg>
                                                    Revert to Pending
                                                </a>
                                            @endif
                                            <a href="{{ route('orders.print-invoice', $sale->uuid) }}" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                </svg>
                                                Print Invoice
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No sales records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer border-top p-3">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
    // Initialize tooltips and dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        });
    });
</script>
@endpush
@endsection
