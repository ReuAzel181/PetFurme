@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">{{ __('Order Details') }}</h3>
                    </div>
                    <div class="card-actions">
                        <div class="btn-list">
                            @if(!$order->is_paid)
                                <form action="{{ route('orders.mark-as-paid', $order->uuid) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg>
                                        {{ __('Mark as Paid') }}
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('orders.print-invoice', $order->uuid) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                </svg>
                                {{ __('Print Invoice') }}
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                </svg>
                                {{ __('Back to Orders') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">{{ __('Order Date') }}</label>
                            <input type="text" class="form-control" value="{{ $order->order_date->format('d-m-Y') }}" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">{{ __('Invoice No.') }}</label>
                            <input type="text" class="form-control" value="{{ $order->invoice_no }}" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">{{ __('Pet Owner') }}</label>
                            <input type="text" class="form-control" value="{{ $order->user->name }}" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">{{ __('Payment Status') }}</label>
                            <div class="form-control-plaintext">
                                @if($order->is_paid)
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning">Pending Payment</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th class="text-center" style="width: 15%">Photo</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Product Code</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <div class="avatar avatar-lg" style="background-image: url({{ $item->product->product_image ? asset('storage/' . $item->product->product_image) : asset('assets/img/products/default.webp') }})"></div>
                                        </td>
                                        <td class="text-center">{{ $item->product->name }}</td>
                                        <td class="text-center">{{ $item->product->code }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">₱{{ number_format($item->unitcost, 2) }}</td>
                                        <td class="text-center">₱{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Sub Total</td>
                                    <td class="text-center">₱{{ number_format($order->sub_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">VAT</td>
                                    <td class="text-center">₱{{ number_format($order->vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Total</td>
                                    <td class="text-center">₱{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('page-scripts')
<style>
    .avatar.avatar-lg {
        width: 80px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 5px;
        margin: 0 auto;
    }
</style>
@endpush
@endsection
