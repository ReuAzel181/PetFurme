@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('orders.index') }}" class="btn btn-icon btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l14 0"/>
                            <path d="M5 12l6 6"/>
                            <path d="M5 12l6 -6"/>
                        </svg>
                    </a>
                    <h2 class="page-title mb-0">Archived Orders</h2>
                </div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-group">
                    <a href="{{ route('orders.archived') }}" 
                       class="btn {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"/>
                            <path d="M10 12l4 0"/>
                        </svg>
                        All
                    </a>
                    <a href="{{ route('orders.archived', ['filter' => 'completed']) }}" 
                       class="btn {{ request('filter') === 'completed' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10"/>
                        </svg>
                        Completed
                    </a>
                    <a href="{{ route('orders.archived', ['filter' => 'cancelled']) }}" 
                       class="btn {{ request('filter') === 'cancelled' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12"/>
                            <path d="M6 6l12 12"/>
                        </svg>
                        Cancelled
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Archive History</h3>
            </div>
            <div class="card-body border-bottom py-3">
                <div class="d-flex">
                    <div class="text-muted">
                        Show
                        <div class="mx-2 d-inline-block">
                            <select class="form-select form-select-sm" aria-label="Items per page">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        entries
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total Products</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Archived Date</th>
                            <th class="w-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archivedOrders as $order)
                            <tr>
                                <td><span class="text-muted">{{ $loop->iteration }}</span></td>
                                <td>
                                    <span class="text-blue">{{ $order->invoice_no }}</span>
                                </td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->total_products }}</td>
                                <td>₱{{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge text-white bg-{{ $order->archive_reason === 'completed' ? 'success' : 'danger' }}">
                                        {{ ucfirst($order->archive_reason) }}
                                    </span>
                                </td>
                                <td>{{ $order->archived_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-icon btn-outline-primary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewModal{{ $order->id }}"
                                            title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                                                <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"/>
                                                <path d="M10 12l4 0"/>
                                            </svg>
                                        </div>
                                        <p class="empty-title">No archived orders found</p>
                                        <p class="empty-subtitle text-secondary">
                                            Completed and cancelled orders will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($archivedOrders->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <p class="m-0 text-muted">
                        Showing <span>{{ $archivedOrders->firstItem() }}</span> to <span>{{ $archivedOrders->lastItem() }}</span> of <span>{{ $archivedOrders->total() }}</span> entries
                    </p>
                    {{ $archivedOrders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modals --}}
@foreach($archivedOrders as $order)
    <div class="modal modal-blur fade" id="viewModal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details #{{ $order->invoice_no }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4 class="text-muted mb-3">Order Information</h4>
                            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Order Date:</strong> {{ Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</p>
                            <p><strong>Archive Date:</strong> {{ $order->archived_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge text-white bg-{{ $order->archive_reason === 'completed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->archive_reason) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-muted mb-3">Order Summary</h4>
                            <p><strong>Subtotal:</strong> ₱{{ number_format($order->sub_total, 2) }}</p>
                            <p><strong>VAT (12%):</strong> ₱{{ number_format($order->vat, 2) }}</p>
                            <p><strong>Total Amount:</strong> ₱{{ number_format($order->total, 2) }}</p>
                            @if($order->note)
                                <p><strong>Note:</strong> {{ $order->note }}</p>
                            @endif
                        </div>
                    </div>

                    <h4 class="text-muted mb-3">Order Items</h4>
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->archivedDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product_name }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">₱{{ number_format($detail->unit_price, 2) }}</td>
                                        <td class="text-end">₱{{ number_format($detail->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>₱{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection 