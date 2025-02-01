@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Medical Records</h2>
                    <div class="text-muted mt-1">View patient medical records</div>
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
                                    <th>Record ID</th>
                                    <th>Pet Name</th>
                                    <th>Owner</th>
                                    <th>Checkup Date</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sampleRecords as $record)
                                <tr class="record-row" data-record-id="{{ $record['id'] }}">
                                    <td>#{{ str_pad($record['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $record['pet_name'] }}</td>
                                    <td>{{ $record['owner_name'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record['checkup_date'])->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $record['status'] === 'completed' ? 'green' : 'blue' }}-lt">
                                            {{ ucfirst($record['status']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-primary view-details" 
                                                onclick="showRecordDetails({{ json_encode($record) }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal modal-blur fade" id="recordDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medical Record Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="recordDetailsContent">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRecordDetails(record) {
    const modal = new bootstrap.Modal(document.getElementById('recordDetailsModal'));
    const content = document.getElementById('recordDetailsContent');
    
    // Remove any existing backdrops first
    const existingBackdrops = document.getElementsByClassName('modal-backdrop');
    while(existingBackdrops.length > 0) {
        existingBackdrops[0].parentNode.removeChild(existingBackdrops[0]);
    }
    
    // Add event listener to remove backdrop when modal is hidden
    const modalElement = document.getElementById('recordDetailsModal');
    modalElement.addEventListener('hidden.bs.modal', function () {
        const backdrops = document.getElementsByClassName('modal-backdrop');
        while(backdrops.length > 0) {
            backdrops[0].parentNode.removeChild(backdrops[0]);
        }
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    });
    
    content.innerHTML = `
        <div class="record-details">
            <!-- Patient Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Patient Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pet Name:</strong> ${record.pet_name}</p>
                            <p><strong>Owner:</strong> ${record.owner_name}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Checkup Date:</strong> ${new Date(record.checkup_date).toLocaleDateString()}</p>
                            <p><strong>Status:</strong> ${record.status}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vital Signs -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Vital Signs</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Temperature:</strong> ${record.vital_signs.temperature}°C</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Weight:</strong> ${record.vital_signs.weight} kg</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Heart Rate:</strong> ${record.vital_signs.heart_rate} bpm</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Respiratory Rate:</strong> ${record.vital_signs.respiratory_rate} /min</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Diagnosis Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Symptoms:</strong> ${record.diagnosis.symptoms}</p>
                    <p><strong>Findings:</strong> ${record.diagnosis.findings}</p>
                    <p><strong>Results:</strong> ${record.diagnosis.results}</p>
                    <p><strong>Treatment:</strong> ${record.diagnosis.treatment}</p>
                </div>
            </div>

            <!-- Billing -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Billing Information</h3>
                </div>
                <div class="card-body">
                    <table class="table table-transparent">
                        <tbody>
                            ${record.billing.services.map(service => `
                                <tr>
                                    <td>${service.name}</td>
                                    <td class="text-end">₱${service.amount.toFixed(2)}</td>
                                </tr>
                            `).join('')}
                            <tr>
                                <td class="text-end strong">Subtotal:</td>
                                <td class="text-end">₱${record.billing.subtotal.toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Discount:</td>
                                <td class="text-end">₱${record.billing.discount.toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td class="text-end strong">Total:</td>
                                <td class="text-end strong">₱${record.billing.total.toFixed(2)}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.record-row {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.record-row:hover {
    background-color: rgba(32, 107, 196, 0.03);
}

.modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.record-details .card {
    margin-bottom: 1rem;
}

.record-details .card:last-child {
    margin-bottom: 0;
}

/* Add these modal styles */
.modal-backdrop {
    display: none !important;
}

.modal {
    background: rgba(0, 0, 0, 0.5);
}
</style>
@endpush
@endsection 