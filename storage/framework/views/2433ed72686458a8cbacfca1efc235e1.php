<?php $__env->startSection('content'); ?>
<div class="page">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    <?php echo $__env->make('partials._page_header', [
                        'title' => __('Edit Appointment'),
                        'section' => 'APPOINTMENT'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('appointment.update', $appointment->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Pet Owner Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pet Owner</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">Select Pet Owner</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e($appointment->user_id == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Pet Selection -->
                        <div class="mb-3" id="pet_selection_group">
                            <label for="pet_id" class="form-label">Select Pet</label>
                            <select name="pet_id" id="pet_id" class="form-select" required>
                                <option value="">Choose a pet</option>
                                <?php if($appointment->pet_id): ?>
                                    <option value="<?php echo e($appointment->pet_id); ?>" selected>
                                        <?php echo e($appointment->pet_name); ?>

                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Pet Details -->
                        <div id="pet_details">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pet_name" class="form-label">Pet Name</label>
                                    <input type="text" id="pet_name" class="form-control" value="<?php echo e($appointment->pet_name); ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_type" class="form-label">Pet Type</label>
                                    <input type="text" id="pet_type" class="form-control" value="<?php echo e($appointment->pet_type); ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_breed" class="form-label">Pet Breed</label>
                                    <input type="text" id="pet_breed" class="form-control" value="<?php echo e($appointment->pet_breed); ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_age" class="form-label">Pet Age</label>
                                    <input type="text" id="pet_age" name="pet_age" class="form-control" value="<?php echo e($appointment->pet_age); ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_weight" class="form-label">Pet Weight</label>
                                    <input type="text" id="pet_weight" name="pet_weight" class="form-control" value="<?php echo e($appointment->pet_weight); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Timing -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" 
                                       class="form-control" value="<?php echo e($appointment->appointment_date->format('Y-m-d')); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Time</label>
                                <input type="time" name="appointment_time" id="appointment_time" 
                                       class="form-control" value="<?php echo e($appointment->appointment_time); ?>" required>
                            </div>
                        </div>

                        <!-- Reasons for Visit -->
                        <div class="mb-3">
                            <label class="form-label">Reasons for Visit</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                    $selectedReasons = $appointment->reason_for_visit;
                                ?>
                                <button type="button" class="btn <?php echo e(in_array('Check-up', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary'); ?> reason-btn" data-reason="Routine Check-up">
                                    Routine Check-up
                                </button>
                                <button type="button" class="btn <?php echo e(in_array('Vaccination', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary'); ?> reason-btn" data-reason="Vaccination">
                                    Vaccination
                                </button>
                                <button type="button" class="btn <?php echo e(in_array('Emergency', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary'); ?> reason-btn" data-reason="Emergency">
                                    Emergency
                                </button>
                                <button type="button" class="btn <?php echo e(in_array('Grooming', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary'); ?> reason-btn" data-reason="Grooming">
                                    Grooming
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="other-reason-btn">
                                    Other
                                </button>
                            </div>

                            <input type="hidden" name="reason_for_visit" id="reason_for_visit" value="<?php echo e(json_encode($appointment->reason_for_visit)); ?>" required>

                            <!-- Selected Reasons Display -->
                            <div class="mt-3">
                                <label class="form-label">Selected Reasons:</label>
                                <div id="selected-reasons" class="d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $selectedReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="badge bg-primary d-flex align-items-center gap-2 p-2">
                                            <?php echo e($reason); ?>

                                            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Other Reason Input -->
                            <div class="mb-3" id="other_reason_group" style="display: none;">
                                <label for="other_reason" class="form-label">Specify Other Reason</label>
                                <div class="input-group">
                                    <input type="text" id="other_reason" class="form-control" value="<?php echo e($appointment->other_reason); ?>">
                                    <button type="button" class="btn btn-primary" id="add-other-reason">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Save Appointment</button>
                            <a href="<?php echo e(route('appointment.index')); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('user_id');
    const petSelect = document.getElementById('pet_id');
    const selectedReasons = new Set();
    const reasonButtons = document.querySelectorAll('.reason-btn');
    const otherReasonBtn = document.getElementById('other-reason-btn');
    const otherReasonGroup = document.getElementById('other_reason_group');
    const otherReasonInput = document.getElementById('other_reason');
    const addOtherReasonBtn = document.getElementById('add-other-reason');
    const selectedReasonsContainer = document.getElementById('selected-reasons');
    const reasonForVisitInput = document.getElementById('reason_for_visit');

    // Function to clear pet details
    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_type').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
    }

    // Function to update pet details
    function updatePetDetails(pet) {
        document.getElementById('pet_name').value = pet.name || '';
        document.getElementById('pet_type').value = pet.category || '';
        document.getElementById('pet_breed').value = pet.breed || '';
        document.getElementById('pet_age').value = pet.age || '';
        document.getElementById('pet_weight').value = pet.weight || '';
    }

    // Handle Pet Owner Selection
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();
        
        if (!userId) {
            petSelect.innerHTML = '<option value="">Choose a pet</option>';
            return;
        }

        // Check if the selected user matches the appointment's user
        if (userId == <?php echo e($appointment->user_id); ?>) {
            // Set the initial pet details
            const initialPet = {
                id: <?php echo e($appointment->pet_id); ?>,
                name: '<?php echo e($appointment->pet_name); ?>',
                category: '<?php echo e($appointment->pet_type); ?>',
                breed: '<?php echo e($appointment->pet_breed); ?>',
                age: '<?php echo e($appointment->pet_age); ?>',
                weight: '<?php echo e($appointment->pet_weight); ?>'
            };
            updatePetDetails(initialPet);
            petSelect.innerHTML = '<option value="<?php echo e($appointment->pet_id); ?>" selected><?php echo e($appointment->pet_name); ?></option>';
        } else {
            // Fetch pets for the selected user
            fetch(`/api/users/${userId}/pets`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    petSelect.innerHTML = '<option value="">Choose a pet</option>';
                    
                    if (Array.isArray(data.pets) && data.pets.length > 0) {
                        data.pets.forEach(pet => {
                            const option = document.createElement('option');
                            option.value = pet.id;
                            option.text = pet.name;
                            option.dataset.pet = JSON.stringify(pet);
                            petSelect.appendChild(option);
                        });
                    } else {
                        petSelect.innerHTML = '<option value="">No pets found</option>';
                        clearPetDetails();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    petSelect.innerHTML = '<option value="">Error loading pets</option>';
                    clearPetDetails();
                });
        }
    });

    // Handle Pet Selection
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!this.value) {
            clearPetDetails();
            return;
        }
        
        const pet = JSON.parse(selectedOption.dataset.pet);
        updatePetDetails(pet);
    });

    // Function to update the hidden input with selected reasons
    function updateReasonInput() {
        reasonForVisitInput.value = JSON.stringify(Array.from(selectedReasons));
    }

    // Initialize existing reasons
    let initialReasons = <?php echo json_encode($selectedReasons, 15, 512) ?>;
    initialReasons.forEach(reason => {
        if (reason && reason.trim()) {
            const trimmedReason = reason.trim();
            selectedReasons.add(trimmedReason);
            const button = document.querySelector(`.reason-btn[data-reason="${trimmedReason}"]`);
            if (button) {
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');
            }
        }
    });
    updateReasonInput();

    // Handle reason button clicks
    reasonButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reason = this.dataset.reason;
            
            if (selectedReasons.has(reason)) {
                selectedReasons.delete(reason);
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline-primary');
                
                const badge = selectedReasonsContainer.querySelector(`[data-reason="${reason}"]`);
                if (badge) badge.remove();
            } else {
                selectedReasons.add(reason);
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                
                const badge = createReasonBadge(reason);
                badge.dataset.reason = reason;
                selectedReasonsContainer.appendChild(badge);
            }
            
            updateReasonInput();
        });
    });

    // Handle "Other" reason
    otherReasonBtn.addEventListener('click', function() {
        otherReasonGroup.style.display = otherReasonGroup.style.display === 'none' ? 'block' : 'none';
    });

    // Handle adding custom reason
    addOtherReasonBtn.addEventListener('click', function() {
        const customReason = otherReasonInput.value.trim();
        if (customReason) {
            if (!selectedReasons.has(customReason)) {
                selectedReasons.add(customReason);
                const badge = createReasonBadge(customReason);
                badge.dataset.reason = customReason;
                selectedReasonsContainer.appendChild(badge);
                updateReasonInput();
            }
            otherReasonInput.value = '';
            otherReasonGroup.style.display = 'none';
        }
    });

    // Allow Enter key to add custom reason
    otherReasonInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addOtherReasonBtn.click();
        }
    });

    // Initialize pet details and selected user
    userSelect.value = <?php echo e($appointment->user_id); ?>;
    userSelect.dispatchEvent(new Event('change'));
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/appointment/edit.blade.php ENDPATH**/ ?>