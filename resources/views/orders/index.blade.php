@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if (!$orders->isEmpty())
            <div class="container-xl">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Orders'),
                        'section' => 'OVERVIEW'
                    ])
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

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ __('All Orders') }}</h3>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                {{ __('Create Order') }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Pet Owner</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th class="w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><span class="text-blue">{{ $order->invoice_no }}</span></td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->order_date->format('M d, Y') }}</td>
                                        <td>₱{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @if(isset($order->is_paid) && $order->is_paid)
                                                <span class="badge bg-green-lt">Paid</span>
                                            @else
                                                <span class="badge bg-yellow-lt">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" 
                                               class="btn btn-icon btn-pill btn-ghost-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found.</td>
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
        @endif
    </div>

    <!-- Payment Modals -->
    @foreach($orders as $order)
        @if(!$order->is_paid)
        <div class="modal fade" id="paymentModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('orders.mark-as-paid', $order->uuid) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title">Process Payment - Order #{{ $order->invoice_no }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Total Amount</label>
                                <div class="form-control-plaintext fw-bold">₱{{ number_format($order->total, 2) }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Amount Received</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control" 
                                           name="amount_received" 
                                           id="amountReceived{{ $order->id }}" 
                                           onkeyup="calculateChange({{ $order->id }}, {{ $order->total }})"
                                           required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Change</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="change{{ $order->id }}" 
                                           readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" 
                                          name="note" 
                                          rows="2" 
                                          placeholder="Add any payment notes here..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitPayment{{ $order->id }}" disabled>
                                Process Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    @push('page-scripts')
    <style>
    /* Remove modal backdrop styles */
    .modal-backdrop {
        display: none !important; /* Hide the backdrop completely */
    }

    .modal {
        background: rgba(0, 0, 0, 0.5); /* Add background to modal itself */
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1045;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: 1.75rem auto;
        pointer-events: auto;
        max-width: 500px;
    }

    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 0.5rem;
        outline: 0;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Table styles */
    .table th {
        font-weight: 600;
        background: #f8fafc;
    }

    /* Badge styles */
    .badge {
        font-weight: 500;
    }
    .badge.cursor-pointer:hover {
        opacity: 0.8;
        cursor: pointer;
    }

    /* Button styles */
    .btn-ghost-primary {
        color: #206bc4;
        background: transparent;
    }
    .btn-ghost-primary:hover {
        background: rgba(32, 107, 196, 0.1);
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.modal');
        
        modals.forEach(modal => {
            // Initialize Bootstrap modal
            const bsModal = new bootstrap.Modal(modal, {
                backdrop: false, // Disable Bootstrap's backdrop
                keyboard: true
            });

            // Clean up when modal is hidden
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    bsModal.hide();
                }
            });
        });
    });

    function calculateChange(orderId, total) {
        const amountReceived = parseFloat(document.getElementById(`amountReceived${orderId}`).value) || 0;
        const change = amountReceived - total;
        const submitBtn = document.getElementById(`submitPayment${orderId}`);
        const changeInput = document.getElementById(`change${orderId}`);
        
        if (change >= 0) {
            changeInput.value = change.toFixed(2);
            changeInput.classList.remove('is-invalid');
            changeInput.classList.add('is-valid');
            submitBtn.disabled = false;
        } else {
            changeInput.value = 'Insufficient amount';
            changeInput.classList.remove('is-valid');
            changeInput.classList.add('is-invalid');
            submitBtn.disabled = true;
        }
    }
    </script>
    @endpush
@endsection
