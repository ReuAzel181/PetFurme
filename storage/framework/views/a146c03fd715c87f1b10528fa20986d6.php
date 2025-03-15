<!-- Medical Record Modal -->
<div class="modal fade" id="medicalRecordModal" tabindex="-1" role="dialog" aria-labelledby="medicalRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1200px;">
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
                                        <label class="form-label small mb-1">Pet Name</label>
                                        <input type="text" class="form-control" id="petName" name="pet_name" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label small mb-1">Description</label>
                                        <input type="text" class="form-control" id="petDescription" name="description" readonly>
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

                            <!-- Rest of the modal content remains the same -->
                            <!-- ... Services section ... -->
                            <!-- ... Products section ... -->
                            <!-- ... Summary section ... -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/appointment/partials/charge-slip-modal.blade.php ENDPATH**/ ?>