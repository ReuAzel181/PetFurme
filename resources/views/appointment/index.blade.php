@extends('layouts.tabler')

@push('page-styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .row.g-4 {
        --bs-gutter-y: 0.5rem !important;
    }
    
    /* Reduce padding in card body */
    .card-body.p-4 {
        padding: 0.75rem !important;
    }
    
    /* Reduce spacing in summary section */
    .border-top.pt-4 {
        padding-top: 0.75rem !important;
    }
    
    /* Reduce spacing between sections */
    .mb-4 {
        margin-bottom: 0.75rem !important;
    }
    
    /* Keep header sticky */
    #servicesTable thead,
    #productsTable thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 2;
    }

    /* Add this CSS to center the empty message */
    .empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
</style>
@endpush

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
                    <div class="d-flex gap-2">
                        <a href="{{ route('appointment.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add Appointment
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
                                    <th width="5%">Reminder</th>
                                    <th width="12%">Owner Details</th>
                                    <th width="12%">Pet Details</th>
                                    <th width="12%">Schedule</th>
                                    <th width="12%">Reason</th>
                                    <th width="12%">Status</th>
                                    <th width="12%">Created By</th>
                                    <th width="8%">Created At</th>
                                    <th width="8%">Complete</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    @php
                                        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                                        $today = \Carbon\Carbon::now()->startOfDay();
                                        
                                        // Skip past appointments - they should be in archives
                                        if ($appointmentDate->lt($today)) {
                                            continue;
                                        }
                                    @endphp
                                    
                                    <tr style="cursor: pointer" 
                                        data-appointment="{{ htmlspecialchars(json_encode($appointment), ENT_QUOTES, 'UTF-8') }}"
                                        class="appointment-row">
                                        <td>
                                            @if($appointment->user && !empty($appointment->user->phone))
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary send-reminder-btn" 
                                                        data-id="{{ $appointment->id }}" 
                                                        data-phone="{{ $appointment->user->phone }}" 
                                                        onclick="sendReminder(event, {{ $appointment->id }})">
                                                    <i class="fas fa-bell me-1"></i>Send
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="No phone number available">
                                                    <i class="fas fa-bell-slash me-1"></i>N/A
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                @if($appointment->user)
                                                    <div class="d-flex align-items-center gap-2">
                                                        @php
                                                            $userImage = null;
                                                            // First try photo_data
                                                            if ($appointment->user->photo_data) {
                                                                $userImage = 'data:image/jpeg;base64,' . base64_encode($appointment->user->photo_data);
                                                            }
                                                            // Then try photo path
                                                            elseif ($appointment->user->photo) {
                                                                $photoPath = storage_path('app/public/' . $appointment->user->photo);
                                                                if (file_exists($photoPath)) {
                                                                    $userImage = asset('storage/' . $appointment->user->photo);
                                                                }
                                                            }
                                                        @endphp

                                                        @if($userImage)
                                                            <img src="{{ $userImage }}" 
                                                                 alt="{{ $appointment->user->name }}" 
                                                                 class="avatar avatar-sm rounded-circle"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                                {{ strtoupper(substr($appointment->user->name, 0, 1)) }}
                                                            </span>
                                                        @endif
                                                        <div class="text-dark fw-bold">{{ $appointment->user->name }}</div>
                                                    </div>
                                                @endif
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
                                                    @if($appointment->pet)
                                                        @php
                                                            $petImage = null;
                                                            // First try photo_data
                                                            if ($appointment->pet->photo_data) {
                                                                $petImage = 'data:image/jpeg;base64,' . base64_encode($appointment->pet->photo_data);
                                                            }
                                                            // Then try photo field
                                                            elseif ($appointment->pet->photo) {
                                                                // Check if photo contains binary data
                                                                if (substr($appointment->pet->photo, 0, 4) !== 'http' && 
                                                                    substr($appointment->pet->photo, 0, 8) !== 'uploads/') {
                                                                    $petImage = 'data:image/jpeg;base64,' . base64_encode($appointment->pet->photo);
                                                                }
                                                                // Otherwise treat as file path
                                                                else {
                                                                    $photoPath = storage_path('app/public/' . $appointment->pet->photo);
                                                                    if (file_exists($photoPath)) {
                                                                        $petImage = asset('storage/' . $appointment->pet->photo);
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        @if($petImage)
                                                            <img src="{{ $petImage }}" 
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
                                                    @endif
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
                                            {{ $appointment->formatted_reason }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm {{ 
                                                    $appointment->status === 'pending' ? 'btn-warning' : 
                                                    ($appointment->status === 'confirmed' ? 'btn-success' : 
                                                    ($appointment->status === 'cancelled' ? 'btn-danger' : 'btn-secondary')) 
                                                }} dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false"
                                                        onclick="event.stopPropagation()">
                                                    {{ ucfirst($appointment->status) }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($appointment->status !== 'confirmed')
                                                        <li>
                                                            <form action="{{ route('appointment.updateStatus', $appointment->id) }}" 
                                                                  method="POST" 
                                                                  class="status-update-form">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check me-2"></i>Confirm
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if($appointment->status !== 'cancelled')
                                                        <li>
                                                            <form action="{{ route('appointment.updateStatus', $appointment->id) }}" 
                                                                  method="POST" 
                                                                  class="status-update-form">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times me-2"></i>Cancel
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            @if($appointment->status === 'confirmed' && $appointment->actions)
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        @php
                                                            $actions = json_decode($appointment->actions, true);
                                                        @endphp
                                                        @if($actions && isset($actions['confirmer_name']))
                                                            Confirmed by: {{ $actions['confirmer_name'] }}
                                                            <br>
                                                            <span class="text-muted">{{ \Carbon\Carbon::parse($actions['confirmed_at'])->format('M d, Y g:i A') }}</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($appointment->created_by_type && $appointment->created_by_id)
                                                @php
                                                    $creator = \App\Models\User::find($appointment->created_by_id);
                                                    $roleLabel = '';
                                                    
                                                    if ($creator) {
                                                        if ($creator->hasRole('admin') || $creator->is_admin) {
                                                            $roleLabel = '<span class="badge bg-danger-lt ms-1">Admin</span>';
                                                        } elseif ($creator->hasRole('staff') || $creator->is_staff) {
                                                            $roleLabel = '<span class="badge bg-purple-lt ms-1">Staff</span>';
                                                        } elseif ($appointment->created_by_type == 'user') {
                                                            $roleLabel = '<span class="badge bg-blue-lt ms-1">User</span>';
                                                        }
                                                    }
                                                @endphp
                                                
                                                @if($appointment->created_by_type == 'staff')
                                                    {{ $creator->name ?? 'Staff Member' }} {!! $roleLabel !!}
                                                @elseif($appointment->created_by_type == 'user')
                                                    {{ $creator->name ?? 'User' }} {!! $roleLabel !!}
                                                @else
                                                    {{ $appointment->created_by_type }} {!! $roleLabel !!}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            {{ $appointment->created_at ? $appointment->created_at->format('M d, Y g:i A') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if($appointment->status !== 'completed')
                                                @php
                                                    $appointmentData = [
                                                        'id' => $appointment->id,
                                                        'user_id' => $appointment->user_id,
                                                        'pet_id' => $appointment->pet_id,
                                                        'pet_name' => $appointment->pet_name,
                                                        'appointment_date' => $appointment->appointment_date,
                                                        'appointment_time' => $appointment->appointment_time,
                                                        'reason_for_visit' => $appointment->reason_for_visit,
                                                        'status' => $appointment->status,
                                                        'display_name' => $appointment->user ? $appointment->user->name : $appointment->owner_name,
                                                    ];
                                                @endphp
                                                <button type="button" 
                                                        class="btn btn-primary btn-sm complete-btn"
                                                        onclick="handleCompleteClick({{ $appointment->id }}, {{ json_encode($appointmentData) }})"
                                                        data-appointment='{{ json_encode($appointmentData) }}'>
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

                                                <!-- Delete Button -->
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
                                        <td colspan="10" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                                </div>
                                                <p class="empty-title">No upcoming appointments found</p>
                                                <p class="empty-subtitle text-muted">
                                                    Start by adding a new appointment using the button above.<br>
                                                    Past appointments can be found in the <a href="{{ route('analytics.archives') }}">Archives</a>.
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

<!-- Medical Record Modal -->
<div class="modal fade" id="medicalRecordModal" tabindex="-1" role="dialog" aria-labelledby="medicalRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2">
                <div class="d-flex align-items-center">
                    <div class="logo-wrapper me-2">
                        <img src="{{ asset('storage/defaults/vc_logo.png') }}" alt="VetCare Logo" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                    </div>
                    <h5 class="modal-title mb-0" id="medicalRecordModalLabel">CHARGE SLIP</h5>
                    <button type="button" class="btn btn-light btn-sm ms-3" onclick="printChargeSlip()">
                        <i class="fas fa-print me-1"></i>Print Slip
                    </button>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="medicalRecordForm">
                    @csrf
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <input type="hidden" name="pet_id" id="pet_id">
                    
                    <div class="row g-4">
                        <!-- Left Column - Patient Info and Services -->
                        <div class="col-md-7">
                            <!-- Charge Slip Header -->
                            <div class="d-flex justify-content-between mb-4">
                                <h6 class="fw-bold">Patient Information</h6>
                                <div class="text-end">
                                    <div class="text-primary fw-bold">No. <span id="invoiceNumber"></span></div>
                                    <div class="text-muted small">Date: {{ now()->format('F d, Y') }}</div>
                                </div>
                            </div>
                    
                    <!-- Patient Information -->
                            <div class="row g-3 mb-4">
                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Name</label>
                                        <input type="text" class="form-control" id="patientName" name="patient_name" readonly>
                                    </div>
                        </div>
                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Number</label>
                                        <input type="text" class="form-control" name="address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Attending Physician</label>
                                        <input type="text" class="form-control" name="attending_physician">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Clinic</label>
                                        <input type="text" class="form-control" name="clinic" value="VetCare" readonly>
                                    </div>
                        </div>
                    </div>

                            <!-- Services Section -->
                            <div class="mb-4 services-section">
                                <h6 class="fw-bold mb-3">Services</h6>
                                <div class="services-table-container">
                                    <table class="table table-borderless align-middle" id="servicesTable">
                                        <thead>
                                            <tr>
                                                <th class="text-muted small" style="width: 65%">DESCRIPTION</th>
                                                <th class="text-end text-muted small" style="width: 25%">AMOUNT</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <select class="form-select form-select-sm" name="services[]" onchange="handleServiceSelection(this)">
                                                            <option value="">Select Service</option>
                                                            <option value="consultation">Consultation</option>
                                                            <option value="vaccination">Vaccination</option>
                                                            <option value="deworming">Deworming</option>
                                                            <option value="grooming">Grooming</option>
                                                            <option value="surgery">Surgery</option>
                                                            <option value="custom">Other Service</option>
                                                        </select>
                                                        <input type="text" class="form-control form-control-sm custom-service d-none mt-2" 
                                                               placeholder="Enter service description" name="custom_services[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group has-peso">
                                                        <span class="input-group-text bg-transparent">₱</span>
                                                        <input type="number" class="form-control form-control-sm text-end service-amount" 
                                                               name="service_amounts[]" value="0" 
                                                               onfocus="if(this.value=='0'){this.value='';}" 
                                                               onblur="if(this.value==''){this.value='0';}"
                                                               oninput="updateTotals()">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeServiceRow(this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="pt-2">
                                                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="addServiceRow()">
                                                        <i class="fas fa-plus me-1"></i>Add Service
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Products and Summary -->
                        <div class="col-md-5">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold mb-3">Products</h6>
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-borderless align-middle" id="productsTable">
                                            <thead class="sticky-top bg-white">
                                                <tr>
                                                    <th class="text-muted small" style="width: 45%">ITEM</th>
                                                    <th class="text-center text-muted small" style="width: 20%">QTY</th>
                                                    <th class="text-end text-muted small" style="width: 25%">AMOUNT</th>
                                                    <th style="width: 10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-select form-select-sm" name="products[]" onchange="handleProductSelection(this)">
                                                            <option value="">Select Product</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                        data-stock="{{ $product->quantity }}">
                                                                    {{ $product->name }} (₱{{ number_format($product->selling_price * 100, 2) }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" class="form-control form-control-sm custom-product d-none" 
                                                               placeholder="Enter product name" name="custom_products[]">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm text-center product-qty" 
                                                               name="product_qty[]" value="1" min="1" onchange="updateProductTotal(this)">
                                                    </td>
                                                    <td>
                                                        <div class="input-group has-peso">
                                                            <span class="input-group-text bg-transparent">₱</span>
                                                            <input type="number" class="form-control form-control-sm text-end product-amount" 
                                                                   name="product_amounts[]" value="0" readonly
                                                                   onfocus="if(this.value=='0'){this.value='';}" 
                                                                   onblur="if(this.value==''){this.value='0';}">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-link text-danger p-1 delete-product-btn" style="display: none;" onclick="removeProductRow(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <button type="button" class="btn btn-sm btn-link text-primary p-0 my-3" onclick="addProductRow()">
                                        <i class="fas fa-plus me-1"></i>Add Product
                                    </button>

                                    <!-- Summary Section -->
                                    <div class="border-top pt-4">
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span class="text-muted">Services Subtotal:</span>
                                            <span class="fw-medium">₱<span id="servicesSubtotal">0.00</span></span>
                                        </div>
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span class="text-muted">Products Subtotal:</span>
                                            <span class="fw-medium">₱<span id="productsSubtotal">0.00</span></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Discount:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-group input-group-sm" style="width: 200px;">
                                                    <input type="number" id="discountAmount" class="form-control text-end" value="0" min="0">
                                                    <select id="discountType" class="form-select" style="max-width: 100px;">
                                                        <option value="fixed">₱</option>
                                                        <option value="percentage">%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end text-muted small" id="discountDisplay">₱0.00</div>
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span class="text-muted">Total:</span>
                                            <span class="fw-medium">₱<span id="subtotal">0.00</span></span>
                                        </div>
                                        <div class="pt-2 border-top">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">GRAND TOTAL:</span>
                                                <span id="total" class="fw-bold text-primary h5 mb-0">₱0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section with more spacing -->
                    <div class="mt-4 pt-2">
                        <label class="form-label small mb-2">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Enter any additional notes here..."></textarea>
                    </div>

                    <!-- Footer Buttons with more spacing -->
                    <div class="modal-footer px-0 pb-0 border-0 mt-4 pt-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info px-4 me-2" onclick="openDiagnosisForm()">
                            <i class="fas fa-stethoscope me-1"></i>Add Diagnosis
                        </button>
                        <button type="button" class="btn btn-primary px-4" onclick="saveMedicalRecord()">Complete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add a printable version of the charge slip -->
<div id="printableArea" class="d-none">
    <div class="invoice-header text-center mb-4">
        <img src="{{ asset('storage/defaults/vc_logo.png') }}" alt="VetCare Logo" class="mb-2" style="width: 60px;">
        <h4 class="mb-1">VetCare Animal Clinic</h4>
        <p class="text-muted mb-1">123 Pet Street, Animal City</p>
        <p class="text-muted mb-1">Tel: (123) 456-7890</p>
        <h5 class="mt-3">CHARGE SLIP</h5>
        <div class="text-muted">No. <span id="printInvoiceNumber"></span></div>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <p class="mb-1"><strong>Patient:</strong> <span id="printPatientName"></span></p>
            <p class="mb-1"><strong>Address:</strong> <span id="printAddress"></span></p>
        </div>
        <div class="col-6 text-end">
            <p class="mb-1"><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
            <p class="mb-1"><strong>Attending Vet:</strong> <span id="printPhysician"></span></p>
        </div>
    </div>

    <div class="services-section mb-4">
        <h6 class="border-bottom pb-2">Services</h6>
        <table class="table table-sm" id="printServicesTable">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="products-section mb-4">
        <h6 class="border-bottom pb-2">Products</h6>
        <table class="table table-sm" id="printProductsTable">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="summary-section">
        <div class="row">
            <div class="col-7">
                <div class="notes-section">
                    <p class="mb-1"><strong>Notes:</strong></p>
                    <p id="printNotes" class="text-muted"></p>
                </div>
            </div>
            <div class="col-5">
                <table class="table table-sm">
                    <tr>
                        <td>Services Subtotal:</td>
                        <td class="text-end">₱<span id="printServicesSubtotal">0.00</span></td>
                    </tr>
                    <tr>
                        <td>Products Subtotal:</td>
                        <td class="text-end">₱<span id="printProductsSubtotal">0.00</span></td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td class="text-end">₱<span id="printDiscount">0.00</span></td>
                    </tr>
                    <tr class="fw-bold">
                        <td>TOTAL:</td>
                        <td class="text-end">₱<span id="printTotal">0.00</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="footer-section mt-5 pt-4">
        <div class="row">
            <div class="col-6">
                <p class="mb-4">Received by:</p>
                <div class="border-top pt-2" style="width: 200px;">Customer Signature</div>
            </div>
            <div class="col-6 text-end">
                <p class="mb-4">Prepared by:</p>
                <div class="border-top pt-2" style="margin-left: auto; width: 200px;">Authorized Signature</div>
            </div>
        </div>
    </div>
</div>

<!-- Include modals inside content section -->
@include('components.findings-modal')
@include('components.findings-history-modal')

@endsection  {{-- Close the content section --}}

@push('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/findings.js') }}"></script>
<script>
// Define functions first
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

    modal.show();
}

function handleCompleteClick(appointmentId, appointmentData) {
    console.log('Complete button clicked:', { id: appointmentId, data: appointmentData });
    
    try {
        // Validate appointment ID
        if (!appointmentId) {
            throw new Error('Invalid appointment ID');
        }

        // Show the modal
        const modalElement = document.getElementById('medicalRecordModal');
        if (!modalElement) {
            throw new Error('Modal element not found');
        }

        const modal = new bootstrap.Modal(modalElement);
        
        // Set the appointment ID first
        const appointmentIdInput = document.getElementById('appointment_id');
        if (!appointmentIdInput) {
            throw new Error('Appointment ID input not found');
        }
        appointmentIdInput.value = appointmentId;

        // Verify the appointment ID was set
        if (!appointmentIdInput.value) {
            throw new Error('Failed to set appointment ID');
        }

        // Initialize other form fields
        document.getElementById('patientName').value = appointmentData.display_name || '';
        document.getElementById('invoiceNumber').textContent = generateInvoiceNumber();
        document.querySelector('input[name="attending_physician"]').value = '';
        
        // Show the modal
        modal.show();
        
        // Reset form elements
        document.getElementById('discountAmount').value = '0';
        document.getElementById('discountType').value = 'fixed';
        document.querySelector('textarea[name="notes"]').value = '';
        
        // Clear and reset products table
        resetProductsTable();
        
        // Update totals
        updateTotals();
        
        console.log('Modal initialized successfully with appointment ID:', appointmentId);
    } catch (error) {
        console.error('Error in handleCompleteClick:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message,
        });
    }
}

// Helper function to reset products table
function resetProductsTable() {
    const productsTbody = document.querySelector('#productsTable tbody');
    if (!productsTbody) return;
    
    // Keep only first row
    while (productsTbody.rows.length > 1) {
        productsTbody.deleteRow(1);
    }
    
    // Reset first row
    const firstRow = productsTbody.rows[0];
    if (firstRow) {
        const select = firstRow.querySelector('select');
        const qtyInput = firstRow.querySelector('.product-qty');
        const amountInput = firstRow.querySelector('.product-amount');
        
        if (select) select.selectedIndex = 0;
        if (qtyInput) qtyInput.value = '1';
        if (amountInput) amountInput.value = '0';
    }
}

function initializeMedicalRecord(appointment) {
    // Set appointment details in the form
    document.getElementById('appointment_id').value = appointment.id;
    document.getElementById('pet_id').value = appointment.pet_id;
    document.getElementById('patientName').value = appointment.display_name;

    // Reset form sections
    document.getElementById('medicalRecordForm').reset();
    
    // Keep the patient name after form reset
    document.getElementById('patientName').value = appointment.display_name;
    
    // Initialize invoice number
    document.getElementById('invoiceNumber').textContent = generateInvoiceNumber();
    
    // Get the first service select dropdown
    const serviceSelect = document.querySelector('#servicesTable tbody tr:first-child select');
    
    if (serviceSelect && appointment.reason_for_visit) {
        try {
            let reason = appointment.reason_for_visit[0];
            // Clean up the reason string if it contains extra quotes or brackets
            reason = reason.replace(/[\[\]"]/g, '');
            
            // Map the reason to the corresponding option value
            const reasonToValue = {
                'Consultation': 'consultation',
                'Vaccination': 'vaccination',
                'Deworming': 'deworming',
                'Grooming': 'grooming',
                'Surgery': 'surgery',
                'Laboratory': 'laboratory',
                'Dental Cleaning': 'dental',
                'Boarding': 'boarding'
            };

            // Set the selected value
            if (reasonToValue[reason]) {
                serviceSelect.value = reasonToValue[reason];
                // Trigger the change event to update any dependent fields
                handleServiceSelection(serviceSelect);
            }
        } catch (error) {
            console.error('Error setting service:', error);
        }
    }
    
    // Reset products table to initial state
    const productsTbody = document.querySelector('#productsTable tbody');
    while (productsTbody.rows.length > 1) {
        productsTbody.deleteRow(1);
    }
    productsTbody.rows[0].querySelectorAll('input, select').forEach(input => input.value = '');
    
    // Reset totals
    updateTotals();
}

// Make sure this function exists
function generateInvoiceNumber() {
    return String(Math.floor(Math.random() * 9000000) + 1000000);
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add event delegation for appointment rows
    document.querySelector('tbody').addEventListener('click', function(e) {
        const row = e.target.closest('.appointment-row');
        if (row && !e.target.closest('.btn')) {
            try {
                const appointmentData = row.dataset.appointment;
                if (!appointmentData) {
                    console.error('No appointment data found');
                    return;
                }
                const appointment = JSON.parse(appointmentData);
                showAppointmentDetails(appointment);
            } catch (error) {
                console.error('Error parsing appointment data:', error);
            }
        }
    });

    // Add event delegation for complete buttons with more detailed debugging
    document.querySelector('tbody').addEventListener('click', function(e) {
        const completeBtn = e.target.closest('.complete-btn');
        if (completeBtn) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Complete button clicked');
            console.log('Button element:', completeBtn);
            console.log('Raw data-appointment:', completeBtn.getAttribute('data-appointment'));
            
            try {
                const appointmentData = completeBtn.getAttribute('data-appointment');
                console.log('Appointment data string:', appointmentData);
                
                if (!appointmentData) {
                    console.error('No appointment data found on complete button');
                    return;
                }
                
                const appointment = JSON.parse(appointmentData);
                console.log('Parsed appointment:', appointment);
                
                handleCompleteClick(appointment.id, appointment);
            } catch (error) {
                console.error('Error details:', {
                    message: error.message,
                    button: completeBtn,
                    rawData: completeBtn.getAttribute('data-appointment')
                });
            }
        }
    });

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

    // Add quantity change handler
    document.querySelectorAll('.product-qty').forEach(input => {
        input.addEventListener('change', function() {
            const row = this.closest('tr');
            const select = row.querySelector('select');
            if (select.value && select.value !== 'custom') {
                const selectedText = select.options[select.selectedIndex].text;
                const priceMatch = selectedText.match(/₱([\d,]+\.?\d*)/);
                if (priceMatch) {
                    const price = parseFloat(priceMatch[1].replace(/,/g, ''));
                    const quantity = parseFloat(this.value) || 0;
                    const amountInput = row.querySelector('.product-amount');
                    amountInput.value = (price * quantity).toFixed(2);
                    updateTotals();
                }
            }
        });
    });

    // Add discount input handlers
    const discountAmount = document.getElementById('discountAmount');
    const discountType = document.getElementById('discountType');

    if (discountAmount && discountType) {
        discountAmount.addEventListener('input', updateTotals);
        discountType.addEventListener('change', updateTotals);
        
        // Clear zero on focus
        discountAmount.addEventListener('focus', function() {
            if (this.value === '0') {
                this.value = '';
            }
        });
        
        // Reset to zero if empty on blur
        discountAmount.addEventListener('blur', function() {
            if (this.value === '') {
                this.value = '0';
            }
        });
    }
});

// Improved function to handle service selection
function handleServiceSelection(select) {
    const row = select.closest('tr');
    const customServiceInput = row.querySelector('.custom-service');
    const amountInput = row.querySelector('.service-amount');
    
    if (select.value === 'custom') {
        // Hide the select and show the custom input
        select.style.display = 'none';
        if (customServiceInput) {
            customServiceInput.classList.remove('d-none');
            customServiceInput.placeholder = "Enter service description";
            // Focus on the custom input field
            setTimeout(() => customServiceInput.focus(), 100);
        }
        if (amountInput) {
            amountInput.readOnly = false;
            amountInput.value = '0';
        }
    } else {
        // Always make sure the select is visible and custom input is hidden
        select.style.display = '';
        if (customServiceInput) {
            customServiceInput.classList.add('d-none');
            customServiceInput.value = '';
        }
        if (amountInput) {
            amountInput.readOnly = false;
            amountInput.value = '0';
        }
    }
    
    updateTotals();
}

// Modified function to add new service row
function addServiceRow() {
    const tbody = document.querySelector('#servicesTable tbody');
    const firstRow = tbody.querySelector('tr');
    const newRow = firstRow.cloneNode(true);
    
    // Reset values in the new row
    newRow.querySelectorAll('input, select').forEach(input => {
        input.value = '';
        if (input.classList.contains('service-amount')) {
            input.value = '0';
        }
        if (input.classList.contains('custom-service')) {
            input.classList.add('d-none');
        }
        // Make sure select is visible
        if (input.tagName === 'SELECT') {
            input.style.display = '';
        }
    });
    
    tbody.appendChild(newRow);
    updateTotals();
}

// Modified function to remove service row
function removeServiceRow(button) {
    const tbody = document.querySelector('#servicesTable tbody');
    
    if (tbody.rows.length > 1) {
        button.closest('tr').remove();
    } else {
        // If it's the last row, just clear values
        const row = button.closest('tr');
        const selectElement = row.querySelector('select');
        
        // Reset the select to visible state
        if (selectElement) {
            selectElement.style.display = '';
            selectElement.selectedIndex = 0;
        }
        
        // Hide and clear custom input
        const customInput = row.querySelector('.custom-service');
        if (customInput) {
            customInput.classList.add('d-none');
            customInput.value = '';
        }
        
        // Reset amount
        const amountInput = row.querySelector('.service-amount');
        if (amountInput) {
            amountInput.value = '0';
        }
    }
    
    updateTotals();
}

// Updated function to handle product selection
function handleProductSelection(select) {
    const row = select.closest('tr');
    const qtyInput = row.querySelector('.product-qty');
    const amountInput = row.querySelector('.product-amount');
    const customProductInput = row.querySelector('.custom-product');
    const deleteBtn = row.querySelector('.delete-product-btn');
    
    // Toggle delete button visibility
    if (select.value) {
        if (deleteBtn) deleteBtn.style.display = 'inline-flex';
        
        // Always set quantity to 1 when a product is selected
        qtyInput.value = '1';
    } else {
        if (deleteBtn) deleteBtn.style.display = 'none';
        // Reset amount to 0 and clear quantity when deselecting
        amountInput.value = '0';
        qtyInput.value = '';
    }
    
    if (select.value === 'custom') {
        if (customProductInput) {
            customProductInput.classList.remove('d-none');
        }
        if (amountInput) {
            amountInput.readOnly = false;
            amountInput.value = '0';
        }
    } else if (select.value) {
        if (customProductInput) {
            customProductInput.classList.add('d-none');
            customProductInput.value = '';
        }
        
        // Get the selected option's text which contains the price
        const selectedText = select.options[select.selectedIndex].text;
        const priceMatch = selectedText.match(/₱([\d,]+\.?\d*)/);
        if (priceMatch) {
            const price = parseFloat(priceMatch[1].replace(/,/g, ''));
            // Use fixed quantity of 1
            amountInput.value = (price * 1).toFixed(2);
        }
    }
    
    updateTotals();
}

// Updated function to add a new product row
function addProductRow() {
    const tbody = document.querySelector('#productsTable tbody');
    const firstRow = tbody.querySelector('tr');
    const newRow = firstRow.cloneNode(true);
    
    // Reset values in the new row
    newRow.querySelectorAll('input, select').forEach(input => {
        input.value = input.type === 'number' && input.classList.contains('product-qty') ? '1' : 
                      input.type === 'number' ? '0' : '';
        if (input.classList.contains('custom-product')) {
            input.classList.add('d-none');
        }
    });
    
    // Ensure the delete button is hidden for the new row
    const deleteBtn = newRow.querySelector('.delete-product-btn');
    if (deleteBtn) deleteBtn.style.display = 'none';
    
    tbody.appendChild(newRow);
    updateTotals();
}

// Updated function to handle product quantity changes
function updateProductTotal(qtyInput) {
    const row = qtyInput.closest('tr');
    const select = row.querySelector('select[name="products[]"]');
    const amountInput = row.querySelector('.product-amount');
    
    if (select.value && select.value !== 'custom') {
        const selectedText = select.options[select.selectedIndex].text;
        const priceMatch = selectedText.match(/₱([\d,]+\.?\d*)/);
        if (priceMatch) {
            const price = parseFloat(priceMatch[1].replace(/,/g, ''));
            const quantity = parseFloat(qtyInput.value) || 0;
            amountInput.value = (price * quantity).toFixed(2);
        }
    }
    
    updateTotals();
}

// Updated function to remove a product row and completely clear values
function removeProductRow(button) {
    const tbody = document.querySelector('#productsTable tbody');
    if (tbody.rows.length > 1) {
        button.closest('tr').remove();
    } else {
        // If it's the last row, just clear all values
        const row = button.closest('tr');
        
        // Clear the product selection first (select dropdown)
        const productSelect = row.querySelector('select[name="products[]"]');
        if (productSelect) {
            productSelect.selectedIndex = 0;
        }
        
        // Completely clear quantity field instead of setting to 1
        const qtyInput = row.querySelector('.product-qty');
        if (qtyInput) {
            qtyInput.value = '';
        }
        
        // Reset amount to empty
        const amountInput = row.querySelector('.product-amount');
        if (amountInput) {
            amountInput.value = '0';
        }
        
        // Hide any custom product field
        const customProductInput = row.querySelector('.custom-product');
        if (customProductInput) {
            customProductInput.classList.add('d-none');
            customProductInput.value = '';
        }
        
        // Hide the delete button since we've cleared the selection
        const deleteBtn = row.querySelector('.delete-product-btn');
        if (deleteBtn) {
            deleteBtn.style.display = 'none';
        }
    }
    updateTotals();
}

function updateTotals() {
    // Initialize variables
    let servicesTotal = 0;
    let productsTotal = 0;

    // Calculate services total
    document.querySelectorAll('#servicesTable .service-amount').forEach(input => {
        servicesTotal += parseFloat(input.value) || 0;
    });

    // Calculate products total
    document.querySelectorAll('#productsTable .product-amount').forEach(input => {
        productsTotal += parseFloat(input.value) || 0;
    });

    // Calculate discount
    const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
    const discountType = document.getElementById('discountType').value;
    let discountValue = 0;

    const subtotal = servicesTotal + productsTotal;

    if (discountType === 'percentage') {
        discountValue = (subtotal * (discountAmount / 100));
    } else { // fixed amount
        discountValue = discountAmount;
    }

    // Calculate final total
    const total = subtotal - discountValue;

    // Update display values
    document.getElementById('servicesSubtotal').textContent = servicesTotal.toFixed(2);
    document.getElementById('productsSubtotal').textContent = productsTotal.toFixed(2);
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('discountDisplay').textContent = `₱${discountValue.toFixed(2)}`;
    
    // Update the grand total
    const grandTotalElement = document.querySelector('#total');
    if (grandTotalElement) {
        grandTotalElement.textContent = `₱${total.toFixed(2)}`;
    }

    // Update printable version totals if they exist
    const printElements = {
        'printServicesSubtotal': servicesTotal,
        'printProductsSubtotal': productsTotal,
        'printDiscount': discountValue,
        'printTotal': total
    };

    for (const [id, value] of Object.entries(printElements)) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value.toFixed(2);
        }
    }
}

// Add event listeners for amount inputs
document.addEventListener('DOMContentLoaded', function() {
    // Add input event listeners to all amount fields
    document.querySelectorAll('.service-amount, .product-amount').forEach(input => {
        input.addEventListener('input', updateTotals);
    });

    // Add input event listener to discount field
    const discountInput = document.getElementById('discountAmount');
    if (discountInput) {
        discountInput.addEventListener('input', updateTotals);
    }

    // Add change event listener to discount type dropdown
    const discountType = document.getElementById('discountType');
    if (discountType) {
        discountType.addEventListener('change', updateTotals);
    }
});

// Add this function to save the medical record
function saveMedicalRecord() {
    // Debug log the form data before submission
    const appointmentId = document.getElementById('appointment_id').value;
    console.log('Saving medical record for appointment:', appointmentId);

    // Collect services
    const services = collectServices();
    if (services.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please add at least one service',
        });
        return;
    }

    // Calculate totals
    let servicesTotal = 0;
    let productsTotal = 0;
    
    // Sum up services and ensure amounts are formatted as numbers
    services.forEach(service => {
        service.amount = parseFloat(parseFloat(service.amount || 0).toFixed(2));
        servicesTotal += service.amount;
    });
    
    // Collect and sum up products
    const products = collectProducts();
    products.forEach(product => {
        product.amount = parseFloat(parseFloat(product.amount || 0).toFixed(2));
        productsTotal += product.amount;
    });

    // Format totals as numbers
    servicesTotal = parseFloat(parseFloat(servicesTotal).toFixed(2));
    productsTotal = parseFloat(parseFloat(productsTotal).toFixed(2));

    // Calculate discount as number
    const discountAmount = parseFloat(parseFloat(document.getElementById('discountAmount').value || 0).toFixed(2));
    const discountType = document.getElementById('discountType').value;
    
    // Calculate grand total as number
    const subtotal = servicesTotal + productsTotal;
    const discount = discountType === 'percentage' ? 
        parseFloat((subtotal * (discountAmount / 100)).toFixed(2)) : 
        discountAmount;
    const grandTotal = parseFloat((subtotal - discount).toFixed(2));

    // Create the form data with numeric values
    const formData = {
        appointment_id: parseInt(appointmentId),
        invoice_number: document.getElementById('invoiceNumber').textContent.trim(),
        patient_name: document.getElementById('patientName').value.trim(),
        attending_physician: document.querySelector('input[name="attending_physician"]').value.trim(),
        services: services,
        products: products,
        services_total: servicesTotal,
        products_total: productsTotal,
        discount_amount: discountAmount,
        discount_type: discountType,
        grand_total: grandTotal,
        notes: document.querySelector('textarea[name="notes"]').value.trim() || null
    };

    // Log the exact data being sent
    console.log('Form data being sent (with types):', {
        ...formData,
        services_total_type: typeof formData.services_total,
        products_total_type: typeof formData.products_total,
        discount_amount_type: typeof formData.discount_amount,
        grand_total_type: typeof formData.grand_total
    });

    // Validate required fields and number formats
    if (!formData.patient_name || !formData.attending_physician) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill in all required fields',
        });
        return;
    }

    // Additional validation for numeric values
    if (isNaN(formData.services_total) || 
        isNaN(formData.products_total) || 
        isNaN(formData.discount_amount) || 
        isNaN(formData.grand_total)) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Invalid numeric values detected',
        });
        return;
    }

    // Show loading state
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait while we process your request',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit the data
    fetch('/charge-slips', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw {
                    status: response.status,
                    errors: err.errors || {},
                    message: err.message || 'An error occurred while saving the charge slip'
                };
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('medicalRecordModal'));
            if (modal) {
                modal.hide();
            }
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Charge slip has been saved successfully.',
                showConfirmButton: true,
                confirmButtonText: 'View Invoice',
                showCancelButton: true,
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/settings/invoice';
                } else {
                    location.reload();
                }
            });
        } else {
            throw new Error(data.message || 'Error saving charge slip');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        console.error('Full error details:', error);
        
        let errorMessage = 'There was an error saving the charge slip.';
        
        if (error.errors && Object.keys(error.errors).length > 0) {
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
        });
    });
}

// Helper functions to collect form data
function collectServices() {
    const services = [];
    document.querySelectorAll('#servicesTable tbody tr').forEach(row => {
        const select = row.querySelector('select[name="services[]"]');
        const customInput = row.querySelector('.custom-service');
        const amountInput = row.querySelector('.service-amount');
        
        if ((select.value && select.value !== '') || (customInput && !customInput.classList.contains('d-none') && customInput.value)) {
            services.push({
                description: select.value === 'custom' ? customInput.value : select.value,
                amount: parseFloat(parseFloat(amountInput.value || 0).toFixed(2))
            });
        }
    });
    return services;
}

function collectProducts() {
    const products = [];
    document.querySelectorAll('#productsTable tbody tr').forEach(row => {
        const select = row.querySelector('select[name="products[]"]');
        const customInput = row.querySelector('.custom-product');
        const qtyInput = row.querySelector('.product-qty');
        const amountInput = row.querySelector('.product-amount');
        
        if ((select.value && select.value !== '') || (customInput && !customInput.classList.contains('d-none') && customInput.value)) {
            products.push({
                item: select.value === 'custom' ? customInput.value : select.value,
                quantity: parseInt(qtyInput.value) || 0,
                amount: parseFloat(parseFloat(amountInput.value || 0).toFixed(2))
            });
        }
    });
    return products;
}

// Replace the existing cleanupModals function and event listeners with this updated version:

function cleanupModals() {
    // Remove all backdrops first
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.remove();
    });

    // Get all visible modals
    const visibleModals = Array.from(document.querySelectorAll('.modal')).filter(
        modal => modal.classList.contains('show')
    );

    if (visibleModals.length === 0) {
        // No visible modals, clean up completely
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
        document.body.style.removeProperty('overflow');
        return;
    }

    // Handle single visible modal
    if (visibleModals.length === 1) {
        const modal = visibleModals[0];
        modal.style.zIndex = '1055';
        // Create a single backdrop if needed
        if (!document.querySelector('.modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.style.zIndex = '1054';
            document.body.appendChild(backdrop);
        }
        return;
    }

    // Handle multiple modals
    visibleModals.forEach((modal, index) => {
        modal.style.zIndex = `${1055 + (index * 10)}`;
    });
}

// Add global click handler for modal triggers
document.addEventListener('click', function(e) {
    // Handle complete button
    if (e.target.closest('.btn-success')) {
        const completeBtn = e.target.closest('.btn-success');
        if (completeBtn.textContent.trim().toLowerCase().includes('complete')) {
            // Force close all modals
            document.querySelectorAll('.modal.show').forEach(modal => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            });
            
            // Remove all backdrops
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                backdrop.remove();
            });
            
            // Clean up body
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
            document.body.style.removeProperty('overflow');
            return;
        }
    }

    // Handle modal triggers
    if (e.target.closest('[data-bs-toggle="modal"]')) {
        setTimeout(cleanupModals, 10);
    }
});

// Add modal event handlers
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', () => setTimeout(cleanupModals, 10));
        modal.addEventListener('hidden.bs.modal', () => setTimeout(cleanupModals, 10));
        
        // Add click handler to close button if exists
        const closeBtn = modal.querySelector('[data-bs-dismiss="modal"]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
                setTimeout(cleanupModals, 10);
            });
        }
    });
});

// Add style to ensure proper modal display
const style = document.createElement('style');
style.textContent = `
    .modal-backdrop.show {
        opacity: 0.5;
        pointer-events: auto;
    }
    .modal {
        background: transparent !important;
    }
    .modal-dialog {
        pointer-events: auto;
    }
`;
document.head.appendChild(style);

function openDiagnosisForm() {
    // Remove any existing backdrops first
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.remove();
    });

    // Hide the charge slip modal without removing it from the DOM
    const medicalRecordModal = document.getElementById('medicalRecordModal');
    medicalRecordModal.classList.remove('show');
    medicalRecordModal.style.display = 'none';
    medicalRecordModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');

    const appointmentId = document.getElementById('appointment_id').value;
    if (!appointmentId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Could not find appointment information',
        });
        return;
    }

    // First try to get data from the complete button that opened the charge slip
    const completeBtn = document.querySelector(`.complete-btn[data-appointment*='"id":${appointmentId}']`);
    let appointmentData;
    
    if (completeBtn && completeBtn.dataset.appointment) {
        try {
            appointmentData = JSON.parse(completeBtn.dataset.appointment);
        } catch (e) {
            console.error('Error parsing appointment data from complete button:', e);
        }
    }
    
    // If not found in complete button, try table row
    if (!appointmentData) {
        const appointmentRow = document.querySelector(`tr[data-appointment*='"id":${appointmentId}']`);
        if (appointmentRow && appointmentRow.dataset.appointment) {
            try {
                appointmentData = JSON.parse(appointmentRow.dataset.appointment);
            } catch (e) {
                console.error('Error parsing appointment data from row:', e);
            }
        }
    }

    // If we still don't have the data, try to get it from the form fields
    if (!appointmentData) {
        appointmentData = {
            id: appointmentId,
            pet_id: document.getElementById('pet_id').value,
            display_name: document.getElementById('patientName').value,
            reason_for_visit: ['Consultation'] // Default reason
        };
    }

    if (!appointmentData) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Could not find appointment details',
        });
        return;
    }

    // Clean up reason_for_visit
    let reasons = appointmentData.reason_for_visit;
    if (typeof reasons === 'string') {
        try {
            reasons = JSON.parse(reasons);
        } catch (e) {
            reasons = [reasons];
        }
    }
    
    if (!Array.isArray(reasons)) {
        reasons = [reasons];
    }

    // Clean up any nested arrays or JSON strings
    reasons = reasons.map(reason => {
        if (typeof reason === 'string') {
            try {
                const parsed = JSON.parse(reason);
                return Array.isArray(parsed) ? parsed[0] : reason;
            } catch (e) {
                return reason;
            }
        }
        return reason;
    }).filter(Boolean); // Remove any null/undefined values

    if (reasons.length === 0) {
        reasons = ['Consultation']; // Default fallback
    }

    console.log('Opening diagnosis form with data:', {
        appointmentId,
        reasons
    });
    
    // Show the findings modal with the cleaned up data
    showFindingsModal(appointmentId, reasons);

    // Add event listener to handle modal cleanup when findings modal is hidden
    const findingsModal = document.getElementById('findingsModal');
    findingsModal.addEventListener('hidden.bs.modal', function () {
        // Show the charge slip modal again
        medicalRecordModal.classList.add('show');
        medicalRecordModal.style.display = 'block';
        medicalRecordModal.removeAttribute('aria-hidden');
        medicalRecordModal.setAttribute('aria-modal', 'true');
        medicalRecordModal.setAttribute('role', 'dialog');
        document.body.classList.add('modal-open');
    }, { once: true }); // Remove listener after it's triggered once

    // Add close button handler for findings modal
    const closeBtn = findingsModal.querySelector('[data-bs-dismiss="modal"]');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            findingsModal.classList.remove('show');
            findingsModal.style.display = 'none';
            findingsModal.setAttribute('aria-hidden', 'true');
            
            // Show the charge slip modal again
            medicalRecordModal.classList.add('show');
            medicalRecordModal.style.display = 'block';
            medicalRecordModal.removeAttribute('aria-hidden');
            medicalRecordModal.setAttribute('aria-modal', 'true');
            medicalRecordModal.setAttribute('role', 'dialog');
            document.body.classList.add('modal-open');
        }, { once: true });
    }
}

// Function to send appointment reminder
function sendReminder(event, appointmentId) {
    // Stop the click from propagating to the row click handler
    event.stopPropagation();
    
    // Get the button element
    const button = event.currentTarget;
    
    // Disable the button and show loading state
    button.disabled = true;
    const originalHtml = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    
    // Show confirmation dialog
    Swal.fire({
        title: 'Send Reminder?',
        text: 'An SMS reminder will be sent to the client about their upcoming appointment.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, send it',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Send AJAX request to send the reminder
            return fetch(`/appointment/${appointmentId}/send-reminder`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(json => {
                        throw new Error(json.message || 'Failed to send reminder');
                    });
                }
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error.message}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        // Reset button state
        button.disabled = false;
        button.innerHTML = originalHtml;
        
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Success!',
                text: result.value.message || 'Reminder has been sent successfully!',
                icon: 'success'
            });
        }
    });
}
</script>
@endpush

