@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ $showArchived ? __('Archived Appointments') : __('Appointments') }}
                    </h2>
                    <div class="text-muted mt-1">Manage appointment schedules</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <a href="{{ route('appointment.create') }}" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Add Appointment
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
                    <h3 class="card-title">All Appointments</h3>
                    <div class="card-actions">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">
                                    All Appointments
                                </a>
                                <a class="dropdown-item" href="#">
                                    Pending Confirmation
                                </a>
                                <a class="dropdown-item" href="#">
                                    Confirmed
                                </a>
                                <a class="dropdown-item" href="#">
                                    Completed
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="12%">Owner Details</th>
                                    <th width="12%">Pet Details</th>
                                    <th width="12%">Schedule</th>
                                    <th width="12%">Reason</th>
                                    <th width="12%">Status</th>
                                    <th width="12%">Created By</th>
                                    <th width="8%">Complete</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr style="cursor: pointer" 
                                        onclick="showAppointmentDetails({{ json_encode($appointment) }})"
                                        class="appointment-row">
                                        <td class="text-muted">
                                            #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($appointment->user && $appointment->user->photo)
                                                        <img src="{{ asset('storage/' . $appointment->user->photo) }}" 
                                                             alt="{{ $appointment->display_name }}" 
                                                             class="avatar avatar-sm rounded-circle"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                            {{ strtoupper(substr($appointment->display_name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                    <div class="text-dark fw-bold">{{ $appointment->display_name }}</div>
                                                </div>
                                                @if($appointment->is_walk_in)
                                                    <span class="badge bg-yellow-lt" title="Walk-in appointment">
                                                        <i class="fas fa-walking me-1"></i>Walk-in
                                                    </span>
                                                @else
                                                    <span class="badge bg-azure-lt" title="Registered user">
                                                        <i class="fas fa-user-check me-1"></i>Registered
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($appointment->pet && $appointment->pet->photo)
                                                        <img src="{{ asset('storage/' . $appointment->pet->photo) }}" 
                                                             alt="{{ $appointment->pet_name }}" 
                                                             class="avatar avatar-sm rounded-circle"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-pet.png') }}" 
                                                             alt="Default Pet" 
                                                             class="avatar avatar-sm rounded-circle"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    @endif
                                                    <div class="text-dark">{{ $appointment->pet_name }}</div>
                                                </div>
                                                <div class="text-muted small">
                                                    <span class="badge bg-blue-lt">{{ $appointment->pet_type }}</span>
                                                    <span class="ms-2 badge bg-green-lt">{{ $appointment->age_display }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date_display)->format('M d, Y') }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @forelse($appointment->reason_for_visit as $reason)
                                                    <span class="badge bg-primary-lt">{{ $reason }}</span>
                                                @empty
                                                    <span class="text-muted">No reasons specified</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>
                                            @switch($appointment->status)
                                                @case('pending')
                                                    <span class="badge bg-yellow-lt">
                                                        <i class="fas fa-clock me-1"></i>For Confirmation
                                                    </span>
                                                    @break
                                                @case('confirmed')
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="badge bg-blue-lt">
                                                            <i class="fas fa-check-circle me-1"></i>Confirmed
                                                        </span>
                                                        @if($appointment->confirmed_by)
                                                            <small class="text-muted">
                                                                Confirmed by: {{ $appointment->confirmer->name }}
                                                                <br>
                                                                <span class="text-muted-light">{{ $appointment->confirmed_at?->format('M d, Y g:i A') }}</span>
                                                            </small>
                                                        @endif
                                                    </div>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-green-lt">
                                                        <i class="fas fa-check-double me-1"></i>Completed
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-red-lt">
                                                        <i class="fas fa-times-circle me-1"></i>Cancelled
                                                    </span>
                                                    @break
                                                @case('no_show')
                                                    <span class="badge bg-gray-lt">
                                                        <i class="fas fa-user-slash me-1"></i>No Show
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary-lt">
                                                        <i class="fas fa-question-circle me-1"></i>Unknown
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">{{ $appointment->creator->name ?? 'N/A' }}</div>
                                                <div class="text-muted small">
                                                    {{ $appointment->created_at->format('M d, Y g:i A') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($appointment->status !== 'completed')
                                                <button onclick="showDiagnosisForm({{ json_encode($appointment) }})" 
                                                        class="btn btn-primary btn-sm">
                                                    <i class="fas fa-clipboard-check me-1"></i>
                                                    Complete
                                                </button>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Done
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                @if($appointment->status === 'pending')
                                                    @can('confirm-appointments')
                                                        <form action="{{ route('appointment.confirm', $appointment->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-icon btn-success" title="Confirm Appointment">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M5 12l5 5l10 -10"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                                
                                                @if(in_array($appointment->status, ['pending', 'confirmed']))
                                                    <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-icon btn-warning" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                                </div>
                                                <p class="empty-title">No appointments found</p>
                                                <p class="empty-subtitle text-muted">
                                                    Start by adding a new appointment using the button above.
                                                </p>
                                            </div>
                                        </td>
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

@section('scripts')
<script>
    // Removed unnecessary custom logic for "reason for visit"
    // If additional interactive functionality is required, 
    // add it here in a streamlined way.
</script>
@endsection

@push('page-styles')
<style>
    .table-vcenter td {
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .btn-icon {
        padding: 0.5rem;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-icon svg {
        width: 20px;
        height: 20px;
        stroke-width: 2;
    }
    
    .table td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }
    
    .table th {
        padding: 0.75rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.04em;
        color: var(--tblr-muted);
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    .d-flex.flex-column {
        gap: 0.25rem;
    }
    
    .text-muted.small {
        font-size: 0.75rem;
    }
    
    .d-flex.gap-2.justify-content-end {
        padding-right: 0.5rem;
    }
    
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .empty {
        text-align: center;
        padding: 2rem;
    }
    
    .empty-icon {
        margin-bottom: 1rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .empty-subtitle {
        font-size: 0.875rem;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .gap-1 {
        gap: 0.25rem;
    }
    
    .d-flex.gap-2 {
        gap: 0.75rem !important;
    }

    .appointment-row:hover {
        background-color: rgba(var(--tblr-primary-rgb), 0.05) !important;
    }

    .modal-body .form-control-plaintext {
        padding: 0.5rem;
        background-color: var(--tblr-bg-surface);
        border-radius: 4px;
        min-height: 40px;
    }

    /* Add these modal styles */
    .modal-backdrop {
        display: none !important;
    }

    .modal {
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    @media (min-width: 576px) {
        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem);
        }
    }

    .modal-content {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        min-height: 700px;
    }

    .modal-body {
        padding: 1.25rem;
    }

    .input-group-flat .form-control {
        border-right: 0;
    }

    .input-group-flat .input-group-text {
        background: #fff;
        border-left: 0;
    }

    .nav-tabs .nav-link {
        color: #666;
    }

    .nav-tabs .nav-link.active {
        font-weight: 600;
        color: var(--tblr-primary);
    }

    .tab-content {
        padding: 1rem 0;
    }

    .modal-lg {
        max-width: 850px;
    }
    
    .form-section {
        min-height: 450px;
        height: 450px;
        overflow-y: auto;
    }
    
    .form-section .card {
        margin-bottom: 0;
        height: 100%;
    }
    
    .form-section .card-body {
        height: calc(100% - 45px);
        overflow-y: auto;
    }
    
    .btn-group .btn {
        flex: 1;
    }
    
    .form-control-plaintext {
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 4px;
        min-height: 60px;
    }

    .card-body {
        padding: 1.25rem;
    }

    textarea.form-control {
        min-height: 65px;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .row.g-3 {
        --bs-gutter-y: 1rem;
    }

    .form-control, .form-select {
        min-height: 36px;
        padding: 0.4rem 0.75rem;
    }

    .diagnosis-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        line-height: 32px;
        font-size: 0.875rem;
    }

    .bg-primary-lt {
        background-color: rgba(32, 107, 196, 0.1);
        color: #206bc4;
    }

    .d-flex.align-items-center.gap-2 {
        gap: 0.5rem !important;
    }

    .avatar {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        font-weight: 500;
        text-align: center;
        text-transform: uppercase;
        user-select: none;
        background: #f8f9fa;
        border-radius: 50%;
    }
</style>
@endpush

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success toast if there's a success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
});

function showAppointmentDetails(appointment) {
    // Prevent row click when clicking action buttons
    if (event.target.closest('.btn')) {
        return;
    }

    const modalElement = document.getElementById('appointmentModal');
    const modal = new bootstrap.Modal(modalElement);
    
    // Set hidden fields for relationships
    document.getElementById('appointment_id').value = appointment.id;
    document.getElementById('pet_id').value = appointment.pet_id;

    // Display owner and pet details properly
    document.getElementById('owner-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${appointment.display_name}</span>
            <span class="badge ${appointment.is_walk_in ? 'bg-yellow-lt' : 'bg-azure-lt'} mt-1">
                <i class="${appointment.is_walk_in ? 'fas fa-walking' : 'fas fa-user-check'} me-1"></i>
                ${appointment.is_walk_in ? 'Walk-in' : 'Registered'}
            </span>
        </div>
    `;

    document.getElementById('pet-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${appointment.pet_name}</span>
            <div class="mt-1">
                <span class="badge bg-blue-lt">${appointment.pet_type}</span>
                <span class="badge bg-green-lt ms-1">${appointment.age_display}</span>
            </div>
        </div>
    `;

    modal.show();
}

function removeBackdrop() {
    // Remove any lingering backdrop
    const backdrops = document.getElementsByClassName('modal-backdrop');
    while(backdrops.length > 0) {
        backdrops[0].parentNode.removeChild(backdrops[0]);
    }
    
    // Remove modal-open class from body
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Add event listener for modal hidden event
document.getElementById('appointmentModal').addEventListener('hidden.bs.modal', removeBackdrop);

function saveDiagnosis() {
    const form = document.getElementById('diagnosisForm');
    const formData = new FormData(form);

    Swal.fire({
        title: 'Saving Medical Record',
        text: 'Please wait...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/medical-records', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Medical record has been saved',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            throw new Error(data.message || 'Error saving medical record');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    });
}

function showDiagnosisForm(appointment) {
    const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
    
    // Set hidden fields
    document.getElementById('appointment_id').value = appointment.id;
    document.getElementById('pet_id').value = appointment.pet_id;

    // Set owner details
    document.getElementById('owner-details').innerHTML = `
        <strong>${appointment.display_name}</strong>
        <span class="badge ${appointment.is_walk_in ? 'bg-yellow-lt' : 'bg-azure-lt'} ms-1">
            ${appointment.is_walk_in ? 'Walk-in' : 'Registered'}
        </span>
    `;

    // Set pet details
    document.getElementById('pet-details').innerHTML = `
        <strong>${appointment.pet_name}</strong>
        <span class="badge bg-blue-lt ms-1">${appointment.pet_type}</span>
    `;

    modal.show();
}

function addServiceRow() {
    const tbody = document.querySelector('#servicesTable tbody');
    const newRow = tbody.rows[0].cloneNode(true);
    newRow.querySelectorAll('input, select').forEach(input => input.value = '');
    tbody.appendChild(newRow);
    updateTotals();
}

function removeServiceRow(btn) {
    const tbody = document.querySelector('#servicesTable tbody');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
    }
    updateTotals();
}

function addMedicationRow() {
    const tbody = document.querySelector('#medicationsTable tbody');
    const newRow = tbody.rows[0].cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    tbody.appendChild(newRow);
    updateTotals();
}

function removeMedicationRow(btn) {
    const tbody = document.querySelector('#medicationsTable tbody');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
    }
    updateTotals();
}

function updateTotals() {
    let subtotal = 0;

    // Calculate services subtotal
    document.querySelectorAll('.service-amount').forEach(input => {
        subtotal += parseFloat(input.value || 0);
    });

    // Calculate medications subtotal
    document.querySelectorAll('.medication-amount').forEach(input => {
        const qty = input.closest('tr').querySelector('.medication-qty').value || 1;
        subtotal += parseFloat(input.value || 0) * parseInt(qty);
    });

    // Update subtotal display
    document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;

    // Calculate discount
    const discountAmount = parseFloat(document.getElementById('discountAmount').value || 0);
    const discountType = document.getElementById('discountType').value;
    let discount = 0;

    if (discountType === 'percent') {
        discount = subtotal * (discountAmount / 100);
    } else {
        discount = discountAmount;
    }

    // Update total
    const total = subtotal - discount;
    document.getElementById('total').textContent = `₱${total.toFixed(2)}`;
    
    // Recalculate change/remaining amount
    calculateChange();
}

// Add event listeners for real-time calculation
document.querySelectorAll('#tabs-invoice input, #tabs-invoice select').forEach(element => {
    element.addEventListener('input', updateTotals);
});

function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.form-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show selected section
    document.getElementById(`${sectionId}-section`).style.display = 'block';
    
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function toggleAmountPaid() {
    const status = document.getElementById('paymentStatus').value;
    const amountPaidSection = document.getElementById('amountPaidSection');
    const changeSection = document.getElementById('changeSection');
    const remainingSection = document.getElementById('remainingSection');
    
    if (status === 'pending') {
        amountPaidSection.style.display = 'none';
        changeSection.style.display = 'none';
        remainingSection.style.display = 'none';
    } else {
        amountPaidSection.style.display = 'block';
        calculateChange();
    }
}

function calculateChange() {
    const total = parseFloat(document.getElementById('total').textContent.replace('₱', '')) || 0;
    const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
    const status = document.getElementById('paymentStatus').value;
    const changeSection = document.getElementById('changeSection');
    const remainingSection = document.getElementById('remainingSection');
    
    if (status === 'partial') {
        const remaining = total - amountPaid;
        changeSection.style.display = 'none';
        remainingSection.style.display = 'block';
        document.getElementById('remainingAmount').textContent = `₱${remaining.toFixed(2)}`;
    } else {
        const change = amountPaid - total;
        changeSection.style.display = 'block';
        remainingSection.style.display = 'none';
        document.getElementById('changeAmount').textContent = `₱${Math.max(0, change).toFixed(2)}`;
    }
}
</script>
@endpush
