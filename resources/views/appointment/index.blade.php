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
                    <div class="d-flex gap-2">
                        <button id="deleteSelected" class="btn btn-danger d-none">
                            <i class="fas fa-trash me-2"></i>Delete Selected
                        </button>
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
                                    <th width="3%">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
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
                                        <td onclick="event.stopPropagation()">
                                            <input type="checkbox" class="form-check-input appointment-checkbox" value="{{ $appointment->id }}">
                                        </td>
                                        <td class="text-muted">
                                            #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($appointment->user && $appointment->user->photo)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($appointment->user->photo) }}" 
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
                                                    @if($appointment->pet)
                                                        @php
                                                            $photoData = null;
                                                            // Try to get photo from photo_data first
                                                            if ($appointment->pet->photo_data) {
                                                                $photoData = $appointment->pet->photo_data;
                                                            }
                                                            // If no photo_data, try to get from photo if it contains binary data
                                                            elseif ($appointment->pet->photo && strpos($appointment->pet->photo, 'data:image') === 0) {
                                                                $photoData = $appointment->pet->photo;
                                                            }
                                                        @endphp

                                                        @if($photoData)
                                                            <span class="avatar avatar-sm rounded-circle" 
                                                                  style="background-image: url('{{ $photoData }}');
                                                                         width: 32px; height: 32px; background-size: cover;">
                                                            </span>
                                                        @else
                                                            <span class="avatar avatar-sm rounded-circle" 
                                                                  style="background-image: url('{{ asset('images/default-pet.png') }}');
                                                                         width: 32px; height: 32px; background-size: cover;">
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="avatar avatar-sm rounded-circle" 
                                                              style="background-image: url('{{ asset('images/default-pet.png') }}');
                                                                     width: 32px; height: 32px; background-size: cover;">
                                                        </span>
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
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">{{ $appointment->creator->name ?? 'N/A' }}</div>
                                                <div class="text-muted small">
                                                    {{ $appointment->created_at->format('M d, Y g:i A') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($appointment->status !== 'completed')
                                                <button type="button" 
                                                        class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#medicalRecordModal"
                                                        onclick="initializeMedicalRecord({{ json_encode($appointment) }})">
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

<!-- Medical Record Modal -->
<div class="modal fade" id="medicalRecordModal" tabindex="-1" role="dialog" aria-labelledby="medicalRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1200px;">
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
                                        <label class="form-label small mb-1">Name of Patient</label>
                                        <input type="text" class="form-control" id="patientName" name="patient_name" readonly>
                                    </div>
                        </div>
                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Address</label>
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
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Services</h6>
                                <div class="table-responsive">
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
                                                            <option value="consultation" data-price="300">Consultation</option>
                                                            <option value="vaccination" data-price="800">Vaccination</option>
                                                            <option value="deworming" data-price="500">Deworming</option>
                                                            <option value="grooming" data-price="800">Grooming</option>
                                                            <option value="surgery" data-price="5000">Surgery</option>
                                                            <option value="laboratory" data-price="1500">Laboratory</option>
                                                            <option value="dental" data-price="1000">Dental Cleaning</option>
                                                            <option value="boarding" data-price="500">Boarding (per day)</option>
                                                            <option value="custom">Other Service</option>
                                                        </select>
                                                        <input type="text" class="form-control form-control-sm custom-service d-none mt-2" 
                                                               placeholder="Enter service description" name="custom_services[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text border-0 bg-transparent px-0">₱</span>
                                                        <input type="number" class="form-control form-control-sm text-end border-0 service-amount" 
                                                               name="service_amounts[]" value="0">
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
                                                    <th class="text-muted small" style="width: 50%">ITEM</th>
                                                    <th class="text-center text-muted small" style="width: 20%">QTY</th>
                                                    <th class="text-end text-muted small" style="width: 25%">AMOUNT</th>
                                                    <th style="width: 5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-select form-select-sm mb-2" name="products[]" onchange="handleProductSelection(this)">
                                                            <option value="">Select Product</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                        data-price="{{ $product->selling_price }}"
                                                                        data-stock="{{ $product->quantity }}">
                                                                    {{ $product->name }} (₱{{ number_format($product->selling_price, 2) }})
                                                                </option>
                                                            @endforeach
                                                            <option value="custom">Other Product</option>
                                                        </select>
                                                        <input type="text" class="form-control form-control-sm custom-product d-none" 
                                                               placeholder="Enter product name" name="custom_products[]">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm text-center product-qty" 
                                                               name="product_qty[]" value="1" min="1" onchange="updateProductTotal(this)">
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text border-0 bg-transparent px-0">₱</span>
                                                            <input type="number" class="form-control form-control-sm text-end border-0 product-amount" 
                                                                   name="product_amounts[]" value="0" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-link text-danger p-1" onclick="removeProductRow(this)">
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
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span class="text-muted">Total:</span>
                                            <span class="fw-medium">₱<span id="subtotal">0.00</span></span>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">Discount:</span>
                                                <div class="d-flex gap-2" style="width: 150px">
                                                    <input type="number" class="form-control form-control-sm text-end" 
                                                           id="discountAmount" name="discount_amount" value="0">
                                                    <select class="form-select form-select-sm" id="discountType" 
                                                            name="discount_type" style="width: 60px">
                                                        <option value="amount">₱</option>
                                                        <option value="percent">%</option>
                                                    </select>
                                                </div>
                                            </div>
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
        padding-top: 60px; /* Add padding to prevent header overlap */
    }

    .modal-dialog {
        margin: 1.75rem auto; /* Center horizontally */
        max-width: 95%; /* Limit width on larger screens */
    }

    @media (min-width: 992px) {
        .modal-dialog {
            max-width: 900px; /* Set max width for larger screens */
        }
    }

    .modal-content {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        margin: 0 auto; /* Center the content */
        max-height: calc(100vh - 120px); /* Prevent modal from being too tall */
        overflow-y: auto; /* Add scroll if content is too long */
    }

    .modal-body {
        padding: 1.5rem;
        position: relative;
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
        min-height: auto; /* Remove fixed height */
        max-height: calc(100vh - 250px); /* Adjust max height */
        overflow-y: auto;
        padding: 1rem;
    }
    
    .form-section .card {
        margin-bottom: 1rem;
        height: auto; /* Remove fixed height */
    }
    
    .form-section .card-body {
        height: auto; /* Remove fixed height */
        overflow-y: visible;
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

    /* Add padding to the page wrapper to prevent modal overlap */
    .page-wrapper {
        padding-bottom: 2rem;
    }

    /* Add these styles to your existing CSS */
    .modal-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-control[readonly] {
        background-color: #f8f9fa;
        opacity: 1;
    }

    /* Add to your existing styles */
    .modal-header {
        border-bottom: 0;
        padding: 1.5rem;
    }

    .modal-header .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .form-control, .form-select {
        border-color: #e5e7eb;
        background-color: #fff;
        transition: border-color 0.15s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--tblr-primary);
        box-shadow: 0 0 0 0.25rem rgba(32, 107, 196, 0.1);
    }

    .form-control-lg {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        color: #6b7280;
    }

    .btn-light {
        background-color: #f9fafb;
        border-color: #e5e7eb;
    }

    .btn-light:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    .bg-light {
        background-color: #f9fafb !important;
    }

    .text-primary {
        color: var(--tblr-primary) !important;
    }

    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    .form-label.text-muted.small {
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .input-group-text {
        color: #6b7280;
    }

    /* Update modal styles */
    .modal-dialog.modal-lg {
        max-width: 800px;
    }

    .modal-content {
        border-radius: 8px;
    }

    .modal-header {
        background-color: #0054a6 !important;
    }

    .modal-header .logo-wrapper {
        background: white;
        border-radius: 4px;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control, .form-select {
        height: 36px;
        padding: 6px 12px;
        font-size: 14px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }

    .table thead th {
        border-bottom: 1px solid #dee2e6;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .table td {
        padding: 8px 12px;
        vertical-align: middle;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 13px;
    }

    .btn-link {
        text-decoration: none;
    }

    textarea.form-control {
        min-height: 80px;
        resize: vertical;
    }

    .form-label.small {
        color: #6c757d;
        font-weight: 500;
        font-size: 12px;
    }

    /* Improve spacing and alignment */
    .modal-body {
        padding: 24px;
    }

    .row.g-4 {
        --bs-gutter-y: 1rem;
        --bs-gutter-x: 1rem;
    }

    /* Make the form more compact */
    .form-group {
        margin-bottom: 0;
    }

    /* Improve total section appearance */
    .bg-light {
        background-color: #f8f9fa !important;
    }

    #total {
        font-size: 16px;
    }

    /* Add subtle shadows */
    .modal-content {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Update modal styles */
    .logo-wrapper {
        background: white;
        border-radius: 50%;
        padding: 2px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .table tfoot tr:last-child {
        border-top: 2px solid #dee2e6;
    }

    .table tfoot td {
        padding: 12px;
    }

    .form-select {
        background-color: #fff;
    }

    .input-group-sm > .form-control,
    .input-group-sm > .form-select {
        padding: 0.4rem 0.5rem;
    }

    .service-amount,
    .service-total {
        background-color: #f8f9fa;
    }

    /* Add to your existing styles */
    .table.align-middle td {
        vertical-align: middle;
    }

    .service-amount,
    .service-total {
        background-color: transparent !important;
        font-family: monospace;
        font-size: 14px;
    }

    .input-group-sm .form-control {
        min-height: 30px;
    }

    .input-group-text.bg-transparent {
        font-family: monospace;
        font-size: 14px;
    }

    .card.shadow-sm {
        border: 1px solid rgba(0,0,0,.05);
    }

    #total {
        font-family: monospace;
        font-size: 20px;
    }

    #subtotal {
        font-family: monospace;
    }

    .form-control:read-only {
        background-color: transparent !important;
    }

    .table td {
        padding: 0.5rem;
    }

    .form-select-sm {
        min-height: 30px;
    }

    /* Improve number input appearance */
    input[type="number"] {
        -moz-appearance: textfield;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Add subtle hover effect to service rows */
    #servicesTable tbody tr:hover {
        background-color: rgba(0,0,0,.01);
    }

    /* Improve discount inputs */
    #discountAmount {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    #discountType {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: 0;
    }

    /* Add to your existing styles */
    .custom-service {
        margin-top: 0.5rem;
        background-color: #fff !important;
        border: 1px solid #dee2e6;
    }

    .service-amount {
        background-color: transparent !important;
        font-family: monospace;
        font-size: 14px;
    }

    .service-amount:not([readonly]) {
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
    }

    /* Add to your existing styles */
    .btn-link.text-danger {
        padding: 4px 8px;
        border-radius: 4px;
    }

    .btn-link.text-danger:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .btn-link.text-danger i {
        font-size: 14px;
    }

    #servicesTable tbody tr {
        transition: all 0.2s ease-in-out;
    }

    #servicesTable tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }

    /* Add to your existing styles */
    .table-responsive {
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
    }

    .table-responsive::-webkit-scrollbar {
        width: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .form-select-sm {
        min-height: 31px;
    }

    .card-body {
        position: relative;
    }

    #productsTable td {
        padding: 0.5rem;
    }

    #productsTable .form-select,
    #productsTable .form-control {
        font-size: 0.875rem;
    }

    /* Add to your existing styles */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    .modal-content {
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-body {
        padding: 2rem !important;
    }

    .card {
        border: 1px solid rgba(0,0,0,.08);
    }

    .table-responsive {
        background: #fff;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    #productsTable thead th {
        padding: 0.75rem 0.5rem;
        background: #f8f9fa;
        border-radius: 0.25rem;
    }

    .form-control, .form-select {
        padding: 0.5rem 0.75rem;
    }

    .input-group-sm > .form-control,
    .input-group-sm > .form-select {
        padding: 0.4rem 0.5rem;
    }

    /* Improve scrollbar appearance */
    .modal-content::-webkit-scrollbar,
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .modal-content::-webkit-scrollbar-thumb,
    .table-responsive::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-track,
    .table-responsive::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 4px;
    }

    /* Add subtle transitions */
    .modal.fade .modal-dialog {
        transition: transform 0.2s ease-out;
    }

    .modal.fade .modal-content {
        transition: opacity 0.2s ease-out;
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
                <span class="ms-2 badge bg-green-lt">${appointment.age_display}</span>
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

function handleServiceSelection(select) {
    const row = select.closest('tr');
    const customServiceInput = row.querySelector('.custom-service');
    const amountInput = row.querySelector('.service-amount');
    const selectedOption = select.options[select.selectedIndex];
    
    if (select.value === 'custom') {
        customServiceInput.classList.remove('d-none');
        amountInput.readOnly = false;
        amountInput.value = '0';
    } else {
        customServiceInput.classList.add('d-none');
        customServiceInput.value = '';
        amountInput.readOnly = true;
        if (selectedOption.dataset.price) {
            amountInput.value = selectedOption.dataset.price;
        } else {
            amountInput.value = '0';
        }
    }
    
    updateTotals();
}

function addServiceRow() {
    const tbody = document.querySelector('#servicesTable tbody');
    const firstRow = tbody.querySelector('tr');
    const newRow = firstRow.cloneNode(true);
    
    // Reset values in the new row
    newRow.querySelectorAll('select, input').forEach(input => {
        input.value = '';
        if (input.classList.contains('service-amount')) {
            input.value = '0';
        }
        if (input.classList.contains('custom-service')) {
            input.classList.add('d-none');
        }
    });
    
    tbody.appendChild(newRow);
    updateTotals();
}

function updateTotals() {
    let servicesSubtotal = 0;
    let productsSubtotal = 0;

    // Calculate services subtotal
    document.querySelectorAll('.service-amount').forEach(input => {
        servicesSubtotal += parseFloat(input.value || 0);
    });
    
    // Calculate products subtotal
    document.querySelectorAll('.product-amount').forEach(input => {
        productsSubtotal += parseFloat(input.value || 0);
    });
    
    // Update subtotals display
    document.getElementById('servicesSubtotal').textContent = servicesSubtotal.toFixed(2);
    document.getElementById('productsSubtotal').textContent = productsSubtotal.toFixed(2);
    
    const subtotal = servicesSubtotal + productsSubtotal;
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);

    // Calculate discount
    const discountAmount = parseFloat(document.getElementById('discountAmount').value || 0);
    const discountType = document.getElementById('discountType').value;
    let discount = 0;

    if (discountType === 'percent') {
        discount = subtotal * (discountAmount / 100);
    } else {
        discount = discountAmount;
    }

    // Calculate and update total
    const total = subtotal - discount;
    document.getElementById('total').textContent = `₱${total.toFixed(2)}`;
}

// Add event listeners for discount changes
document.getElementById('discountAmount').addEventListener('input', updateTotals);
document.getElementById('discountType').addEventListener('change', updateTotals);

function initializeMedicalRecord(appointment) {
    // Set appointment details in the form
    document.getElementById('appointment_id').value = appointment.id;
    document.getElementById('pet_id').value = appointment.pet_id;

    // Set patient name (owner's name)
    document.getElementById('patientName').value = appointment.display_name;

    // Reset form sections
    document.getElementById('medicalRecordForm').reset();
    
    // Keep the patient name after form reset
    document.getElementById('patientName').value = appointment.display_name;
    
    // Initialize invoice number
    document.getElementById('invoiceNumber').textContent = generateInvoiceNumber();
    
    // Reset services table to initial state
    const tbody = document.querySelector('#servicesTable tbody');
    while (tbody.rows.length > 1) {
        tbody.deleteRow(1);
    }
    tbody.rows[0].querySelectorAll('input, select').forEach(input => input.value = '');
    
    // Reset products table to initial state
    const productsTbody = document.querySelector('#productsTable tbody');
    while (productsTbody.rows.length > 1) {
        productsTbody.deleteRow(1);
    }
    productsTbody.rows[0].querySelectorAll('input, select').forEach(input => input.value = '');
    
    // Reset totals
    updateTotals();
}

function generateInvoiceNumber() {
    // Generate a random 7-digit number
    return String(Math.floor(Math.random() * 9000000) + 1000000).padStart(7, '0'));
}

function saveMedicalRecord() {
    const form = document.getElementById('medicalRecordForm');
    const formData = new FormData(form);

    // Show loading state
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait while we save the medical record',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit the form
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
                // Close modal and refresh page
                bootstrap.Modal.getInstance(document.getElementById('medicalRecordModal')).hide();
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

function removeServiceRow(button) {
    const tbody = document.querySelector('#servicesTable tbody');
    if (tbody.rows.length > 1) {
        // Remove the row
        const row = button.closest('tr');
        row.remove();
        // Update totals after removing the row
        updateTotals();
    } else {
        // If it's the last row, just clear the values
        const row = button.closest('tr');
        row.querySelector('select').value = '';
        row.querySelector('.service-amount').value = '0';
        const customService = row.querySelector('.custom-service');
        if (customService) {
            customService.value = '';
            customService.classList.add('d-none');
        }
        updateTotals();
    }
}

function handleProductSelection(select) {
    const row = select.closest('tr');
    const customProductInput = row.querySelector('.custom-product');
    const amountInput = row.querySelector('.product-amount');
    const selectedOption = select.options[select.selectedIndex];
    
    if (select.value === 'custom') {
        customProductInput.classList.remove('d-none');
        amountInput.readOnly = false;
        amountInput.value = '0';
    } else {
        customProductInput.classList.add('d-none');
        customProductInput.value = '';
        amountInput.readOnly = true;
        if (selectedOption.dataset.price) {
            amountInput.value = selectedOption.dataset.price;
        } else {
            amountInput.value = '0';
        }
    }
    
    updateProductTotal(row.querySelector('.product-qty'));
}

function updateProductTotal(input) {
    const row = input.closest('tr');
    const amountInput = row.querySelector('.product-amount');
    const qty = parseInt(input.value) || 1;
    const unitPrice = parseFloat(amountInput.value) || 0;
    
    amountInput.value = (qty * unitPrice).toFixed(2);
    updateTotals();
}

function addProductRow() {
    const tbody = document.querySelector('#productsTable tbody');
    const firstRow = tbody.querySelector('tr');
    const newRow = firstRow.cloneNode(true);
    
    newRow.querySelectorAll('select, input').forEach(input => {
        input.value = input.type === 'number' && input.classList.contains('product-qty') ? '1' : '';
        if (input.classList.contains('product-amount')) {
            input.value = '0';
        }
        if (input.classList.contains('custom-product')) {
            input.classList.add('d-none');
        }
    });
    
    tbody.appendChild(newRow);
    updateTotals();
}

function removeProductRow(button) {
    const tbody = document.querySelector('#productsTable tbody');
    if (tbody.rows.length > 1) {
        button.closest('tr').remove();
    } else {
        const row = button.closest('tr');
        row.querySelectorAll('select, input').forEach(input => {
            input.value = input.type === 'number' && input.classList.contains('product-qty') ? '1' : '';
            if (input.classList.contains('product-amount')) {
                input.value = '0';
            }
        });
    }
    updateTotals();
}

function printChargeSlip() {
    // Update printable version with current values
    document.getElementById('printInvoiceNumber').textContent = document.getElementById('invoiceNumber').textContent;
    document.getElementById('printPatientName').textContent = document.getElementById('patientName').value;
    document.getElementById('printAddress').textContent = document.querySelector('input[name="address"]').value;
    document.getElementById('printPhysician').textContent = document.querySelector('input[name="attending_physician"]').value;
    document.getElementById('printNotes').textContent = document.querySelector('textarea[name="notes"]').value;

    // Copy services
    const printServicesBody = document.querySelector('#printServicesTable tbody');
    printServicesBody.innerHTML = '';
    document.querySelectorAll('#servicesTable tbody tr').forEach(row => {
        const service = row.querySelector('select').selectedOptions[0].text;
        const amount = row.querySelector('.service-amount').value;
        if (service && amount > 0) {
            const newRow = `<tr>
                <td>${service}</td>
                <td class="text-end">₱${parseFloat(amount).toFixed(2)}</td>
            </tr>`;
            printServicesBody.insertAdjacentHTML('beforeend', newRow);
        }
    });

    // Copy products
    const printProductsBody = document.querySelector('#printProductsTable tbody');
    printProductsBody.innerHTML = '';
    document.querySelectorAll('#productsTable tbody tr').forEach(row => {
        const product = row.querySelector('select').selectedOptions[0].text;
        const qty = row.querySelector('.product-qty').value;
        const amount = row.querySelector('.product-amount').value;
        if (product && amount > 0) {
            const price = parseFloat(amount) / parseInt(qty);
            const newRow = `<tr>
                <td>${product}</td>
                <td class="text-center">${qty}</td>
                <td class="text-end">₱${price.toFixed(2)}</td>
                <td class="text-end">₱${parseFloat(amount).toFixed(2)}</td>
            </tr>`;
            printProductsBody.insertAdjacentHTML('beforeend', newRow);
        }
    });

    // Copy totals
    document.getElementById('printServicesSubtotal').textContent = document.getElementById('servicesSubtotal').textContent;
    document.getElementById('printProductsSubtotal').textContent = document.getElementById('productsSubtotal').textContent;
    document.getElementById('printDiscount').textContent = document.getElementById('discountAmount').value;
    document.getElementById('printTotal').textContent = document.getElementById('total').textContent.replace('₱', '');

    // Print the document
    const printContent = document.getElementById('printableArea').innerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = `
        <style>
            @media print {
                body { font-size: 12px; }
                .invoice-header { margin-bottom: 30px; }
                table { width: 100%; }
                th, td { padding: 5px; }
                .footer-section { margin-top: 50px; }
            }
        </style>
        ${printContent}
    `;

    window.print();
    document.body.innerHTML = originalContent;
    
    // Reinitialize any necessary event listeners
    initializeEventListeners();
}

// Add this to your existing scripts
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const deleteSelected = document.getElementById('deleteSelected');
    const checkboxes = document.querySelectorAll('.appointment-checkbox');

    // Handle "Select All" checkbox
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButton();
    });

    // Handle individual checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateDeleteButton();
            // Update "Select All" checkbox state
            selectAll.checked = [...checkboxes].every(c => c.checked);
        });
    });

    // Update delete button visibility
    function updateDeleteButton() {
        const checkedCount = [...checkboxes].filter(c => c.checked).length;
        if (checkedCount > 0) {
            deleteSelected.classList.remove('d-none');
            deleteSelected.textContent = `Delete Selected (${checkedCount})`;
        } else {
            deleteSelected.classList.add('d-none');
        }
    }

    // Handle delete selected
    deleteSelected.addEventListener('click', function() {
        const selectedIds = [...checkboxes]
            .filter(c => c.checked)
            .map(c => c.value);

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${selectedIds.length} appointment(s).`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit delete request
                fetch('{{ route("appointment.deleteMultiple") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            'Selected appointments have been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        error.message || 'Something went wrong.',
                        'error'
                    );
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Handle status update forms
    document.querySelectorAll('.status-update-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const appointment_id = this.action.split('/').pop();
            const newStatus = formData.get('status');
            const statusButton = this.closest('.dropdown').querySelector('.btn');
            const dropdownContainer = this.closest('.dropdown');
            
            fetch(this.action, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    statusButton.className = `btn btn-sm ${
                        newStatus === 'confirmed' ? 'btn-success' : 
                        newStatus === 'cancelled' ? 'btn-danger' : 
                        'btn-warning'
                    } dropdown-toggle`;
                    
                    statusButton.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                    // Add confirmation details if status is confirmed
                    if (newStatus === 'confirmed') {
                        const actions = JSON.parse(data.appointment.actions);
                        const confirmationDetails = `
                            <div class="mt-1">
                                <small class="text-muted">
                                    Confirmed by: ${actions.confirmer_name}
                                    <br>
                                    <span class="text-muted">${moment(actions.confirmed_at).format('MMM DD, YYYY h:mm A')}</span>
                                </small>
                            </div>
                        `;
                        // Find or create container for confirmation details
                        let detailsContainer = dropdownContainer.nextElementSibling;
                        if (!detailsContainer || !detailsContainer.classList.contains('mt-1')) {
                            detailsContainer = document.createElement('div');
                            dropdownContainer.parentNode.insertBefore(detailsContainer, dropdownContainer.nextSibling);
                        }
                        detailsContainer.outerHTML = confirmationDetails;
                    }

                    // Update dropdown options
                    const dropdownMenu = this.closest('.dropdown-menu');
                    dropdownMenu.innerHTML = '';
                    
                    if (newStatus !== 'confirmed') {
                        dropdownMenu.innerHTML += `
                            <li>
                                <form action="/appointments/${appointment_id}/status" method="POST" class="status-update-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="dropdown-item text-success">
                                        <i class="fas fa-check me-2"></i>Confirm
                                    </button>
                                </form>
                            </li>
                        `;
                    }
                    
                    if (newStatus !== 'cancelled') {
                        dropdownMenu.innerHTML += `
                            <li>
                                <form action="/appointments/${appointment_id}/status" method="POST" class="status-update-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </button>
                                </form>
                            </li>
                        `;
                    }

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to update status'
                });
            });
        });
    });
});
</script>
@endpush
