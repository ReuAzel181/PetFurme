@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l5 5l10 -10"/>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <h4 class="alert-title mb-1">{{ session('success') }}</h4>
                            @if(session('saleDetails'))
                                <div class="text-muted">
                                    <strong>Amount Received:</strong> ₱{{ session('saleDetails.received') }}<br>
                                    <strong>Total Amount:</strong> ₱{{ session('saleDetails.total') }}<br>
                                    <strong>Change:</strong> ₱{{ session('saleDetails.change') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="12" r="9"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                        </div>
                        <div class="ms-2">{{ session('error') }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">{{ __('Orders') }}</h3>
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
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Pet Owner</th>
                                <th>Date & Time</th>
                                <th>Notes</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="cursor-pointer" 
                                    data-order-row 
                                    data-order-id="{{ $order->id }}"
                                    data-is-paid="{{ $order->is_paid ? '1' : '0' }}"
                                    onclick="handleRowClick(event, '{{ $order->uuid }}', {{ $order->id }})">
                                    <td>
                                        <span class="text-blue fw-bold">{{ $order->invoice_no }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs me-2 rounded-circle">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </span>
                                            {{ $order->user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $order->order_date->format('M d, Y g:i A') }}</td>
                                    <td class="text-muted">{{ Str::limit($order->note, 30) ?? 'None' }}</td>
                                    <td class="text-end fw-bold">₱{{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">
                                        @if($order->order_status === 'completed')
                                            <span class="badge bg-success-lt">Completed</span>
                                        @elseif($order->order_status === 'cancelled')
                                            <span class="badge bg-danger-lt">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning-lt">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->uuid) }}" 
                                           class="btn btn-icon btn-ghost-primary"
                                           onclick="event.stopPropagation()">
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
                                    <td colspan="7">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                    <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                    <path d="M17 17h-11v-14h-2"></path>
                                                    <path d="M6 5l8 .571m5.43 4.43l-.429 3h-13"></path>
                                                    <path d="M17 3l4 4"></path>
                                                    <path d="M21 3l-4 4"></path>
                                                </svg>
                                            </div>
                                            <p class="empty-title">No orders found</p>
                                            <p class="empty-subtitle text-muted">Try creating a new order using the button above.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($orders->hasPages())
                    <div class="card-footer pb-0">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    @foreach($orders as $order)
        <div class="modal fade" id="paymentModal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Process Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orders.mark-as-paid', $order->uuid) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body p-3">
                            <div class="mb-3">
                                <div class="alert alert-info mb-3">
                                    <div class="d-flex">
                                        <div>
                                            <h4 class="alert-title mb-1">Order #{{ $order->invoice_no }}</h4>
                                            <div class="text-secondary">{{ $order->user->name }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-label fw-bold">Total Amount Due</div>
                                <div class="display-6 mb-3">₱{{ number_format($order->total, 2) }}</div>
                                
                                <label class="form-label required">Amount Received</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" 
                                           class="form-control form-control-lg" 
                                           name="amount_received" 
                                           step="0.01" 
                                           min="{{ $order->total }}"
                                           onchange="calculateChange(this.value, {{ $order->total }}, {{ $order->id }})"
                                           required>
                                </div>
                                
                                <label class="form-label">Change</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="change{{ $order->id }}" 
                                       readonly>
                                
                                <label class="form-label mt-3">Payment Note</label>
                                <textarea class="form-control" 
                                          name="payment_note" 
                                          rows="2" 
                                          placeholder="Optional payment notes..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" 
                                    class="btn btn-primary" 
                                    id="submitPayment{{ $order->id }}" 
                                    disabled>
                                Process Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@push('page-scripts')
<style>
/* Update modal styles */
.modal {
    background: rgba(0, 0, 0, 0.3);
}

.modal-backdrop {
    display: none !important;
}

.modal-content {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: none;
}

.modal-sm {
    max-width: 400px;
}

.form-control-lg {
    height: 48px;
    font-size: 1.1rem;
}

.display-6 {
    font-size: 1.75rem;
    font-weight: 600;
    line-height: 1.2;
}

.cursor-pointer {
    cursor: pointer;
}

.cursor-pointer:hover {
    background-color: rgba(32, 107, 196, 0.03);
}

.table td, .table th {
    padding: 0.75rem;
}

.empty {
    padding: 2rem 0;
}

.empty-icon {
    margin-bottom: 1rem;
}

.empty-icon svg {
    width: 48px;
    height: 48px;
    stroke: #929dab;
}

.empty-title {
    font-size: 1.25rem;
    line-height: 1.4;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    font-size: 0.875rem;
    line-height: 1.4285714;
    color: #929dab;
}

.avatar {
    --tblr-avatar-size: 1.75rem;
    --tblr-avatar-bg: #929dab;
    position: relative;
    width: var(--tblr-avatar-size);
    height: var(--tblr-avatar-size);
    font-size: calc(var(--tblr-avatar-size) * 0.4);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    background: var(--tblr-avatar-bg);
    border-radius: 50%;
}

.avatar.avatar-md {
    --tblr-avatar-size: 3rem;
}

.list-group-item {
    padding: 1rem;
    border-color: rgba(98, 105, 118, 0.16);
}

.card-body {
    padding: 1.5rem;
}

.modal-body {
    padding: 0;
}

.modal-body .card {
    margin: 0;
    border: none;
}

.modal-body .card:last-child {
    margin-bottom: 0;
}

.badge {
    padding: 0.5em 1em;
}

/* Remove extra padding */
.card-footer {
    padding: 0.5rem 1rem;
}
</style>

<script>
function calculateChange(amountReceived, total, orderId) {
    const change = parseFloat(amountReceived) - parseFloat(total);
    const changeInput = document.getElementById(`change${orderId}`);
    const submitBtn = document.getElementById(`submitPayment${orderId}`);
    
    if (change >= 0) {
        changeInput.value = '₱' + change.toFixed(2);
        changeInput.classList.remove('text-danger');
        changeInput.classList.add('text-success');
        submitBtn.disabled = false;
    } else {
        changeInput.value = 'Insufficient amount';
        changeInput.classList.remove('text-success');
        changeInput.classList.add('text-danger');
        submitBtn.disabled = true;
    }
}

function handleRowClick(event, uuid, orderId) {
    // If clicking the eye icon or its parent button, don't do anything (it has its own link)
    if (event.target.closest('.btn-ghost-primary')) {
        return;
    }
    
    // For unpaid orders, show payment modal
    const row = event.currentTarget;
    if (row.dataset.isPaid !== '1') {
        const paymentModal = new bootstrap.Modal(document.getElementById(`paymentModal${orderId}`));
        paymentModal.show();
        
        // Remove any extra backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.remove();
        });
    } else {
        // For paid orders, navigate to order details
        window.location.href = `/orders/${uuid}`;
    }
}

// Add this to handle form submission
document.querySelectorAll('form[action*="mark-as-paid"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            Processing...
        `;
    });
});

// If there's a success message, refresh the page after 3 seconds
@if(session('success'))
    setTimeout(() => {
        window.location.reload();
    }, 3000);
@endif
</script>
@endpush
@endsection
