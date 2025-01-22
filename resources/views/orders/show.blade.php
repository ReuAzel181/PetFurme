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
                            <form action="{{ route('orders.update', $order->uuid) }}" method="POST" class="me-2 d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    {{ __('Complete Order') }}
                                </button>
                            </form>

                            <form action="{{ route('orders.update', $order->uuid) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                    {{ __('Cancel Order') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label text-muted">{{ __('Order Date') }}</label>
                                <div class="form-control-plaintext font-weight-bold">
                                    {{ $order->order_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label text-muted">{{ __('Invoice No.') }}</label>
                                <div class="form-control-plaintext font-weight-bold">
                                    {{ $order->invoice_no }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label text-muted">{{ __('Pet Owner') }}</label>
                                <div class="form-control-plaintext font-weight-bold">
                                    {{ $order->user->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label text-muted">{{ __('Status') }}</label>
                                <div class="form-control-plaintext">
                                    @if($order->order_status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($order->order_status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th class="text-center" style="width: 15%">Photo</th>
                                    <th>Product Name</th>
                                    <th class="text-center">Product Code</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <span class="avatar avatar-lg rounded" style="background-image: url({{ $item->product->product_image ? asset('storage/' . $item->product->product_image) : asset('assets/img/products/default.webp') }})"></span>
                                        </td>
                                        <td>{{ $item->product->name }}</td>
                                        <td class="text-center">{{ $item->product->code }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">₱{{ number_format($item->unitcost, 2) }}</td>
                                        <td class="text-end">₱{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Sub Total:</td>
                                    <td class="text-end fw-bold">₱{{ number_format($order->sub_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">VAT:</td>
                                    <td class="text-end fw-bold">₱{{ number_format($order->vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold">₱{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label text-muted">{{ __('Order Note') }}</label>
                            <div class="form-control-plaintext">
                                {{ $order->note ?? 'None' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('page-scripts')
<style>
    .avatar.avatar-lg {
        width: 64px;
        height: 64px;
        background-size: cover;
        background-position: center;
    }
    
    .form-control-plaintext {
        font-size: 0.95rem;
    }
    
    .table tfoot {
        border-top: 2px solid #dee2e6;
    }
    
    .table tfoot td {
        padding: 0.75rem;
    }
</style>
@endpush
@endsection
