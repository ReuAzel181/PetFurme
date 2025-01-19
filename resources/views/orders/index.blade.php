@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="container-xl">
                <div class="row">
                    <div class="col">
                        @include('partials._page_header', [
                            'title' => __('Orders Management'),
                            'section' => 'OVERVIEW'
                        ])
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <h3 class="mb-1">Success</h3>
                <p>{{ session('success') }}</p>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="row row-deck row-cards">
            <!-- Order Statistics Cards -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Orders</div>
                        </div>
                        <div class="h1 mb-3">{{ $orders->count() }}</div>
                        <div class="d-flex mb-2">
                            <div>Total value: €{{ number_format($orders->sum('total'), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Pending Orders</div>
                        </div>
                        <div class="h1 mb-3">{{ $orders->where('order_status', \App\Enums\OrderStatus::PENDING)->count() }}</div>
                        <div class="d-flex mb-2">
                            <div>Awaiting completion</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Completed Orders</div>
                        </div>
                        <div class="h1 mb-3">{{ $orders->where('order_status', \App\Enums\OrderStatus::COMPLETE)->count() }}</div>
                        <div class="d-flex mb-2">
                            <div>Successfully delivered</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Due Orders</div>
                        </div>
                        <div class="h1 mb-3">{{ $orders->where('due', '>', 0)->count() }}</div>
                        <div class="d-flex mb-2">
                            <div>Pending payments: €{{ number_format($orders->sum('due'), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table Card -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ __('Orders List') }}</h3>
                        </div>

                        <div class="card-actions">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-outline-primary filter-btn active" data-filter="all">All</button>
                                <button type="button" class="btn btn-outline-success filter-btn" data-filter="complete">Complete</button>
                                <button type="button" class="btn btn-outline-warning filter-btn" data-filter="pending">Pending</button>
                                <button type="button" class="btn btn-outline-danger filter-btn" data-filter="due">Due</button>
                            </div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                {{ __('Create Order') }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">{{ __('No.') }}</th>
                                    <th scope="col" class="text-center">{{ __('Invoice No.') }}</th>
                                    <th scope="col" class="text-center">{{ __('Customer') }}</th>
                                    <th scope="col" class="text-center">{{ __('Date') }}</th>
                                    <th scope="col" class="text-center">{{ __('Payment') }}</th>
                                    <th scope="col" class="text-center">{{ __('Total') }}</th>
                                    <th scope="col" class="text-center">{{ __('Due') }}</th>
                                    <th scope="col" class="text-center">{{ __('Status') }}</th>
                                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $order->invoice_no }}</td>
                                        <td class="text-center">{{ $order->customer->name }}</td>
                                        <td class="text-center">{{ $order->order_date->format('d-m-Y') }}</td>
                                        <td class="text-center">{{ $order->payment_type }}</td>
                                        <td class="text-center">€{{ number_format($order->total, 2) }}</td>
                                        <td class="text-center">€{{ number_format($order->due, 2) }}</td>
                                        <td class="text-center status-cell">
                                            <x-status dot
                                                color="{{ $order->order_status === \App\Enums\OrderStatus::COMPLETE ? 'green' : ($order->due > 0 ? 'red' : 'orange') }}"
                                                class="text-uppercase">
                                                {{ $order->order_status }}
                                            </x-status>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('orders.show', $order->uuid) }}" class="btn btn-icon btn-outline-success" title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('order.downloadInvoice', $order) }}" class="btn btn-icon btn-outline-warning" title="Download Invoice">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                </a>
                                                @if($order->order_status === \App\Enums\OrderStatus::PENDING)
                                                    <form action="{{ route('orders.update', $order->uuid) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-icon btn-outline-success" onclick="return confirm('Are you sure you want to complete this order?')" title="Complete Order">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M5 12l5 5l10 -10"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const orderRows = document.querySelectorAll('tbody tr');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.dataset.filter;

                orderRows.forEach(row => {
                    const status = row.querySelector('.status-cell').textContent.trim().toLowerCase();
                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
