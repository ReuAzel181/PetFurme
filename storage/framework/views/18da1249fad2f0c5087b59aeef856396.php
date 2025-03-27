<?php $__env->startSection('content'); ?>
<div class="container-xl">
    <!-- Page Header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pet Management
                    </h2>
                    <div class="text-muted mt-1">Manage and track all pets</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?php echo e(route('pets.create')); ?>" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14" /><path d="M5 12l14 0" />
                            </svg>
                            Add New Pet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="page-body">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                    <li class="nav-item">
                        <a href="#verified" class="nav-link active" data-bs-toggle="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                            Verified Pets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#pending" class="nav-link position-relative" data-bs-toggle="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            Pending Verification
                            <?php if($pendingPets->isNotEmpty()): ?>
                                <span class="badge bg-red badge-notification badge-pill position-absolute top-0 start-100 translate-middle">
                                    <?php echo e($pendingPets->count()); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Verified Pets Tab -->
                    <div class="tab-pane active show" id="verified">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="pet-filter" id="all-pets" checked>
                                <label class="btn btn-outline-primary" for="all-pets">
                                    All Pets
                                </label>
                                
                                <input type="radio" class="btn-check" name="pet-filter" id="admin-added">
                                <label class="btn btn-outline-primary" for="admin-added">
                                    Added by Staff
                                </label>
                                
                                <input type="radio" class="btn-check" name="pet-filter" id="owner-added">
                                <label class="btn btn-outline-primary" for="owner-added">
                                    Added by Owners
                                </label>
                            </div>
                        </div>

                        <?php if($verifiedPets->isEmpty()): ?>
                            <div class="empty">
                                <div class="empty-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sad" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 10l.01 0" />
                                        <path d="M15 10l.01 0" />
                                        <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                                    </svg>
                                </div>
                                <p class="empty-title">No verified pets found</p>
                                <p class="empty-subtitle text-muted">
                                    Start by verifying some pets from the Pending Verification tab
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Pet Details</th>
                                            <th>Owner</th>
                                            <th>Category</th>
                                            <th>Verified By</th>
                                            <th>Status</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $verifiedPets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="pet-row <?php echo e(isset($pet['created_by']) && $pet['created_by'] ? 'admin-created' : 'owner-created'); ?>">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="avatar avatar-md me-2" style="background-image: url(<?php echo e($pet['photo_url']); ?>)"></span>
                                                        <div>
                                                            <div class="font-weight-medium"><?php echo e($pet['name']); ?></div>
                                                            <div class="text-muted"><?php echo e($pet['breed']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><?php echo e($pet['owner']['name']); ?></div>
                                                    <?php if(isset($pet['owner']['email'])): ?>
                                                        <div class="text-muted"><?php echo e($pet['owner']['email']); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($pet['category']); ?></td>
                                                <td>
                                                    <?php if($pet['verified_by']): ?>
                                                        <span class="badge bg-blue-lt">
                                                            Staff: <?php echo e($pet['verified_by']['name']); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-yellow-lt">Pending</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Verified</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo e(route('pets.edit', $pet['id'])); ?>" class="btn btn-icon btn-outline-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pending Verification Tab -->
                    <div class="tab-pane" id="pending">
                        <?php if($pendingPets->isEmpty()): ?>
                            <div class="empty">
                                <div class="empty-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 12l2 2l4 -4" />
                                    </svg>
                                </div>
                                <p class="empty-title">No pending verifications</p>
                                <p class="empty-subtitle text-muted">
                                    All pets have been verified
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Pet Details</th>
                                            <th>Owner</th>
                                            <th>Category</th>
                                            <th>Added By</th>
                                            <th>Status</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $pendingPets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="avatar avatar-md me-2" style="background-image: url(<?php echo e($pet['photo_url']); ?>)"></span>
                                                        <div>
                                                            <div class="font-weight-medium"><?php echo e($pet['name']); ?></div>
                                                            <div class="text-muted"><?php echo e($pet['breed']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><?php echo e($pet['owner']['name']); ?></div>
                                                    <?php if(isset($pet['owner']['email'])): ?>
                                                        <div class="text-muted"><?php echo e($pet['owner']['email']); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($pet['category']); ?></td>
                                                <td>
                                                    <?php if($pet['created_by']): ?>
                                                        <span class="badge bg-blue-lt">Staff: <?php echo e($pet['created_by']['name']); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-green-lt">Owner</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-yellow">Pending</span>
                                                </td>
                                                <td>
                                                    <button onclick="verifyPet(<?php echo e($pet['id']); ?>)" class="btn btn-success">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                        Verify
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}
.table-hover tbody tr:hover {
    background-color: rgba(32, 107, 196, 0.03);
}
.pet-details-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.list-group-flush .list-group-item {
    border-color: #f0f0f0;
}

.avatar-lg {
    width: 64px;
    height: 64px;
}

.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}

.status-dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    display: inline-block;
}
.status-green {
    background-color: #2fb344;
}
.status-gray {
    background-color: #dadcde;
}
.bg-light {
    background-color: #f8f9fa;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.04em;
}

.card-banner {
    background: linear-gradient(135deg, #206bc4, #4299e1);
}

.avatar-rounded {
    border-radius: 0.5rem;
}

.border-4 {
    border-width: 4px !important;
}

.bg-azure-lt {
    background-color: rgba(66, 153, 225, 0.1) !important;
}

.bg-purple-lt {
    background-color: rgba(159, 122, 234, 0.1) !important;
}

.bg-green-lt {
    background-color: rgba(72, 187, 120, 0.1) !important;
}

.text-azure {
    color: #4299e1 !important;
}

.text-purple {
    color: #9f7aea !important;
}

.text-green {
    color: #48bb78 !important;
}

.timeline-event-icon {
    background: linear-gradient(135deg, #206bc4, #4299e1);
    box-shadow: 0 0.5rem 1rem rgba(32, 107, 196, 0.1);
}

.timeline-event-card {
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-sm {
    transition: transform 0.2s ease-in-out;
}

.card-sm:hover {
    transform: translateY(-2px);
}

.pet-details-header {
    background: linear-gradient(135deg, #206bc4, #4299e1);
    color: white;
    overflow: hidden;
}

.info-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    height: 100%;
}

.info-card-header {
    padding: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.info-card-body {
    padding: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-size: 0.875rem;
}

.info-value {
    font-weight: 500;
}

.appointment-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.appointment-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.date-badge {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 0.5rem;
    text-align: center;
    min-width: 60px;
}

.date-badge .month {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6c757d;
}

.date-badge .day {
    font-size: 1.25rem;
    font-weight: 600;
    color: #206bc4;
}

.appointment-content {
    flex: 1;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state-icon {
    margin-bottom: 1rem;
    color: #adb5bd;
}

.avatar-xl {
    width: 80px;
    height: 80px;
}

.z-1 {
    z-index: 1;
}

.icon-pet {
    stroke: white;
}

.opacity-10 {
    opacity: 0.1;
}

.service-type-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.service-type-icon svg {
    width: 20px;
    height: 20px;
}

.appointment-item {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
}

.appointment-item:hover {
    transform: translateX(4px);
}

.date-badge {
    background: linear-gradient(to bottom, rgba(32, 107, 196, 0.1), rgba(32, 107, 196, 0.05));
    border-radius: 8px;
    padding: 0.75rem;
    text-align: center;
    min-width: 70px;
    border: 1px solid rgba(32, 107, 196, 0.1);
}

.date-badge .month {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #206bc4;
    font-weight: 600;
}

.date-badge .day {
    font-size: 1.5rem;
    font-weight: 700;
    color: #206bc4;
    line-height: 1.2;
}

.date-badge .year {
    font-size: 0.75rem;
    color: #6c757d;
}

.appointment-content {
    flex: 1;
    background: transparent;
    padding: 0;
}

.h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.gap-2 {
    gap: 0.5rem;
}

.reason-text {
    font-size: 1.1rem !important;  /* Reduced from 1.25rem */
    line-height: 1.4;
    color: #1e293b !important;
}

.info-card-header .btn-primary {
    font-size: 1rem;  /* Reduced from 1.125rem */
    padding: 0.5rem 1rem;  /* Reduced padding slightly */
    font-weight: 500;
}

.pet-row {
    display: table-row;
}

.pet-row.hidden {
    display: none;
}

.btn-group {
    border-radius: 4px;
    overflow: hidden;
}

.btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #206bc4;
    color: #fff;
    border-color: #206bc4;
}

.nav-tabs .nav-link {
    color: #1e293b;
    font-weight: 500;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
}

.nav-tabs .nav-link.active {
    color: #206bc4;
    border-bottom-color: #206bc4;
}

.empty {
    text-align: center;
    padding: 2rem;
}

.empty-icon {
    margin-bottom: 1rem;
    color: #6c757d;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    color: #6c757d;
}

/* Add these styles to your existing styles */
.badge {
    padding: 0.35rem 0.65rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.bg-green-lt {
    background-color: rgba(47, 179, 68, 0.1) !important;
    color: #2fb344 !important;
}

.bg-yellow-lt {
    background-color: rgba(247, 183, 49, 0.1) !important;
    color: #f7b731 !important;
}

.gap-1 {
    gap: 0.25rem !important;
}
</style>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const allPetsBtn = document.getElementById('all-pets');
    const adminAddedBtn = document.getElementById('admin-added');
    const ownerAddedBtn = document.getElementById('owner-added');
    
    function filterPets(filter) {
        const petRows = document.querySelectorAll('.pet-row');
        
        petRows.forEach(row => {
            if (filter === 'all') {
                row.classList.remove('d-none');
            } else if (filter === 'admin') {
                row.classList.toggle('d-none', !row.classList.contains('admin-created'));
            } else if (filter === 'owner') {
                row.classList.toggle('d-none', !row.classList.contains('owner-created'));
            }
        });
    }
    
    allPetsBtn?.addEventListener('change', () => filterPets('all'));
    adminAddedBtn?.addEventListener('change', () => filterPets('admin'));
    ownerAddedBtn?.addEventListener('change', () => filterPets('owner'));
});

function verifyPet(petId) {
    if (!confirm('Are you sure you want to verify this pet?')) {
        return;
    }

    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `
        <div class="spinner-border spinner-border-sm text-white" role="status">
            <span class="visually-hidden">Verifying...</span>
        </div>
    `;

    fetch(`/pets/${petId}/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: 'approved' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success toast
            const toast = document.createElement('div');
            toast.className = 'toast position-fixed top-0 end-0 m-3';
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    Pet has been verified successfully.
                </div>
            `;
            document.body.appendChild(toast);
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            setTimeout(() => window.location.reload(), 1500);
        } else {
            throw new Error('Verification failed');
        }
    })
    .catch(error => {
        button.disabled = false;
        button.innerHTML = originalContent;
        alert('Failed to verify pet. Please try again.');
        console.error('Error:', error);
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/pet/index.blade.php ENDPATH**/ ?>