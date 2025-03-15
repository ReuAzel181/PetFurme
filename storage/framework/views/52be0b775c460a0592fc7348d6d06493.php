<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <?php echo e($showArchived ? __('Archived Appointments') : __('Appointments')); ?>

                    </h2>
                    <div class="text-muted mt-1">Manage appointment schedules</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('appointment.create')); ?>" class="btn btn-success">
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
                                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="cursor: pointer" 
                                        data-appointment="<?php echo e(htmlspecialchars(json_encode($appointment), ENT_QUOTES, 'UTF-8')); ?>"
                                        class="appointment-row">
                                        <td class="text-muted">
                                            #<?php echo e(str_pad($appointment->id, 5, '0', STR_PAD_LEFT)); ?>

                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <?php if($appointment->user): ?>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php
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
                                                        ?>

                                                        <?php if($userImage): ?>
                                                            <img src="<?php echo e($userImage); ?>" 
                                                                 alt="<?php echo e($appointment->user->name); ?>" 
                                                                 class="avatar avatar-sm rounded-circle"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                                <?php echo e(strtoupper(substr($appointment->user->name, 0, 1))); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                        <div class="text-dark fw-bold"><?php echo e($appointment->user->name); ?></div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($appointment->is_walk_in): ?>
                                                    <span class="badge bg-yellow-lt" title="Walk-in appointment">
                                                        <i class="fas fa-walking me-1"></i>Walk-in
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-azure-lt" title="Registered user">
                                                        <i class="fas fa-user-check me-1"></i>Registered
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php if($appointment->pet): ?>
                                                        <?php
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
                                                        ?>

                                                        <?php if($petImage): ?>
                                                            <img src="<?php echo e($petImage); ?>" 
                                                                 alt="<?php echo e($appointment->pet_name); ?>" 
                                                                 class="avatar avatar-sm rounded-circle"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('images/default-pet.png')); ?>" 
                                                                 alt="Default Pet" 
                                                                 class="avatar avatar-sm rounded-circle"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div class="text-dark"><?php echo e($appointment->pet_name); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-muted small">
                                                    <span class="badge bg-blue-lt"><?php echo e($appointment->pet_type); ?></span>
                                                    <span class="ms-2 badge bg-green-lt"><?php echo e($appointment->age_display); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">
                                                    <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date_display)->format('M d, Y')); ?>

                                                </div>
                                                <div class="text-muted small">
                                                    <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <?php $__empty_2 = true; $__currentLoopData = $appointment->reason_for_visit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <span class="badge bg-primary-lt"><?php echo e($reason); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                    <span class="text-muted">No reasons specified</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm <?php echo e($appointment->status === 'pending' ? 'btn-warning' : 
                                                    ($appointment->status === 'confirmed' ? 'btn-success' : 
                                                    ($appointment->status === 'cancelled' ? 'btn-danger' : 'btn-secondary'))); ?> dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false"
                                                        onclick="event.stopPropagation()">
                                                    <?php echo e(ucfirst($appointment->status)); ?>

                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($appointment->status !== 'confirmed'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('appointment.updateStatus', $appointment->id)); ?>" 
                                                                  method="POST" 
                                                                  class="status-update-form">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check me-2"></i>Confirm
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($appointment->status !== 'cancelled'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('appointment.updateStatus', $appointment->id)); ?>" 
                                                                  method="POST" 
                                                                  class="status-update-form">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times me-2"></i>Cancel
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <?php if($appointment->status === 'confirmed' && $appointment->actions): ?>
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <?php
                                                            $actions = json_decode($appointment->actions, true);
                                                        ?>
                                                        <?php if($actions && isset($actions['confirmer_name'])): ?>
                                                            Confirmed by: <?php echo e($actions['confirmer_name']); ?>

                                                            <br>
                                                            <span class="text-muted"><?php echo e(\Carbon\Carbon::parse($actions['confirmed_at'])->format('M d, Y g:i A')); ?></span>
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark"><?php echo e($appointment->creator->name ?? 'N/A'); ?></div>
                                                <div class="text-muted small">
                                                    <?php echo e($appointment->created_at->format('M d, Y g:i A')); ?>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($appointment->status !== 'completed'): ?>
                                                <?php
                                                    // Convert the appointment to an array and remove any circular references
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
                                                ?>
                                                <button type="button" 
                                                        class="btn btn-primary btn-sm complete-btn"
                                                        data-appointment='<?php echo e(json_encode($appointmentData)); ?>'>
                                                    <i class="fas fa-clipboard-check me-1"></i>
                                                    Complete
                                                </button>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Done
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <?php if($appointment->status === 'pending'): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('confirm-appointments')): ?>
                                                        <form action="<?php echo e(route('appointment.confirm', $appointment->id)); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="btn btn-icon btn-success" title="Confirm Appointment">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M5 12l5 5l10 -10"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                                <?php if(in_array($appointment->status, ['pending', 'confirmed'])): ?>
                                                    <a href="<?php echo e(route('appointment.edit', $appointment->id)); ?>" class="btn btn-icon btn-warning" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <form action="<?php echo e(route('appointment.destroy', $appointment->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                                <?php endif; ?>
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
                        <img src="<?php echo e(asset('storage/defaults/vc_logo.png')); ?>" alt="VetCare Logo" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
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
                    <?php echo csrf_field(); ?>
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
                                    <div class="text-muted small">Date: <?php echo e(now()->format('F d, Y')); ?></div>
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
                                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($product->id); ?>" 
                                                                        data-stock="<?php echo e($product->quantity); ?>">
                                                                    <?php echo e($product->name); ?> (₱<?php echo e(number_format($product->selling_price * 100, 2)); ?>)
                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <img src="<?php echo e(asset('storage/defaults/vc_logo.png')); ?>" alt="VetCare Logo" class="mb-2" style="width: 60px;">
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
            <p class="mb-1"><strong>Date:</strong> <?php echo e(now()->format('F d, Y')); ?></p>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Removed unnecessary custom logic for "reason for visit"
    // If additional interactive functionality is required, 
    // add it here in a streamlined way.
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-styles'); ?>
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
        height: auto;
        max-height: none;
        overflow-y: visible;
        padding: 1.5rem;
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
    .modal-dialog.modal-xl {
        max-width: 1300px;
        width: 95%;
        margin: 1.75rem auto;
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
    .input-group-sm > .form-select,
    .input-group-sm > .input-group-text {
        min-width: 60px;
        text-align: right;
    }
    
    .input-group-text.border-0 {
        padding: 0.375rem 0.5rem;
        display: flex;
        align-items: center;
        height: 100%;
    }

    .input-group > .input-group-text {
        display: flex;
        align-items: center;
    }

    /* Ensure input groups maintain proper height */
    .input-group {
        align-items: center;
        height: 36px;
    }

    /* Adjust amount input padding to accommodate the peso symbol */
    .service-amount,
    .product-amount {
        padding-left: 1.5rem !important;
    }

    /* Position the peso symbol absolutely within the input group */
    .input-group.has-peso {
        position: relative;
    }

    /* Ensure input fields have proper width for numbers */
    .input-group.has-peso {
        position: relative;
        min-width: 120px; /* Set minimum width */
    }
    
    /* Make amount inputs wider to prevent number cutoff */
    .service-amount,
    .product-amount {
        padding-left: 1.5rem !important;
        min-width: 100px; /* Minimum width for number inputs */
    }
    
    /* Update the peso symbol positioning */
    .input-group-text.bg-transparent {
        position: absolute;
        z-index: 4;
        background: transparent !important;
        border: none;
        height: 100%;
        display: flex;
        align-items: center;
        padding-left: 0.75rem;
        margin-top: 0; /* Ensure vertical alignment */
    }
    
    /* Make sure the remove buttons have enough space */
    .btn-sm.btn-link.text-danger {
        padding: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        min-height: 28px;
    }

    /* Fix field alignment in product table */
    #productsTable th, #productsTable td {
        padding: 0.5rem;
        vertical-align: middle;
    }
    
    /* Make quantity input wider */
    .product-qty {
        min-width: 70px;
        width: 100%;
    }
    
    /* Ensure consistent spacing */
    #productsTable tr {
        display: table-row;
    }
    
    #productsTable td {
        display: table-cell;
    }
    
    /* Align amount column to the right */
    #productsTable th:nth-child(3), 
    #productsTable td:nth-child(3) {
        text-align: right;
    }
    
    /* Ensure service table has matching alignment */
    #servicesTable th, #servicesTable td {
        padding: 0.5rem;
        vertical-align: middle;
    }

    /* Fixed width columns to prevent shifting */
    #productsTable {
        table-layout: fixed;
        width: 100%;
    }
    
    /* Ensure product table cells maintain fixed width */
    #productsTable th:nth-child(1), 
    #productsTable td:nth-child(1) {
        width: 45%;
    }
    
    #productsTable th:nth-child(2), 
    #productsTable td:nth-child(2) {
        width: 20%;
        text-align: center;
    }
    
    #productsTable th:nth-child(3), 
    #productsTable td:nth-child(3) {
        width: 25%;
        text-align: right;
    }
    
    /* Fix action buttons position */
    .delete-product-btn {
        position: relative;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Fix product qty input to prevent layout shifts */
    .product-qty {
        width: 70px;
        min-width: 70px;
        text-align: center;
    }

    /* Ensure all form elements in product table are aligned */
    #productsTable .form-select,
    #productsTable .form-control,
    #productsTable .input-group {
        margin-bottom: 0 !important;
        height: 36px !important;
    }
    
    /* Remove extra margin from the select dropdown that's causing misalignment */
    #productsTable .form-select-sm.mb-2 {
        margin-bottom: 0 !important;
        vertical-align: middle;
    }
    
    /* Make sure all cells are vertically aligned */
    #productsTable td {
        vertical-align: middle !important;
        padding: 0.5rem;
    }
    
    /* Ensure consistent sizing for all input elements */
    #productsTable input,
    #productsTable select {
        height: 36px !important;
        line-height: 1.5;
        box-sizing: border-box;
    }

    /* Center the peso symbol */
    .input-group-text.bg-transparent {
        position: absolute;
        z-index: 4;
        background: transparent !important;
        border: none;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        padding: 0;
        left: 0;
        text-align: center;
    }
    
    /* Center percentage symbol in dropdown */
    #discountType {
        text-align: center;
        padding-left: 0;
        padding-right: 0;
    }

    /* Make services table scrollable */
    #servicesTable {
        width: 100%;
        margin-bottom: 0;
        table-layout: fixed;
    }
    
    /* Ensure table cells have proper width */
    #servicesTable th, 
    #servicesTable td {
        vertical-align: middle;
    }
    
    /* Fix tbody display to not be a block element */
    #servicesTable tbody {
        display: table-row-group; /* Reset to default table display */
    }
    
    /* Fix header position */
    #servicesTable thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1;
        display: table-header-group;
    }
    
    /* Ensure consistent styling for table footer */
    #servicesTable tfoot {
        display: table-footer-group;
    }
    
    /* Remove unnecessary flex properties that may affect layout */
    .services-section {
        height: auto;
        display: block;
    }
    
    /* Ensure table cells have proper width */
    #servicesTable th, 
    #servicesTable td {
        vertical-align: middle;
    }

    /* Fix modal to have a consistent height without scrolling */
    .modal-dialog.modal-xl {
        max-width: 1300px;
        width: 95%;
        margin: 1.75rem auto;
    }
    
    /* Remove scrolling from modal body */
    .modal-body {
        overflow-y: initial !important;
        height: auto !important;
        padding: 1rem !important;
    }
    
    /* Make only the services container scrollable */
    .services-table-container {
        height: 220px !important; /* Reduced from 300px */
        max-height: 220px !important;
        overflow-y: auto;
        overflow-x: hidden;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 0.25rem;
    }
    
    /* Ensure tables inside the scrollable container work properly */
    .services-table-container #servicesTable {
        margin-bottom: 0;
    }
    
    /* Fix services section layout */
    .services-section {
        display: block;
        height: auto;
    }
    
    /* Keep the header at the top when scrolling */
    #servicesTable thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 2;
    }

    /* Reduce products section height */
    #productsTable {
        margin-bottom: 0;
    }
    
    /* Reduce products container height */
    .table-responsive[style*="max-height: 400px"] {
        max-height: 220px !important; /* Reduced from 400px */
    }
    
    /* Reduce spacing in form sections */
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('page-scripts'); ?>
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

function handleCompleteClick(appointment) {
    console.log('HandleCompleteClick called with:', appointment);
    
    // Show the modal first
    const modalElement = document.getElementById('medicalRecordModal');
    if (!modalElement) {
        console.error('Modal element not found!');
        return;
    }
    
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    
    // Then try to initialize with appointment data
    try {
        initializeMedicalRecord(appointment);
    } catch (error) {
        console.error('Error in initializeMedicalRecord:', error);
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
                
                handleCompleteClick(appointment);
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
    <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
            text: "<?php echo e(session('success')); ?>",
            toast: true,
            position: 'top-end',
                showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    <?php endif; ?>

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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/appointment/index.blade.php ENDPATH**/ ?>