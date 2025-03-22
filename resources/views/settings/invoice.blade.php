@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Invoice Records
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Patient Name</th>
                                <th>Services Total</th>
                                <th>Products Total</th>
                                <th>Discount</th>
                                <th>Grand Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chargeSlips as $slip)
                            <tr>
                                <td>{{ $slip->invoice_number }}</td>
                                <td>{{ $slip->patient_name }}</td>
                                <td>₱{{ number_format($slip->services_total, 2) }}</td>
                                <td>₱{{ number_format($slip->products_total, 2) }}</td>
                                <td>
                                    @if($slip->discount_type === 'percentage')
                                        {{ $slip->discount_amount }}%
                                    @else
                                        ₱{{ number_format($slip->discount_amount, 2) }}
                                    @endif
                                </td>
                                <td>₱{{ number_format($slip->grand_total, 2) }}</td>
                                <td>{{ $slip->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" onclick="printInvoice({{ $slip->id }})">
                                            <i class="fas fa-print me-1"></i> Print
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails({{ $slip->id }})">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <i class="fas fa-file-invoice fa-3x text-muted"></i>
                                        </div>
                                        <p class="empty-title">No invoices found</p>
                                        <p class="empty-subtitle text-muted">
                                            No charge slips have been created yet.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $chargeSlips->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function printInvoice(id) {
    // Implement print functionality
    alert('Print functionality coming soon');
}

function viewDetails(id) {
    // Implement view details functionality
    alert('View details functionality coming soon');
}
</script>
@endpush

@endsection 