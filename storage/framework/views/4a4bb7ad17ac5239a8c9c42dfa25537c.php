<?php $__env->startSection('content'); ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Schedule New Appointment
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?php echo e(route('appointment.index')); ?>" class="btn btn-secondary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                        </svg>
                        Back to Appointments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form id="appointmentForm" action="<?php echo e(route('appointment.store')); ?>" method="POST" class="card" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Add this for debugging -->
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Add this near the top of your form for debugging -->
                    <?php if(session('error_section')): ?>
                        <div class="alert alert-info">
                            Error Section: <?php echo e(session('error_section')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Owner and Pet Selection Row -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <!-- Pet Owner Selection -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="<?php echo e(isset($owner) && $owner->photo ? asset('storage/' . $owner->photo) : asset('storage/defaults/avatar.png')); ?>" 
                                                             class="avatar avatar-lg" 
                                                             id="owner_avatar"
                                                             alt="Owner Avatar"
                                                             style="width: 64px; height: 64px;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label required">Pet Owner</label>
                                                        <select name="owner_id" id="owner_id" class="form-select" required>
                                                            <option value="">Select Owner</option>
                                                            <option value="no_account">No Account (Walk-in)</option>
                                                            <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ownerOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($ownerOption->id); ?>" 
                                                                    data-avatar="<?php echo e($ownerOption->photo ? asset('storage/' . $ownerOption->photo) : asset('storage/defaults/avatar.png')); ?>"
                                                                    <?php echo e((old('owner_id') == $ownerOption->id || (isset($owner) && $owner->id == $ownerOption->id)) ? 'selected' : ''); ?>>
                                                                    <?php echo e($ownerOption->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <?php $__errorArgs = ['owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic Second Column (Pet Selection OR Owner Name) -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="<?php echo e(isset($pet) && $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/defaults/paw.png')); ?>" 
                                                             class="avatar avatar-lg" 
                                                             id="dynamic_avatar"
                                                             alt="Pet Avatar"
                                                             style="width: 64px; height: 64px;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <!-- Pet Selection (for registered users) -->
                                                        <div id="pet_select_container">
                                                            <label class="form-label required">Select Pet</label>
                                                            <select name="pet_id" id="pet_id" class="form-select" required>
                                                                <option value="">Select Pet</option>
                                                                <?php if(isset($ownerPets)): ?>
                                                                    <?php $__currentLoopData = $ownerPets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($petOption->id); ?>" 
                                                                            data-photo="<?php echo e($petOption->photo_url ?? asset('storage/defaults/paw.png')); ?>"
                                                                            <?php echo e((old('pet_id') == $petOption->id || (isset($pet) && $pet->id == $petOption->id)) ? 'selected' : ''); ?>

                                                                            data-name="<?php echo e($petOption->name); ?>"
                                                                            data-category="<?php echo e($petOption->category); ?>"
                                                                            data-breed="<?php echo e($petOption->breed); ?>"
                                                                            data-age="<?php echo e($petOption->age); ?>"
                                                                            data-weight="<?php echo e($petOption->weight); ?>"
                                                                            data-gender="<?php echo e(strtolower($petOption->gender)); ?>">
                                                                            <?php echo e($petOption->name); ?> (<?php echo e($petOption->category); ?>)
                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <?php $__errorArgs = ['pet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>

                                                        <!-- Owner Name Input (for walk-ins) -->
                                                        <div id="owner_name_container" style="display: none;">
                                                            <label class="form-label required">Owner Name</label>
                                                            <input type="text" id="owner_name" name="owner_name" 
                                                                   class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                                   value="<?php echo e(old('owner_name')); ?>">
                                                            <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Walk-in Pet Details -->
                            <div id="walkin_pet_group" class="col-12" style="display: none;">
                                <div class="card h-100">
                                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 10c-1.32 0 -1.983 .421 -2.931 1.924l-.244 .398l-.395 .688a50.89 50.89 0 0 0 -.141 .254c-.24 .434 -.571 .753 -1.139 1.142l-.55 .365c-.94 .627 -1.432 1.118 -1.707 1.955c-.124 .338 -.196 .853 -.193 1.28c0 1.687 1.198 2.994 2.8 2.994l.242 -.006c.119 -.006 .234 -.017 .354 -.034l.248 -.043l.132 -.028l.291 -.073l.162 -.045l.57 -.17l.763 -.243l.455 -.136c.53 -.15 .94 -.222 1.283 -.222c.344 0 .753 .073 1.283 .222l.455 .136l.764 .242l.569 .171l.312 .084c.097 .024 .187 .045 .273 .062l.248 .043c.12 .017 .235 .028 .354 .034l.242 .006c1.602 0 2.8 -1.307 2.8 -3c0 -.427 -.073 -.939 -.207 -1.306c-.236 -.724 -.677 -1.223 -1.48 -1.83l-.257 -.19l-.528 -.38c-.642 -.47 -1.003 -.826 -1.253 -1.278l-.27 -.485l-.252 -.432c-1.011 -1.696 -1.618 -2.099 -3.053 -2.099z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M19.78 7h-.03c-1.219 .02 -2.35 1.066 -2.908 2.504c-.69 1.775 -.348 3.72 1.075 4.333c.256 .109 .527 .163 .801 .163c1.231 0 2.38 -1.053 2.943 -2.504c.686 -1.774 .34 -3.72 -1.076 -4.332a2.05 2.05 0 0 0 -.804 -.164z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M9.025 3c-.112 0 -.185 .002 -.27 .006l-.112 .007l-.118 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.188 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M14.975 3c-.115 0 -.189 .002 -.274 .006l-.113 .007l-.117 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.184 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M4.217 7c-.101 0 -.199 .018 -.289 .055c-1.416 .613 -1.762 2.558 -1.076 4.333c.564 1.45 1.713 2.504 2.943 2.504c.274 0 .545 -.054 .801 -.163c1.423 -.613 1.765 -2.558 1.075 -4.333c-.557 -1.438 -1.69 -2.484 -2.908 -2.504h-.03c-.153 0 -.345 .024 -.516 .108z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                        <h3 class="card-title mb-0">Pet Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M15 8l2 0"></path>
                                                        <path d="M15 12l2 0"></path>
                                                        <path d="M7 16l10 0"></path>
                                                    </svg>
                                                    Pet Name
                                                </label>
                                                <input type="text" id="walkin_pet_name" name="walkin_pet_name" 
                                                       class="form-control <?php $__errorArgs = ['walkin_pet_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <?php $__errorArgs = ['walkin_pet_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v6h-6z"></path>
                                                        <path d="M14 4h6v6h-6z"></path>
                                                        <path d="M4 14h6v6h-6z"></path>
                                                        <path d="M14 14h6v6h-6z"></path>
                                                    </svg>
                                                        Pet Type
                                                </label>
                                                <select id="walkin_pet_type" name="walkin_pet_type" 
                                                        class="form-select <?php $__errorArgs = ['walkin_pet_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="">Select Pet Type</option>
                                                    <option value="Dog">Dog</option>
                                                    <option value="Cat">Cat</option>
                                                    <option value="Bird">Bird</option>
                                                    <option value="Rabbit">Rabbit</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <?php $__errorArgs = ['walkin_pet_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog-bowl" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 15l5.586 -5.585a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-3.587 3.586"></path>
                                                        <path d="M12 13l-3.586 -3.585a2 2 0 1 0 -3.414 -1.415a2 2 0 1 0 1.413 3.414l3.587 3.586"></path>
                                                        <path d="M3 20h18c-.175 -1.671 -.046 -3.345 -2 -5h-14c-1.954 1.655 -1.825 3.329 -2 5z"></path>
                                                    </svg>
                                                    Breed/Species
                                                </label>
                                                <input type="text" id="walkin_pet_breed" name="walkin_pet_breed" 
                                                       class="form-control <?php $__errorArgs = ['walkin_pet_breed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <?php $__errorArgs = ['walkin_pet_breed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M15 3v4"></path>
                                                        <path d="M7 3v4"></path>
                                                        <path d="M3 11h16"></path>
                                                        <path d="M18 16.496v1.504l1 1"></path>
                                                    </svg>
                                                    Age
                                                </label>
                                                <div class="input-group p-0">
                                                    <input type="number" id="walkin_pet_age" name="walkin_pet_age" 
                                                           class="form-control <?php $__errorArgs = ['walkin_pet_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="0">
                                                    <select id="walkin_age_unit" name="walkin_age_unit" class="form-select" style="max-width: 100px;">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                                <?php $__errorArgs = ['walkin_pet_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scale" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 20l10 0"></path>
                                                        <path d="M6 6l6 -1l6 1"></path>
                                                        <path d="M12 3l0 17"></path>
                                                        <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                        <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                    </svg>
                                                    Weight (kg)
                                                </label>
                                                <input type="number" id="walkin_pet_weight" name="walkin_pet_weight" 
                                                       class="form-control <?php $__errorArgs = ['walkin_pet_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       step="0.01" min="0">
                                                <?php $__errorArgs = ['walkin_pet_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-bigender" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M19 3l-5 5"></path>
                                                        <path d="M15 3h4v4"></path>
                                                        <path d="M11 16v6"></path>
                                                        <path d="M8 19h6"></path>
                                                    </svg>
                                                    Gender
                                                </label>
                                                <select id="walkin_pet_gender" name="walkin_pet_gender" 
                                                        class="form-select <?php $__errorArgs = ['walkin_pet_gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                                <?php $__errorArgs = ['walkin_pet_gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registered Pet Details Card -->
                            <div id="registered_pet_details" class="col-12" style="min-height: 300px; margin-bottom: 1.5rem;">
                                <div class="card h-100">
                                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 10c-1.32 0 -1.983 .421 -2.931 1.924l-.244 .398l-.395 .688a50.89 50.89 0 0 0 -.141 .254c-.24 .434 -.571 .753 -1.139 1.142l-.55 .365c-.94 .627 -1.432 1.118 -1.707 1.955c-.124 .338 -.196 .853 -.193 1.28c0 1.687 1.198 2.994 2.8 2.994l.242 -.006c.119 -.006 .234 -.017 .354 -.034l.248 -.043l.132 -.028l.291 -.073l.162 -.045l.57 -.17l.763 -.243l.455 -.136c.53 -.15 .94 -.222 1.283 -.222c.344 0 .753 .073 1.283 .222l.455 .136l.764 .242l.569 .171l.312 .084c.097 .024 .187 .045 .273 .062l.248 .043c.12 .017 .235 .028 .354 .034l.242 .006c1.602 0 2.8 -1.307 2.8 -3c0 -.427 -.073 -.939 -.207 -1.306c-.236 -.724 -.677 -1.223 -1.48 -1.83l-.257 -.19l-.528 -.38c-.642 -.47 -1.003 -.826 -1.253 -1.278l-.27 -.485l-.252 -.432c-1.011 -1.696 -1.618 -2.099 -3.053 -2.099z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M19.78 7h-.03c-1.219 .02 -2.35 1.066 -2.908 2.504c-.69 1.775 -.348 3.72 1.075 4.333c.256 .109 .527 .163 .801 .163c1.231 0 2.38 -1.053 2.943 -2.504c.686 -1.774 .34 -3.72 -1.076 -4.332a2.05 2.05 0 0 0 -.804 -.164z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M9.025 3c-.112 0 -.185 .002 -.27 .006l-.112 .007l-.118 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.188 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M14.975 3c-.115 0 -.189 .002 -.274 .006l-.113 .007l-.117 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.184 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M4.217 7c-.101 0 -.199 .018 -.289 .055c-1.416 .613 -1.762 2.558 -1.076 4.333c.564 1.45 1.713 2.504 2.943 2.504c.274 0 .545 -.054 .801 -.163c1.423 -.613 1.765 -2.558 1.075 -4.333c-.557 -1.438 -1.69 -2.484 -2.908 -2.504h-.03c-.153 0 -.345 .024 -.516 .108z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                        <h3 class="card-title mb-0">Pet Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M15 8l2 0"></path>
                                                        <path d="M15 12l2 0"></path>
                                                        <path d="M7 16l10 0"></path>
                                                    </svg>
                                                    Pet Name
                                                </label>
                                                <input type="text" id="pet_name" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v6h-6z"></path>
                                                        <path d="M14 4h6v6h-6z"></path>
                                                        <path d="M4 14h6v6h-6z"></path>
                                                        <path d="M14 14h6v6h-6z"></path>
                                                    </svg>
                                                        Pet Type
                                                </label>
                                                <input type="text" id="pet_category" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog-bowl" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 15l5.586 -5.585a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-3.587 3.586"></path>
                                                        <path d="M12 13l-3.586 -3.585a2 2 0 1 0 -3.414 -1.415a2 2 0 1 0 1.413 3.414l3.587 3.586"></path>
                                                        <path d="M3 20h18c-.175 -1.671 -.046 -3.345 -2 -5h-14c-1.954 1.655 -1.825 3.329 -2 5z"></path>
                                                    </svg>
                                                    Breed
                                                </label>
                                                <input type="text" id="pet_breed" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M15 3v4"></path>
                                                        <path d="M7 3v4"></path>
                                                        <path d="M3 11h16"></path>
                                                        <path d="M18 16.496v1.504l1 1"></path>
                                                    </svg>
                                                    Pet Age
                                                </label>
                                                <div class="input-group p-0">
                                                    <input type="number" id="pet_age" class="form-control" readonly>
                                                    <select id="age_unit" class="form-select" style="max-width: 100px;" disabled>
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scale" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 20l10 0"></path>
                                                        <path d="M6 6l6 -1l6 1"></path>
                                                        <path d="M12 3l0 17"></path>
                                                        <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                        <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                    </svg>
                                                    Weight (kg)
                                                </label>
                                                <input type="number" id="pet_weight" class="form-control" step="0.01" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-bigender" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M19 3l-5 5"></path>
                                                        <path d="M15 3h4v4"></path>
                                                        <path d="M11 16v6"></path>
                                                        <path d="M8 19h6"></path>
                                                    </svg>
                                                    Gender
                                                </label>
                                                <input type="text" id="pet_gender" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Date/Time Row -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Date</label>
                                        <input type="date" id="appointment_date" name="appointment_date" 
                                               class="form-control <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               required value="<?php echo e(old('appointment_date')); ?>">
                                        <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label required">Time</label>
                                        <select id="appointment_time" name="appointment_time" 
                                                class="form-select <?php $__errorArgs = ['appointment_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                required>
                                            <option value="">Select Time</option>
                                            <optgroup label="Morning">
                                                <?php $__currentLoopData = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($time); ?>" <?php echo e(old('appointment_time') == $time ? 'selected' : ''); ?>>
                                                        <?php echo e($time); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <optgroup label="Afternoon">
                                                <?php $__currentLoopData = ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($time); ?>" <?php echo e(old('appointment_time') == $time ? 'selected' : ''); ?>>
                                                        <?php echo e($time); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        </select>
                                        <?php $__errorArgs = ['appointment_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Reason for Visit</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <?php $__currentLoopData = [
                                        'Vaccination' => [
                                            'icon' => 'vaccine',
                                            'sub' => ['Anti-rabies', 'DHPP', 'FVRCP', 'Deworming']
                                        ],
                                        'Check-up' => [
                                            'icon' => 'stethoscope',
                                            'sub' => ['Routine', 'Follow-up', 'Emergency']
                                        ],
                                        'Grooming' => [
                                            'icon' => 'cut',
                                            'sub' => ['Full Service', 'Nail Trim', 'Dental']
                                        ],
                                        'Surgery' => [
                                            'icon' => 'scalpel',
                                            'sub' => ['Spay/Neuter', 'Minor', 'Major']
                                        ],
                                        'Laboratory' => [
                                            'icon' => 'test-pipe',
                                            'sub' => ['Blood Test', 'Urinalysis', 'X-ray']
                                        ]
                                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" 
                                            class="btn reason-btn" 
                                            data-reason="<?php echo e($category); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-<?php echo e($details['icon']); ?>" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <?php if($details['icon'] === 'vaccine'): ?>
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M17 3l4 4"></path>
                                                    <path d="M19 5l-4.5 4.5"></path>
                                                    <path d="M11.5 6.5l6 6"></path>
                                                    <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                                    <path d="M7.5 12.5l1.5 1.5"></path>
                                                    <path d="M10.5 9.5l1.5 1.5"></path>
                                                    <path d="M3 21l3 -3"></path>
                                                <?php elseif($details['icon'] === 'stethoscope'): ?>
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"></path>
                                                    <path d="M8 15a6 6 0 1 0 12 0v-3"></path>
                                                    <path d="M11 3v2"></path>
                                                    <path d="M6 3v2"></path>
                                                    <circle cx="20" cy="10" r="2"></circle>
                                                <?php elseif($details['icon'] === 'cut'): ?>
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <circle cx="6" cy="7" r="3"></circle>
                                                    <circle cx="6" cy="17" r="3"></circle>
                                                    <line x1="8.7" y1="8.7" x2="19" y2="19"></line>
                                                    <line x1="8.7" y1="15.3" x2="19" y2="5"></line>
                                                <?php elseif($details['icon'] === 'scalpel'): ?>
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M19 5l-12.5 12.5a4.95 4.95 0 0 1 -7 -7l12.5 -12.5a1 1 0 0 1 1.414 0l5.586 5.586a1 1 0 0 1 0 1.414z"></path>
                                                    <path d="M18 6l-11.5 11.5"></path>
                                                <?php elseif($details['icon'] === 'test-pipe'): ?>
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 8.04l-12.122 12.124a2.857 2.857 0 1 1 -4.041 -4.04l12.122 -12.124"></path>
                                                    <path d="M7 13h8"></path>
                                                    <path d="M19 15l1.5 1.6a2 2 0 1 1 -3 0l1.5 -1.6z"></path>
                                                    <path d="M15 3l6 6"></path>
                                                <?php endif; ?>
                                            </svg>
                                            <?php echo e($category); ?>

                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <!-- Update the visit history table columns -->
                                <div id="checkup-history-table" class="mt-4" style="display: none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="card-title">Visit History</h3>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>Category:</span>
                                                    <select class="form-select form-select-sm" style="width: auto;" id="visitTypeSelect">
                                                        <option value="all">All Records</option>
                                                        <optgroup label="Check-up">
                                                            <option value="routine">Routine Check-up</option>
                                                            <option value="emergency">Emergency</option>
                                                            <option value="follow_up">Follow-up</option>
                                                        </optgroup>
                                                        <optgroup label="Vaccination">
                                                            <option value="anti_rabies">Anti-rabies</option>
                                                            <option value="dhpp">DHPP</option>
                                                            <option value="fvrcp">FVRCP</option>
                                                            <option value="deworming">Deworming</option>
                                                        </optgroup>
                                                        <optgroup label="Grooming">
                                                            <option value="full_grooming">Full Service</option>
                                                            <option value="nail_trim">Nail Trim</option>
                                                            <option value="dental">Dental Care</option>
                                                        </optgroup>
                                                        <optgroup label="Surgery">
                                                            <option value="spay_neuter">Spay/Neuter</option>
                                                            <option value="minor_surgery">Minor Surgery</option>
                                                            <option value="major_surgery">Major Surgery</option>
                                                        </optgroup>
                                                        <optgroup label="Laboratory">
                                                            <option value="blood_test">Blood Test</option>
                                                            <option value="urinalysis">Urinalysis</option>
                                                            <option value="xray">X-ray</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Service Type</th>
                                                            <th>Findings/Results</th>
                                                            <th>Vital Signs</th>
                                                            <th>Treatment/Procedure</th>
                                                            <th>Medications</th>
                                                            <!-- Additional columns for specific services -->
                                                            <th class="vaccination-col" style="display: none;">Vaccine Details</th>
                                                            <th class="vaccination-col" style="display: none;">Next Due Date</th>
                                                            <th class="grooming-col" style="display: none;">Services Done</th>
                                                            <th class="grooming-col" style="display: none;">Products Used</th>
                                                            <th class="surgery-col" style="display: none;">Surgery Type</th>
                                                            <th class="surgery-col" style="display: none;">Anesthesia Used</th>
                                                            <th class="surgery-col" style="display: none;">Recovery Notes</th>
                                                            <th>Next Visit</th>
                                                            <th>Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="visitHistoryBody">
                                                        <tr class="text-center no-data-row">
                                                            <td colspan="8">
                                                                <div class="empty">
                                                                    <div class="empty-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                            <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="empty-title">No visit history found</p>
                                                                    <p class="empty-subtitle text-muted">
                                                                        No previous records found for this category.
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="selected-reasons-box">
                                    <div id="selected-reasons" class="d-flex flex-wrap gap-2"></div>
                                    <div id="empty-reason-text" class="text-muted">No reasons selected</div>
                                </div>
                                <input type="hidden" name="reason_for_visit" id="reason_for_visit" required>
                                <?php $__errorArgs = ['reason_for_visit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Medical History Modal -->
                            <div class="modal modal-blur fade" id="medical-history-section" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="fas fa-stethoscope me-2"></i>Medical Record</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Patient Information Card -->
                                            <!-- Medical History Table -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Medical History</h3>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Service</th>
                                                                    <th>Diagnosis</th>
                                                                    <th>Treatment</th>
                                                                    <th>Notes</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="medicalHistoryBody">
                                                                <tr class="text-center no-data-row">
                                                                    <td colspan="5">
                                                                        <div class="empty">
                                                                            <div class="empty-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                    <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                                                </svg>
                                                                            </div>
                                                                            <p class="empty-title">No medical history found</p>
                                                                            <p class="empty-subtitle text-muted">
                                                                                This pet has no previous medical records.
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Replace the existing service details and history sections -->
                            <div class="row g-3">
                                <!-- Service Details Column (Left side) -->
                                <div class="col-lg-5">
                                    <!-- Service Details Card -->
                                    <div id="service-details-card" style="display: none;">
                                        <!-- Dynamic content will be inserted here -->
                                    </div>

                                    <!-- Additional Notes -->
                                    <div class="mb-3">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information about the visit..."></textarea>
                                    </div>
                                </div>

                                <!-- Service History Column (Right side) -->
                                <div class="col-lg-7">
                                    <div id="service-histories-container">
                                        <!-- Service histories will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5"></path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M16 19h6"></path>
                                <path d="M19 16v6"></path>
                            </svg>
                            Schedule Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-scripts'); ?>
<!-- Add these at the top of your scripts section -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Move these functions outside the DOMContentLoaded event listener
function toggleMedicalHistory() {
    const modal = new bootstrap.Modal(document.getElementById('medical-history-section'));
    const petId = document.getElementById('pet_id').value;
    const petSelect = document.getElementById('pet_id');
    const userSelect = document.getElementById('owner_id');
    
    if (!petId || userSelect.value === 'no_account') {
        Swal.fire({
            icon: 'warning',
            title: 'No Pet Selected',
            text: 'Please select a registered pet to view medical history.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // Update owner and pet details
    const selectedPet = petSelect.options[petSelect.selectedIndex];
    const petName = selectedPet.text;
    const petType = selectedPet.dataset.type;
    const ownerName = userSelect.options[userSelect.selectedIndex].text;
    
    // Update pet and owner details
    document.getElementById('owner-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${ownerName}</span>
            <span class="badge ${userSelect.value === 'no_account' ? 'bg-yellow-lt' : 'bg-azure-lt'} mt-1">
                <i class="${userSelect.value === 'no_account' ? 'fas fa-walking' : 'fas fa-user-check'} me-1"></i>
                ${userSelect.value === 'no_account' ? 'Walk-in' : 'Registered'}
            </span>
        </div>
    `;
    
    document.getElementById('pet-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${petName}</span>
            <div class="mt-1">
                <span class="badge bg-blue-lt">${petType}</span>
            </div>
        </div>
    `;
    
    // Load medical history
    loadMedicalHistory(petId);
    
    modal.show();
}

function loadMedicalHistory(petId) {
    // Show loading state
    const tbody = document.getElementById('medicalHistoryBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    `;

    fetch(`/api/pets/${petId}/medical-history`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr class="text-center">
                        <td colspan="5">
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">No medical history found</p>
                                <p class="empty-subtitle text-muted">
                                    This pet has no previous medical records.
                                </p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = data.map(record => `
                <tr>
                    <td>${new Date(record.date).toLocaleDateString()}</td>
                    <td>${record.service || '-'}</td>
                    <td>${record.diagnosis || '-'}</td>
                    <td>${record.treatment || '-'}</td>
                    <td>${record.notes || '-'}</td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading medical history:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Failed to load medical history. Please try again.
                    </td>
                </tr>`;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');
    const selectedReasons = new Set();
    const reasonButtons = document.querySelectorAll('.reason-btn');
    const otherReasonBtn = document.getElementById('other-reason-btn');
    const otherReasonGroup = document.getElementById('other_reason_group');
    const otherReasonInput = document.getElementById('other_reason');
    const addOtherReasonBtn = document.getElementById('add-other-reason');
    const selectedReasonsContainer = document.getElementById('selected-reasons');
    const reasonForVisitInput = document.getElementById('reason_for_visit');
    const ownerNameGroup = document.getElementById('owner_name_group');
    const ownerNameInput = document.getElementById('owner_name');
    const petSelectionGroup = document.getElementById('pet_selection_group');
    const appointmentDate = document.getElementById('appointment_date');
    const appointmentTime = document.getElementById('appointment_time');
    const checkupTable = document.getElementById('checkup-history-table');
    const checkupTypeSelect = document.getElementById('checkupTypeSelect');
    const categoryHeader = document.getElementById('categoryHeader');

    // Check if there's an existing appointment and pre-select appropriate fields
    const existingUserId = '<?php echo e(old("owner_id", $appointment->owner_id ?? "")); ?>';
    const existingOwnerName = '<?php echo e(old("owner_name", $appointment->owner_name ?? "")); ?>';

    if (existingOwnerName && !existingUserId) {
        userSelect.value = 'no_account';
        ownerNameGroup.style.display = 'block';
        petSelectionGroup.style.display = 'none';
        ownerNameInput.value = existingOwnerName;
    } else if (existingUserId) {
        userSelect.value = existingUserId;
        // Trigger change event to load pets
        userSelect.dispatchEvent(new Event('change'));
    }

    // Function to clear pet details
    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_category').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
        document.getElementById('pet_gender').value = '';
    }

    // Handle Pet Owner Selection with Walk-in Support
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        const ownerNameGroup = document.getElementById('owner_name_group');
        const petSelectionGroup = document.getElementById('pet_selection_group');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        if (userId === 'no_account') {
            // Show walk-in fields
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'none';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            
            // Make walk-in fields required
            document.getElementById('owner_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            document.getElementById('walkin_pet_weight').setAttribute('required', 'required');
            document.getElementById('walkin_pet_gender').setAttribute('required', 'required');
            
            // Remove requirement from pet selection
            document.getElementById('pet_id').removeAttribute('required');
            
            // Clear any selected pet data
            clearPetDetails();
        } else {
            // Show registered user fields
            ownerNameGroup.style.display = 'none';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'none';
            registeredPetDetails.style.display = 'flex';
            
            // Make pet selection required
            document.getElementById('pet_id').setAttribute('required', 'required');
            
            // Remove requirements from walk-in fields
            document.getElementById('owner_name').removeAttribute('required');
            document.getElementById('walkin_pet_name').removeAttribute('required');
            document.getElementById('walkin_pet_type').removeAttribute('required');
            document.getElementById('walkin_pet_age').removeAttribute('required');
            document.getElementById('walkin_pet_weight').removeAttribute('required');
            document.getElementById('walkin_pet_gender').removeAttribute('required');
            
            // Load pets if a user is selected
            if (userId) {
                loadPetsForOwner(userId);
            } else {
                clearPetSelect();
            }
        }
    });

    // Add these helper functions
    function loadPetsForOwner(userId) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();

        fetch(`/api/users/${userId}/pets`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Raw pets data:', data); // Debug log
                updatePetSelect(data.pets);
            })
            .catch(error => {
                console.error('Error:', error);
                petSelect.innerHTML = '<option value="">Error loading pets</option>';
            });
    }

    // Find and update the updatePetSelect function
    function updatePetSelect(pets) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        
        if (Array.isArray(pets) && pets.length > 0) {
            console.log('Received pets data:', pets);
            
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.text = `${pet.name} (${pet.category})`;
                
                // Make sure to set all data attributes from the pet object
                option.dataset.name = pet.name || '';
                option.dataset.category = pet.category || '';
                option.dataset.type = pet.type || pet.category || ''; // Fallback to category if type is null
                option.dataset.breed = pet.breed || '';
                option.dataset.age = pet.age ? pet.age.toString() : '';
                option.dataset.weight = pet.weight ? pet.weight.toString() : '';
                // Capitalize first letter of gender
                option.dataset.gender = pet.gender ? 
                    pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : '';
                
                // Debug log for each option
                console.log('Setting data attributes for:', pet.name, option.dataset);
                
                petSelect.appendChild(option);
            });
        } else {
            petSelect.innerHTML = '<option value="">No pets found</option>';
        }
    }

    function clearPetSelect() {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        clearPetDetails();
    }

    // Replace the existing pet selection event listener with this updated version
    petSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const dynamicAvatar = document.getElementById('dynamic_avatar');
        
        // Debug logs
        console.log('Selected option:', selectedOption);
        console.log('Selected value:', this.value);
        
        if (!this.value) {
            clearPetDetails();
            if (dynamicAvatar) {
                dynamicAvatar.src = '/storage/defaults/paw.png';
            }
            return;
        }
        
        // Get the data from the selected option
        const petData = {
            name: selectedOption.dataset.name,
            category: selectedOption.dataset.category,
            breed: selectedOption.dataset.breed,
            age: selectedOption.dataset.age,
            weight: selectedOption.dataset.weight,
            gender: selectedOption.dataset.gender,
            photo: selectedOption.dataset.photo
        };
        
        console.log('Pet data from dataset:', petData);
        
        // Update the form fields
        const fields = {
            'pet_name': petData.name,
            'pet_category': petData.category,
            'pet_breed': petData.breed,
            'pet_age': petData.age,
            'pet_weight': petData.weight,
            'pet_gender': petData.gender
        };

        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value || '';
            }
        });

        // Update avatar
        if (dynamicAvatar) {
            dynamicAvatar.src = petData.photo || '/storage/defaults/paw.png';
        }

        // Fetch additional pet data from API
        try {
            const response = await fetch(`/api/pets/${this.value}`);
            if (!response.ok) throw new Error('Failed to fetch pet data');
            const apiPetData = await response.json();
            console.log('API pet data:', apiPetData);
            
            // Update with API data if available
            updatePetDetails(apiPetData);
            
            // Update avatar with API photo if available
            if (dynamicAvatar && apiPetData.photo) {
                dynamicAvatar.src = '/storage/' + apiPetData.photo;
            }
        } catch (error) {
            console.error('Error fetching pet data:', error);
            // Keep the data from dataset if API fails
        }
    });

    // Update the updatePetSelect function to properly set data attributes
    function updatePetSelect(pets) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        
        if (Array.isArray(pets) && pets.length > 0) {
            console.log('Received pets data:', pets);
            
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.text = `${pet.name} (${pet.category})`;
                
                // Set all data attributes
                option.setAttribute('data-name', pet.name || '');
                option.setAttribute('data-category', pet.category || '');
                option.setAttribute('data-type', pet.type || pet.category || '');
                option.setAttribute('data-breed', pet.breed || '');
                option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
                option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
                option.setAttribute('data-gender', pet.gender ? 
                    pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : '');
                option.setAttribute('data-photo', pet.photo ? 
                    '/storage/' + pet.photo : '/storage/defaults/paw.png');
                
                // Debug log for each option
                console.log('Setting data attributes for:', pet.name, {
                    name: option.dataset.name,
                    category: option.dataset.category,
                    type: option.dataset.type,
                    breed: option.dataset.breed,
                    age: option.dataset.age,
                    weight: option.dataset.weight,
                    gender: option.dataset.gender,
                    photo: option.dataset.photo
                });
                
                petSelect.appendChild(option);
            });
        } else {
            petSelect.innerHTML = '<option value="">No pets found</option>';
        }
    }

    // Update the clearPetDetails function
    function clearPetDetails() {
        const fields = ['pet_name', 'pet_category', 'pet_breed', 'pet_age', 'pet_weight', 'pet_gender'];
        fields.forEach(fieldId => {
            const element = document.getElementById(fieldId);
            if (element) {
                element.value = '';
            }
        });
    }

    // Update the updatePetDetails function
    function updatePetDetails(petData) {
        if (!petData) return;
        
        const fields = {
            'pet_name': petData.name,
            'pet_category': petData.category,
            'pet_breed': petData.breed,
            'pet_age': petData.age,
            'pet_weight': petData.weight,
            'pet_gender': petData.gender
        };

        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value || '';
            }
        });
    }

    // Function to update the hidden input with selected reasons
    function updateReasonInput() {
        reasonForVisitInput.value = Array.from(selectedReasons).join(',');
    }

    // Function to create a reason badge
    function createReasonBadge(reason) {
        const badge = document.createElement('div');
        badge.className = 'badge d-flex align-items-center gap-2';
        badge.innerHTML = `
            ${reason}
            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
        `;

        badge.querySelector('.btn-close').addEventListener('click', function() {
            selectedReasons.delete(reason);
            badge.remove();
            
            // Update button state
            const button = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
            if (button) {
                button.classList.remove('active');
            }
            
            updateReasonInput();
        });

        return badge;
    }

    // Replace the existing updateServiceDetailsForm function with this updated version
    function updateServiceDetailsForm(reasons) {
        console.log('Updating service details form with reasons:', reasons);
        const serviceDetailsCard = document.getElementById('service-details-card');
        
        if (!serviceDetailsCard) {
            console.error('Service details card element not found!');
            return;
        }
        
        // If reasons is a string, convert it to an array
        if (typeof reasons === 'string') {
            reasons = [reasons];
        }
        
        console.log('Clearing existing content');
        serviceDetailsCard.innerHTML = '';
        
        // Create forms for each selected reason
        reasons.forEach((reason, index) => {
            console.log(`Creating form fields for ${reason} (index: ${index})`);
            let formFields = '';
            
            switch(reason) {
                case 'Vaccination':
                    console.log('Generating Vaccination form fields');
                    formFields = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M17 3l4 4"></path>
                                        <path d="M19 5l-4.5 4.5"></path>
                                        <path d="M11.5 6.5l6 6"></path>
                                        <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                        <path d="M7.5 12.5l1.5 1.5"></path>
                                        <path d="M10.5 9.5l1.5 1.5"></path>
                                        <path d="M3 21l3 -3"></path>
                                    </svg>
                                    Vaccine Type
                                </label>
                                <select name="vaccine[${index}][type]" class="form-select" required>
                                    <option value="">Select Vaccine</option>
                                    <option value="anti_rabies">Anti-rabies</option>
                                    <option value="dhpp">DHPP</option>
                                    <option value="fvrcp">FVRCP</option>
                                    <option value="deworming">Deworming</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M5 11h1v2h-1z"></path>
                                        <path d="M10 11l0 2"></path>
                                        <path d="M14 11h1v2h-1z"></path>
                                        <path d="M19 11l0 2"></path>
                                    </svg>
                                    Batch Number
                                </label>
                                <input type="text" name="vaccine[${index}][batch_number]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                        <path d="M16 3v4"></path>
                                        <path d="M8 3v4"></path>
                                        <path d="M4 11h16"></path>
                                        <path d="M11 15h1"></path>
                                        <path d="M12 15v3"></path>
                                    </svg>
                                    Next Due Date
                                </label>
                                <input type="date" name="vaccine[${index}][next_due_date]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    Administered By
                                </label>
                                <input type="text" name="vaccine[${index}][administered_by]" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M9 7l6 0"></path>
                                        <path d="M9 11l6 0"></path>
                                        <path d="M9 15l4 0"></path>
                                    </svg>
                                    Reactions
                                </label>
                                <textarea name="vaccine[${index}][reactions]" class="form-control" rows="2" placeholder="Enter any reactions or notes here..."></textarea>
                            </div>
                        </div>
                    `;
                    break;

                case 'Check-up':
                    console.log('Generating Check-up form fields');
                    // Match fields with the check-up history table columns
                    formFields = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Date</label>
                                <input type="date" name="checkup[${index}][date]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Service Type</label>
                                <select name="checkup[${index}][service_type]" class="form-select" required>
                                    <option value="routine">Routine Check-up</option>
                                    <option value="follow_up">Follow-up</option>
                                    <option value="emergency">Emergency</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Findings/Results</label>
                                <textarea name="checkup[${index}][findings]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Vital Signs</label>
                                <textarea name="checkup[${index}][vital_signs]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Treatment/Procedure</label>
                                <textarea name="checkup[${index}][treatment]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Medications</label>
                                <textarea name="checkup[${index}][medications]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Next Visit</label>
                                <input type="date" name="checkup[${index}][next_visit]" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="checkup[${index}][notes]" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    `;
                    break;

                case 'Grooming':
                    console.log('Generating Grooming form fields');
                    // Match fields with the grooming history table columns
                    formFields = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Date</label>
                                <input type="date" name="grooming[${index}][date]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Services Done</label>
                                <div class="form-selectgroup">
                                    <label class="form-selectgroup-item">
                                        <input type="checkbox" name="grooming[${index}][services][]" value="bath" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label">Bath & Blow Dry</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <input type="checkbox" name="grooming[${index}][services][]" value="haircut" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label">Haircut</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <input type="checkbox" name="grooming[${index}][services][]" value="nail_trim" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label">Nail Trimming</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <input type="checkbox" name="grooming[${index}][services][]" value="teeth" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label">Teeth Brushing</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Products Used</label>
                                <textarea name="grooming[${index}][products]" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Notes</label>
                                <textarea name="grooming[${index}][notes]" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    `;
                    break;

                case 'Surgery':
                    console.log('Generating Surgery form fields');
                    // Match fields with the surgery history table columns
                    formFields = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Surgery Type</label>
                                <select name="surgery[${index}][type]" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="spay">Spay</option>
                                    <option value="neuter">Neuter</option>
                                    <option value="dental">Dental Surgery</option>
                                    <option value="tumor">Tumor Removal</option>
                                    <option value="orthopedic">Orthopedic Surgery</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Anesthesia Used</label>
                                <input type="text" name="surgery[${index}][anesthesia]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Recovery Notes</label>
                                <textarea name="surgery[${index}][recovery_notes]" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>
                    `;
                    break;

                case 'Laboratory':
                    console.log('Generating Laboratory form fields');
                    // Match fields with the laboratory history table columns
                    formFields = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Test Type</label>
                                <select name="laboratory[${index}][test_type]" class="form-select" required>
                                    <option value="">Select Test</option>
                                    <option value="blood_test">Blood Test</option>
                                    <option value="urinalysis">Urinalysis</option>
                                    <option value="xray">X-ray</option>
                                    <option value="ultrasound">Ultrasound</option>
                                    <option value="fecal">Fecal Analysis</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Results</label>
                                <textarea name="laboratory[${index}][results]" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reference Range</label>
                                <textarea name="laboratory[${index}][reference_range]" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Interpretation</label>
                                <textarea name="laboratory[${index}][interpretation]" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    `;
                    break;
                
                default:
                    console.warn(`Unknown reason type: ${reason}`);
            }
            
            if (formFields) {
                console.log(`Creating card for ${reason}`);
                const cardDiv = document.createElement('div');
                cardDiv.className = 'card mb-3';
                cardDiv.innerHTML = `
                    <div class="card-header bg-primary-soft d-flex align-items-center justify-content-between">
                        <h3 class="card-title">${reason} Details</h3>
                        <button type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="card-body">
                            ${formFields}
                    </div>
                `;

                // Add event listener to close button
                cardDiv.querySelector('.btn-close').addEventListener('click', function() {
                    console.log(`Removing ${reason} card`);
                    cardDiv.remove();
                    // Remove from selected reasons
                    const reasonBtn = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
                    if (reasonBtn) {
                        reasonBtn.classList.remove('active');
                    }
                    updateReasonInput();
                });

                console.log(`Appending ${reason} card to service details container`);
                serviceDetailsCard.appendChild(cardDiv);
            } else {
                console.warn(`No form fields generated for ${reason}`);
            }
        });
        
        serviceDetailsCard.style.display = reasons.length > 0 ? 'block' : 'none';
        console.log('Service details form update complete');
    }

    // Add these new functions
    function showServiceHistoryModal(serviceType) {
        console.log('Showing modal for service type:', serviceType);
        
        // Create modal if it doesn't exist
        let modal = document.getElementById('serviceHistoryModal');
        if (!modal) {
            modal = createServiceHistoryModal();
            document.body.appendChild(modal);
        }

        // Update table headers based on service type
        updateServiceHistoryTable(serviceType);

        // Show the modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    function createServiceHistoryModal() {
        const modalDiv = document.createElement('div');
        modalDiv.className = 'modal modal-blur fade';
        modalDiv.id = 'serviceHistoryModal';
        modalDiv.setAttribute('tabindex', '-1');
        modalDiv.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Service History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter" id="serviceHistoryTable">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <td colspan="100%" class="text-center">No records found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        `;
        return modalDiv;
    }

    function updateServiceHistoryTable(serviceType) {
        console.log('Updating service history table for:', serviceType);
        const historiesContainer = document.getElementById('service-histories-container');
        
        // Create or update history section for this service type
        let historySection = document.getElementById(`history-section-${serviceType}`);
        
        if (!historySection) {
            // Create new history section if it doesn't exist
            historySection = document.createElement('div');
            historySection.id = `history-section-${serviceType}`;
            historySection.className = 'card mb-3';
            
            // Define headers and field mappings for each service type
            const serviceConfig = {
                'Vaccination': {
                    headers: ['Date', 'Vaccine Type', 'Batch Number', 'Next Due Date', 'Administered By', 'Reactions'],
                    fields: ['date', 'vaccine_type', 'batch_number', 'next_due_date', 'administered_by', 'reactions']
                },
                'Check-up': {
                    headers: ['Date', 'Service Type', 'Findings', 'Vital Signs', 'Treatment', 'Medications', 'Next Visit'],
                    fields: ['date', 'service_type', 'findings', 'vital_signs', 'treatment', 'medications', 'next_visit']
                },
                'Grooming': {
                    headers: ['Date', 'Services Done', 'Products Used', 'Notes'],
                    fields: ['date', 'services', 'products_used', 'notes']
                },
                'Surgery': {
                    headers: ['Date', 'Surgery Type', 'Anesthesia', 'Recovery Notes'],
                    fields: ['date', 'surgery_type', 'anesthesia', 'recovery_notes']
                },
                'Laboratory': {
                    headers: ['Date', 'Test Type', 'Results', 'Reference Range', 'Interpretation'],
                    fields: ['date', 'test_type', 'results', 'reference_range', 'interpretation']
                }
            };

            const config = serviceConfig[serviceType];
            if (config) {
                historySection.innerHTML = `
                    <div class="card-header bg-primary-soft d-flex justify-content-between align-items-center">
                        <h3 class="card-title">${serviceType} History</h3>
                        <span class="badge bg-primary">${serviceType}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-vcenter card-table table-sm mb-0">
                                <thead class="sticky-top bg-white">
                                    <tr>
                                        ${config.headers.map(header => `<th>${header}</th>`).join('')}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="${config.headers.length}" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                    </svg>
                                                </div>
                                                <p class="empty-title h6">No records found</p>
                                                <p class="empty-subtitle text-secondary small">No previous records found for this service type.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                historiesContainer.appendChild(historySection);
            }
        }

        // Show all history sections
        historiesContainer.style.display = 'block';
    }

    // Update the reason button click handler
    reasonButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const reason = this.dataset.reason;
            const historySection = document.getElementById(`history-section-${reason}`);
            
            if (this.classList.contains('active')) {
                // Deactivating
                this.classList.remove('active');
                selectedReasons.delete(reason);
                if (historySection) {
                    historySection.remove();
                }
            } else {
                // Activating
                this.classList.add('active');
                selectedReasons.add(reason);
                updateServiceHistoryTable(reason);
            }

            updateReasonInput();
            updateServiceDetailsForm(Array.from(selectedReasons));
        });
    });

    // Add new function to update table columns
    function updateTableColumns(serviceType) {
        const thead = document.querySelector('#checkup-history-table thead tr');
        const commonColumns = `
            <th>Date</th>
            <th>Service Type</th>
            <th>Notes</th>
        `;

        let specificColumns = '';
        switch(serviceType) {
            case 'Check-up':
                specificColumns = `
                    <th>Findings/Results</th>
                    <th>Vital Signs</th>
                    <th>Treatment/Procedure</th>
                    <th>Medications</th>
                    <th>Next Visit</th>
                `;
                break;
            case 'Vaccination':
                specificColumns = `
                    <th>Vaccine Type</th>
                    <th>Batch Number</th>
                    <th>Next Due Date</th>
                    <th>Administered By</th>
                    <th>Reactions</th>
                `;
                break;
            case 'Grooming':
                specificColumns = `
                    <th>Services Done</th>
                    <th>Products Used</th>
                    <th>Groomer</th>
                    <th>Special Instructions</th>
                    <th>Before/After Photos</th>
                `;
                break;
            case 'Surgery':
                specificColumns = `
                    <th>Surgery Type</th>
                    <th>Anesthesia Used</th>
                    <th>Surgeon</th>
                    <th>Recovery Notes</th>
                    <th>Follow-up Date</th>
                `;
                break;
            case 'Laboratory':
                specificColumns = `
                    <th>Test Type</th>
                    <th>Results</th>
                    <th>Reference Range</th>
                    <th>Interpretation</th>
                    <th>Recommendations</th>
                `;
                break;
        }

        thead.innerHTML = commonColumns + specificColumns;
    }

    // Update the loadCheckupHistory function to handle all service types
    function loadServiceHistory(petId, serviceType) {
        const tbody = document.getElementById('visitHistoryBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch(`/api/pets/${petId}/service-history/${serviceType}`)
            .then(response => response.json())
            .then(data => {
                if (!data || data.length === 0) {
                    tbody.innerHTML = `
                        <tr class="text-center no-data-row">
                            <td colspan="8">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                        </svg>
                                    </div>
                                    <p class="empty-title">No ${serviceType} records found</p>
                                    <p class="empty-subtitle text-muted">
                                        No previous records found for this category.
                                    </p>
                                </div>
                            </td>
                        </tr>`;
                    return;
                }

                // Render the data based on service type
                tbody.innerHTML = data.map(record => {
                    let specificColumns = '';
                    switch(serviceType) {
                        case 'check-up':
                            specificColumns = `
                                <td>${record.findings || '-'}</td>
                                <td>${record.vital_signs || '-'}</td>
                                <td>${record.treatment || '-'}</td>
                                <td>${record.medications || '-'}</td>
                                <td>${record.next_visit || '-'}</td>
                            `;
                            break;
                        case 'vaccination':
                            specificColumns = `
                                <td>${record.vaccine_type || '-'}</td>
                                <td>${record.batch_number || '-'}</td>
                                <td>${record.next_due_date || '-'}</td>
                                <td>${record.administered_by || '-'}</td>
                                <td>${record.reactions || '-'}</td>
                            `;
                            break;
                        // Add similar cases for other service types
                    }

                    return `
                        <tr>
                            <td>${record.date || '-'}</td>
                            <td>${record.service_type || '-'}</td>
                            <td>${record.notes || '-'}</td>
                            ${specificColumns}
                        </tr>
                    `;
                }).join('');
            })
            .catch(error => {
                console.error('Error loading service history:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            Failed to load service history. Please try again.
                        </td>
                    </tr>`;
            });
    }

    // Update the visit type select options
    document.getElementById('visitTypeSelect').innerHTML = `
        <option value="all">All Records</option>
        <optgroup label="Check-up">
            <option value="routine">Routine Check-up</option>
            <option value="emergency">Emergency</option>
            <option value="follow_up">Follow-up</option>
        </optgroup>
        <optgroup label="Vaccination">
            <option value="anti_rabies">Anti-rabies</option>
            <option value="dhpp">DHPP</option>
            <option value="fvrcp">FVRCP</option>
            <option value="deworming">Deworming</option>
        </optgroup>
        <optgroup label="Grooming">
            <option value="full_grooming">Full Service</option>
            <option value="nail_trim">Nail Trim</option>
            <option value="dental">Dental Care</option>
        </optgroup>
        <optgroup label="Surgery">
            <option value="spay_neuter">Spay/Neuter</option>
            <option value="minor_surgery">Minor Surgery</option>
            <option value="major_surgery">Major Surgery</option>
        </optgroup>
        <optgroup label="Laboratory">
            <option value="blood_test">Blood Test</option>
            <option value="urinalysis">Urinalysis</option>
            <option value="xray">X-ray</option>
        </optgroup>
    `;

    // Add this function to update the display of selected reasons
    function updateSelectedReasonsDisplay() {
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        const emptyReasonText = document.getElementById('empty-reason-text');
        
        selectedReasonsContainer.innerHTML = '';
        
        if (selectedReasons.size > 0) {
            emptyReasonText.style.display = 'none';
            selectedReasons.forEach(reason => {
                const badge = createReasonBadge(reason);
                selectedReasonsContainer.appendChild(badge);
            });
        } else {
            emptyReasonText.style.display = 'block';
        }
    }

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

    // Handle Walk-in Pet Age Unit Change
    const walkinPetAgeInput = document.getElementById('walkin_pet_age');
    const walkinAgeUnitSelect = document.getElementById('walkin_age_unit');
    
    walkinAgeUnitSelect.addEventListener('change', function() {
        if (this.value === 'years') {
            walkinPetAgeInput.setAttribute('max', '30');
        } else {
            walkinPetAgeInput.setAttribute('max', '360');
        }
    });

    // Find the form submission handling code and update it
    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalidField = null;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            firstInvalidField?.focus();
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                text: 'Please fill in all required fields',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Scheduling...
        `;

        try {
            const formData = new FormData(this);
            
            // Submit form data via AJAX
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Appointment Scheduled',
                text: 'The appointment has been successfully scheduled.',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect to appointments list or reload page
                window.location.href = '/appointments';
            });

        } catch (error) {
            console.error('Form submission error:', error);
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
            
            Swal.fire({
                icon: 'error',
                title: 'Submission Error',
                text: 'There was an error scheduling the appointment. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });

    // Set min date to today
    appointmentDate.min = new Date().toISOString().split('T')[0];

    // Function to check if a date is a weekend
    function isWeekend(date) {
        const day = date.getDay();
        return day === 0 || day === 6;
    }

    // Function to disable weekends
    function disableWeekends(e) {
        const selectedDate = new Date(this.value);
        if (isWeekend(selectedDate)) {
            this.value = '';
            // Optional: show a subtle message instead of an alert
            const dateField = this.parentElement;
            let message = dateField.querySelector('.weekend-message');
            if (!message) {
                message = document.createElement('small');
                message.className = 'text-danger weekend-message';
                message.style.display = 'block';
                message.style.marginTop = '0.25rem';
                message.textContent = 'Weekends are not available';
                dateField.appendChild(message);
                setTimeout(() => message.remove(), 3000); // Remove after 3 seconds
            }
        }
    }

    // Add event listeners
    appointmentDate.addEventListener('input', disableWeekends);
    appointmentDate.addEventListener('click', function(e) {
        // Prevent opening calendar if it's a weekend
        const date = new Date(this.value);
        if (this.value && isWeekend(date)) {
            e.preventDefault();
        }
    });

    // Time validation
    appointmentTime.addEventListener('change', function() {
        const selectedDate = appointmentDate.value;
        const selectedTime = this.value;
        
        if (selectedDate === new Date().toISOString().split('T')[0]) {
            const now = new Date();
            const selected = new Date(selectedDate + 'T' + selectedTime);
            
            if (selected <= now) {
                alert('Please select a future time');
                this.value = '';
            }
        }
    });

    // Reset time when date changes
    appointmentDate.addEventListener('change', function() {
        appointmentTime.value = '';
    });

    // Add this after setting min date
    appointmentDate.addEventListener('focus', async function() {
        try {
            const response = await fetch(`/api/appointments/dates`);
            if (!response.ok) throw new Error('Failed to fetch appointments');
            const data = await response.json();
            
            // Create a style element for the date highlights
            let style = document.getElementById('date-highlights');
            if (!style) {
                style = document.createElement('style');
                style.id = 'date-highlights';
                document.head.appendChild(style);
            }

            // Generate CSS rules for date highlighting
            let css = '';
            data.dates.forEach(date => {
                css += `
                    input[type="date"][value="${date}"],
                    input[type="date"]::-webkit-calendar-picker-indicator[value="${date}"] {
                        background-color: rgba(var(--primary-rgb), 0.1);
                    }
                `;
            });
            style.textContent = css;

            // Store booked dates for validation
            this.dataset.bookedDates = JSON.stringify(data.dates);
        } catch (error) {
            console.error('Error fetching appointment dates:', error);
        }
    });

    appointmentDate.addEventListener('change', function() {
        const selectedDate = this.value;
        const bookedDates = JSON.parse(this.dataset.bookedDates || '[]');
        
        if (bookedDates.includes(selectedDate)) {
            // Add a warning message instead of preventing selection
            const dateField = this.parentElement;
            let message = dateField.querySelector('.date-warning');
            if (!message) {
                message = document.createElement('small');
                message.className = 'text-warning date-warning';
                message.style.display = 'block';
                message.style.marginTop = '0.25rem';
                message.textContent = 'Note: This date already has appointments scheduled';
                dateField.appendChild(message);
                setTimeout(() => message.remove(), 5000); // Remove after 5 seconds
            }
        }
        
        // Reset time when date changes
        appointmentTime.value = '';
    });

    // Load history when checkup type changes
    checkupTypeSelect.addEventListener('change', function() {
        categoryHeader.textContent = this.value;
        if (petSelect.value) {
            loadServiceHistory(petSelect.value, this.value);
        }
    });

    // Load history when pet changes
    petSelect.addEventListener('change', function() {
        if (this.value && isCheckupSelected()) {
            loadServiceHistory(this.value, checkupTypeSelect.value);
        }
    });

    function isCheckupSelected() {
        const activeReasonBtn = document.querySelector('.reason-btn[data-reason="Check-up"].active');
        return activeReasonBtn !== null;
    }

    // Get the button and modal elements
    const viewMedicalHistoryBtn = document.querySelector('[data-bs-target="#appointmentModal"]');
    const appointmentModal = document.getElementById('appointmentModal');

    // Add click event listener to the button
    viewMedicalHistoryBtn.addEventListener('click', function() {
        const petId = document.getElementById('pet_id').value;
        const userSelect = document.getElementById('owner_id');
        const petSelect = document.getElementById('pet_id');
        
        if (!petId || userSelect.value === 'no_account') {
            Swal.fire({
                icon: 'warning',
                title: 'No Pet Selected',
                text: 'Please select a registered pet to view medical history.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Update owner and pet details in the modal
        const selectedPet = petSelect.options[petSelect.selectedIndex];
        const petName = selectedPet.text;
        const petType = selectedPet.dataset.type;
        const ownerName = userSelect.options[userSelect.selectedIndex].text;
        
        // Update pet and owner details in the modal
        document.getElementById('owner-details').innerHTML = `
            <div class="d-flex flex-column">
                <span class="fw-bold">${ownerName}</span>
                <span class="badge ${userSelect.value === 'no_account' ? 'bg-yellow-lt' : 'bg-azure-lt'} mt-1">
                    <i class="${userSelect.value === 'no_account' ? 'fas fa-walking' : 'fas fa-user-check'} me-1"></i>
                    ${userSelect.value === 'no_account' ? 'Walk-in' : 'Registered'}
                </span>
            </div>
        `;
        
        document.getElementById('pet-details').innerHTML = `
            <div class="d-flex flex-column">
                <span class="fw-bold">${petName}</span>
                <div class="mt-1">
                    <span class="badge bg-blue-lt">${petType}</span>
                </div>
            </div>
        `;
        
        // Load medical history into the modal
        loadMedicalHistoryForModal(petId);
    });

    function loadMedicalHistoryForModal(petId) {
        // Show loading state
        const tbody = document.getElementById('medicalHistoryBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch(`/api/pets/${petId}/medical-history`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data || data.length === 0) {
                    tbody.innerHTML = `
                        <tr class="text-center">
                            <td colspan="5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">No medical history found</p>
                                <p class="empty-subtitle text-muted">
                                    This pet has no previous medical records.
                                </p>
                            </div>
                        </td>
                    </tr>`;
                    return;
                }

                tbody.innerHTML = data.map(record => `
                    <tr>
                        <td>${new Date(record.date).toLocaleDateString()}</td>
                        <td>${record.service || '-'}</td>
                        <td>${record.diagnosis || '-'}</td>
                        <td>${record.treatment || '-'}</td>
                        <td>${record.notes || '-'}</td>
                    </tr>
                `).join('');
            })
            .catch(error => {
                console.error('Error loading medical history:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Failed to load medical history. Please try again.
                        </td>
                    </tr>`;
            });
    }

    // Add this to trigger the pet details update on page load
    if (petSelect) {
        // Trigger change event to update pet details
        petSelect.dispatchEvent(new Event('change'));
    }
});

// Find the pet selection event listener and update it
document.getElementById('pet_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (!this.value) {
        clearPetDetails();
        return;
    }
    
    // Update pet details fields
    document.getElementById('pet_name').value = selectedOption.text.split(' (')[0] || '';
    document.getElementById('pet_type').value = selectedOption.dataset.type || '';
    document.getElementById('pet_age').value = selectedOption.dataset.age || '';
    document.getElementById('pet_weight').value = selectedOption.dataset.weight || '';
    document.getElementById('pet_gender').value = selectedOption.dataset.gender || '';
});

// Update owner avatar when owner is selected
const ownerSelect = document.getElementById('owner_id');
const ownerAvatar = document.getElementById('owner_avatar');

ownerSelect.addEventListener('change', async function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (selectedOption.value === 'no_account') {
        ownerAvatar.src = '/storage/defaults/avatar.png';
    } else if (selectedOption.value) {
        try {
            const response = await fetch(`/api/owners/${selectedOption.value}`);
            if (!response.ok) throw new Error('Failed to fetch owner data');
            const ownerData = await response.json();
            
            // Update owner avatar with actual photo or default
            ownerAvatar.src = ownerData.photo ? 
                '/storage/' + ownerData.photo : 
                '/storage/defaults/avatar.png';
        } catch (error) {
            console.error('Error:', error);
            ownerAvatar.src = '/storage/defaults/avatar.png';
        }
    } else {
        ownerAvatar.src = '/storage/defaults/avatar.png';
    }
});

// Update pet photo when pet is selected
const petSelect = document.getElementById('pet_id');
const petAvatar = document.getElementById('pet_avatar');

petSelect.addEventListener('change', async function() {
    const selectedOption = this.options[this.selectedIndex];
    const dynamicAvatar = document.getElementById('dynamic_avatar'); // Get the avatar element
    
    if (!dynamicAvatar) {
        console.error('Dynamic avatar element not found');
        return;
    }
    
    if (selectedOption && selectedOption.value) {
        try {
            const response = await fetch(`/api/pets/${selectedOption.value}`);
            if (!response.ok) throw new Error('Failed to fetch pet data');
            const petData = await response.json();
            
            // Update pet avatar with actual photo or default
            dynamicAvatar.src = petData.photo ? 
                '/storage/' + petData.photo : 
                '/storage/defaults/paw.png';
                
            // Update pet details
            updatePetDetails(petData);
        } catch (error) {
            console.error('Error:', error);
            if (dynamicAvatar) {
                dynamicAvatar.src = '/storage/defaults/paw.png';
            }
        }
    } else {
        if (dynamicAvatar) {
            dynamicAvatar.src = '/storage/defaults/paw.png';
        }
        clearPetDetails();
    }
});

// Function to update pets dropdown
function updatePetsDropdown(pets) {
    const petSelect = document.getElementById('pet_id');
    if (!petSelect) return;

    petSelect.innerHTML = '<option value="">Select Pet</option>';
    pets.forEach(pet => {
        const option = document.createElement('option');
        option.value = pet.id;
        option.textContent = `${pet.name} (${pet.category})`;
        
        // Set data attributes
        option.setAttribute('data-photo', pet.photo ? '/storage/' + pet.photo : '/storage/defaults/paw.png');
        option.setAttribute('data-name', pet.name || '');
        option.setAttribute('data-category', pet.category || '');
        option.setAttribute('data-breed', pet.breed || '');
        option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
        option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
        option.setAttribute('data-gender', pet.gender ? pet.gender.toLowerCase() : '');
        
        petSelect.appendChild(option);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('owner_id');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameDisplay = document.getElementById('owner_name_display');
    const ownerNameValue = document.getElementById('owner_name_value');
    const ownerNameInput = document.getElementById('owner_name');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    userSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        // Toggle visibility of pet selection and owner name display
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameDisplay.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        // Update owner name display when input changes
        if (isWalkIn) {
            ownerNameInput.addEventListener('input', function() {
                ownerNameValue.textContent = this.value || 'Not specified';
            });
        }
    });

    // Initialize owner name display if walk-in is selected on page load
    if (userSelect.value === 'no_account') {
        petSelectContainer.style.display = 'none';
        ownerNameDisplay.style.display = 'block';
        registeredPetDetails.style.display = 'none';
        ownerNameValue.textContent = ownerNameInput.value || 'Not specified';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const ownerAvatar = document.getElementById('owner_avatar');
    const dynamicAvatar = document.getElementById('dynamic_avatar');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameContainer = document.getElementById('owner_name_container');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    // Define default image paths
    const defaultAvatarPath = '/storage/defaults/avatar.png';
    const defaultPawPath = '/storage/defaults/paw.png';

    ownerSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        // Toggle visibility
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameContainer.style.display = isWalkIn ? 'block' : 'none';
        walkinPetGroup.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        // Update avatars
        if (isWalkIn) {
            ownerAvatar.src = defaultAvatarPath;
            ownerAvatar.alt = 'Default Owner Avatar';
            // Change this line to show avatar instead of paw for walk-in owner name
            dynamicAvatar.src = defaultAvatarPath;
            dynamicAvatar.alt = 'Walk-in Owner Avatar';
        } else {
            // Update owner avatar if a registered owner is selected
            const selectedOption = this.options[this.selectedIndex];
            ownerAvatar.src = selectedOption.dataset.avatar || defaultAvatarPath;
            ownerAvatar.alt = selectedOption.text + ' Avatar';
            
            dynamicAvatar.src = defaultPawPath;
            dynamicAvatar.alt = 'Select Pet Avatar';
        }
        
        // Toggle required fields
        const ownerNameInput = document.getElementById('owner_name');
        const petSelect = document.getElementById('pet_id');
        
        if (isWalkIn) {
            ownerNameInput.setAttribute('required', 'required');
            petSelect.removeAttribute('required');
            
            // Add input event listener for owner name to update dynamic avatar alt text
            ownerNameInput.addEventListener('input', function() {
                if (this.value) {
                    dynamicAvatar.alt = `${this.value}'s Avatar`;
                } else {
                    dynamicAvatar.alt = 'Walk-in Owner Avatar';
                }
            });
        } else {
            ownerNameInput.removeAttribute('required');
            petSelect.setAttribute('required', 'required');
        }
    });

    // Initialize form state on page load
    if (ownerSelect.value === 'no_account') {
        ownerSelect.dispatchEvent(new Event('change'));
    }

    // Handle pet selection changes
    const petSelect = document.getElementById('pet_id');
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            dynamicAvatar.src = selectedOption.dataset.photo || defaultPawPath;
            dynamicAvatar.alt = selectedOption.text + ' Avatar';
        } else {
            dynamicAvatar.src = defaultPawPath;
            dynamicAvatar.alt = 'Default Pet Avatar';
        }
    });
});

// Add this function at the beginning of your script
function updatePetDetails(selectedOption) {
    if (!selectedOption) return;
    
    const dataset = selectedOption.dataset;
    console.log('Selected pet dataset:', dataset);

    // Get references to elements
    const petPhotoElement = document.getElementById('pet-photo');
    const petNameElement = document.getElementById('pet-name');
    const petCategoryElement = document.getElementById('pet-category');
    const petBreedElement = document.getElementById('pet-breed');
    const petAgeElement = document.getElementById('pet-age');
    const petWeightElement = document.getElementById('pet-weight');
    const petGenderElement = document.getElementById('pet-gender');

    // Update elements if they exist
    if (petPhotoElement) {
        petPhotoElement.src = dataset.photo || '/path/to/default-image.jpg';
        petPhotoElement.alt = `Photo of ${dataset.name}`;
    }

    if (petNameElement) petNameElement.textContent = dataset.name || '';
    if (petCategoryElement) petCategoryElement.textContent = dataset.category || '';
    if (petBreedElement) petBreedElement.textContent = dataset.breed || '';
    if (petAgeElement) petAgeElement.textContent = dataset.age ? `${dataset.age} years` : '';
    if (petWeightElement) petWeightElement.textContent = dataset.weight ? `${dataset.weight} kg` : '';
    if (petGenderElement) petGenderElement.textContent = dataset.gender || '';
}

// Update the pet select event listener
document.getElementById('pet_id').addEventListener('change', function(e) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    console.log('Selected pet option:', selectedOption);
    
    updatePetDetails(selectedOption);
});

// Add this new function after the reason button click handler
function updateServiceDetailsForm(reasons) {
    console.log('Updating service details form with reasons:', reasons);
    const serviceDetailsCard = document.getElementById('service-details-card');
    
    if (!serviceDetailsCard) {
        console.error('Service details card element not found!');
        return;
    }
    
    // If reasons is a string, convert it to an array
    if (typeof reasons === 'string') {
        reasons = [reasons];
    }
    
    console.log('Clearing existing content');
    serviceDetailsCard.innerHTML = '';
    
    // Create forms for each selected reason
    reasons.forEach((reason, index) => {
        console.log(`Creating form fields for ${reason} (index: ${index})`);
    let formFields = '';
        
        switch(reason) {
            case 'Vaccination':
                console.log('Generating Vaccination form fields');
                formFields = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M17 3l4 4"></path>
                                    <path d="M19 5l-4.5 4.5"></path>
                                    <path d="M11.5 6.5l6 6"></path>
                                    <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                    <path d="M7.5 12.5l1.5 1.5"></path>
                                    <path d="M10.5 9.5l1.5 1.5"></path>
                                    <path d="M3 21l3 -3"></path>
                                </svg>
                                Vaccine Type
                            </label>
                            <select name="vaccine[${index}][type]" class="form-select" required>
                                <option value="">Select Vaccine</option>
                                <option value="anti_rabies">Anti-rabies</option>
                                <option value="dhpp">DHPP</option>
                                <option value="fvrcp">FVRCP</option>
                                <option value="deworming">Deworming</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                    <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                    <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M5 11h1v2h-1z"></path>
                                    <path d="M10 11l0 2"></path>
                                    <path d="M14 11h1v2h-1z"></path>
                                    <path d="M19 11l0 2"></path>
                                </svg>
                                Batch Number
                            </label>
                            <input type="text" name="vaccine[${index}][batch_number]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M11 15h1"></path>
                                    <path d="M12 15v3"></path>
                                </svg>
                                Next Due Date
                            </label>
                            <input type="date" name="vaccine[${index}][next_due_date]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                </svg>
                                Administered By
                            </label>
                            <input type="text" name="vaccine[${index}][administered_by]" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M9 7l6 0"></path>
                                    <path d="M9 11l6 0"></path>
                                    <path d="M9 15l4 0"></path>
                                </svg>
                                Reactions
                            </label>
                            <textarea name="vaccine[${index}][reactions]" class="form-control" rows="2" placeholder="Enter any reactions or notes here..."></textarea>
                        </div>
                    </div>
                `;
                break;
            
            case 'Check-up':
                console.log('Generating Check-up form fields');
                // Match fields with the check-up history table columns
            formFields = `
                <div class="row g-3">
                    <div class="col-md-6">
                            <label class="form-label required">Date</label>
                            <input type="date" name="checkup[${index}][date]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Service Type</label>
                            <select name="checkup[${index}][service_type]" class="form-select" required>
                                <option value="routine">Routine Check-up</option>
                                <option value="follow_up">Follow-up</option>
                                <option value="emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label required">Findings/Results</label>
                            <textarea name="checkup[${index}][findings]" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label required">Vital Signs</label>
                            <textarea name="checkup[${index}][vital_signs]" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label required">Treatment/Procedure</label>
                            <textarea name="checkup[${index}][treatment]" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Medications</label>
                            <textarea name="checkup[${index}][medications]" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Next Visit</label>
                            <input type="date" name="checkup[${index}][next_visit]" class="form-control" required>
                    </div>
                    <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="checkup[${index}][notes]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            `;
            break;
            
        case 'Grooming':
                console.log('Generating Grooming form fields');
                // Match fields with the grooming history table columns
            formFields = `
                <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Date</label>
                            <input type="date" name="grooming[${index}][date]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Services Done</label>
                        <div class="form-selectgroup">
                            <label class="form-selectgroup-item">
                                    <input type="checkbox" name="grooming[${index}][services][]" value="bath" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Bath & Blow Dry</span>
                            </label>
                            <label class="form-selectgroup-item">
                                    <input type="checkbox" name="grooming[${index}][services][]" value="haircut" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Haircut</span>
                            </label>
                            <label class="form-selectgroup-item">
                                    <input type="checkbox" name="grooming[${index}][services][]" value="nail_trim" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Nail Trimming</span>
                            </label>
                            <label class="form-selectgroup-item">
                                    <input type="checkbox" name="grooming[${index}][services][]" value="teeth" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Teeth Brushing</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label required">Products Used</label>
                            <textarea name="grooming[${index}][products]" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label">Notes</label>
                            <textarea name="grooming[${index}][notes]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            `;
            break;
            
        case 'Surgery':
                console.log('Generating Surgery form fields');
                // Match fields with the surgery history table columns
            formFields = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Surgery Type</label>
                            <select name="surgery[${index}][type]" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="spay">Spay</option>
                            <option value="neuter">Neuter</option>
                            <option value="dental">Dental Surgery</option>
                            <option value="tumor">Tumor Removal</option>
                            <option value="orthopedic">Orthopedic Surgery</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label required">Anesthesia Used</label>
                            <input type="text" name="surgery[${index}][anesthesia]" class="form-control" required>
                    </div>
                        <div class="col-md-6">
                            <label class="form-label required">Recovery Notes</label>
                            <textarea name="surgery[${index}][recovery_notes]" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
            `;
            break;
            
        case 'Laboratory':
                console.log('Generating Laboratory form fields');
                // Match fields with the laboratory history table columns
            formFields = `
                <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Test Type</label>
                            <select name="laboratory[${index}][test_type]" class="form-select" required>
                                <option value="">Select Test</option>
                                <option value="blood_test">Blood Test</option>
                                <option value="urinalysis">Urinalysis</option>
                                <option value="xray">X-ray</option>
                                <option value="ultrasound">Ultrasound</option>
                                <option value="fecal">Fecal Analysis</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Results</label>
                            <textarea name="laboratory[${index}][results]" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label">Reference Range</label>
                            <textarea name="laboratory[${index}][reference_range]" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label">Interpretation</label>
                            <textarea name="laboratory[${index}][interpretation]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            `;
            break;
                
            default:
                console.warn(`Unknown reason type: ${reason}`);
    }

    if (formFields) {
            console.log(`Creating card for ${reason}`);
            const cardDiv = document.createElement('div');
            cardDiv.className = 'card mb-3';
            cardDiv.innerHTML = `
                <div class="card-header bg-primary-soft d-flex align-items-center justify-content-between">
                    <h3 class="card-title">${reason} Details</h3>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    ${formFields}
            </div>
        `;

            // Add event listener to close button
            cardDiv.querySelector('.btn-close').addEventListener('click', function() {
                console.log(`Removing ${reason} card`);
                cardDiv.remove();
                // Remove from selected reasons
                const reasonBtn = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
                if (reasonBtn) {
                    reasonBtn.classList.remove('active');
                }
                updateReasonInput();
            });

            console.log(`Appending ${reason} card to service details container`);
            serviceDetailsCard.appendChild(cardDiv);
    } else {
            console.warn(`No form fields generated for ${reason}`);
    }
    });
    
    serviceDetailsCard.style.display = reasons.length > 0 ? 'block' : 'none';
    console.log('Service details form update complete');
}

// Update the reason button click handler to call the new function
reasonButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        console.log('Reason button clicked');
        const reason = this.dataset.reason;
        console.log('Selected reason:', reason);

        if (this.classList.contains('active')) {
            console.log('Button is already active, deactivating');
            this.classList.remove('active');
            selectedReasons.delete(reason);
        } else {
            console.log('Button is inactive, activating');
            this.classList.add('active');
            selectedReasons.add(reason);
        }

        console.log('Current selected reasons:', Array.from(selectedReasons));
        updateReasonInput();

        // Update both service details form and history
        const activeReasons = Array.from(selectedReasons);
            if (activeReasons.length > 0) {
            console.log('Updating form with active reasons:', activeReasons);
            updateServiceDetailsForm(activeReasons);
            // Show service history for the selected reason
            updateServiceHistoryTable(reason);
            document.getElementById('service-history-section').style.display = 'block';
            } else {
            console.log('No active reasons, hiding service details and history');
                document.getElementById('service-details-card').style.display = 'none';
            document.getElementById('service-history-section').style.display = 'none';
        }
    });
});

// Add function to update service history table
function updateServiceHistoryTable(serviceType) {
    console.log('Updating service history table for:', serviceType);
    const historiesContainer = document.getElementById('service-histories-container');
    
    // Create or update history section for this service type
    let historySection = document.getElementById(`history-section-${serviceType}`);
    
    if (!historySection) {
        // Create new history section if it doesn't exist
        historySection = document.createElement('div');
        historySection.id = `history-section-${serviceType}`;
        historySection.className = 'card mb-3';
        
        // Define headers and field mappings for each service type
        const serviceConfig = {
            'Vaccination': {
                headers: ['Date', 'Vaccine Type', 'Batch Number', 'Next Due Date', 'Administered By', 'Reactions'],
                fields: ['date', 'vaccine_type', 'batch_number', 'next_due_date', 'administered_by', 'reactions']
            },
            'Check-up': {
                headers: ['Date', 'Service Type', 'Findings', 'Vital Signs', 'Treatment', 'Medications', 'Next Visit'],
                fields: ['date', 'service_type', 'findings', 'vital_signs', 'treatment', 'medications', 'next_visit']
            },
            'Grooming': {
                headers: ['Date', 'Services Done', 'Products Used', 'Notes'],
                fields: ['date', 'services', 'products_used', 'notes']
            },
            'Surgery': {
                headers: ['Date', 'Surgery Type', 'Anesthesia', 'Recovery Notes'],
                fields: ['date', 'surgery_type', 'anesthesia', 'recovery_notes']
            },
            'Laboratory': {
                headers: ['Date', 'Test Type', 'Results', 'Reference Range', 'Interpretation'],
                fields: ['date', 'test_type', 'results', 'reference_range', 'interpretation']
            }
        };

        const config = serviceConfig[serviceType];
        if (config) {
            historySection.innerHTML = `
                <div class="card-header bg-primary-soft d-flex justify-content-between align-items-center">
                    <h3 class="card-title">${serviceType} History</h3>
                    <span class="badge bg-primary">${serviceType}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-vcenter card-table table-sm mb-0">
                            <thead class="sticky-top bg-white">
                                <tr>
                                    ${config.headers.map(header => `<th>${header}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="${config.headers.length}" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                </svg>
                                            </div>
                                            <p class="empty-title h6">No records found</p>
                                            <p class="empty-subtitle text-secondary small">No previous records found for this service type.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            historiesContainer.appendChild(historySection);
        }
    }

    // Show all history sections
    historiesContainer.style.display = 'block';
}

// Update the reason button click handler
reasonButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const reason = this.dataset.reason;
        const historySection = document.getElementById(`history-section-${reason}`);
        
        if (this.classList.contains('active')) {
            // Deactivating
            this.classList.remove('active');
            selectedReasons.delete(reason);
            if (historySection) {
                historySection.remove();
            }
        } else {
            // Activating
            this.classList.add('active');
            selectedReasons.add(reason);
            updateServiceHistoryTable(reason);
        }

        updateReasonInput();
        updateServiceDetailsForm(Array.from(selectedReasons));
    });
});

// Add function to update service history table
function updateServiceHistoryTable(serviceType) {
    console.log('Updating service history table for:', serviceType);
    const tableHeaders = document.getElementById('history-table-headers');
    const tableBody = document.getElementById('service-history-table-body');
    const serviceBadge = document.getElementById('service-type-badge');
    
    // Show the service history section
    document.getElementById('service-history-section').style.display = 'block';
    
    // Update service type badge
    serviceBadge.textContent = serviceType;
    
    // Define headers and field mappings for each service type
    const serviceConfig = {
        'Vaccination': {
            headers: ['Date', 'Vaccine Type', 'Batch Number', 'Next Due Date', 'Administered By', 'Reactions'],
            fields: ['date', 'vaccine_type', 'batch_number', 'next_due_date', 'administered_by', 'reactions']
        },
        'Check-up': {
            headers: ['Date', 'Service Type', 'Findings', 'Vital Signs', 'Treatment', 'Medications', 'Next Visit'],
            fields: ['date', 'service_type', 'findings', 'vital_signs', 'treatment', 'medications', 'next_visit']
        },
        'Grooming': {
            headers: ['Date', 'Services Done', 'Products Used', 'Notes'],
            fields: ['date', 'services', 'products_used', 'notes']
        },
        'Surgery': {
            headers: ['Date', 'Surgery Type', 'Anesthesia', 'Recovery Notes'],
            fields: ['date', 'surgery_type', 'anesthesia', 'recovery_notes']
        },
        'Laboratory': {
            headers: ['Date', 'Test Type', 'Results', 'Reference Range', 'Interpretation'],
            fields: ['date', 'test_type', 'results', 'reference_range', 'interpretation']
        }
    };

    // Update table headers based on service type
    if (serviceConfig[serviceType]) {
        tableHeaders.innerHTML = serviceConfig[serviceType].headers
            .map(header => `<th>${header}</th>`)
            .join('');
        
        // Update colspan for empty state
        const emptyStateRow = tableBody.querySelector('tr');
        if (emptyStateRow) {
            emptyStateRow.querySelector('td').setAttribute('colspan', serviceConfig[serviceType].headers.length);
        }
    }
}
</script>

<!-- Add this script section after your existing scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const ownerAvatar = document.getElementById('owner_avatar');
    const petSelect = document.getElementById('pet_id');
    const petAvatar = document.getElementById('pet_avatar');
    const ownerNameGroup = document.getElementById('owner_name_group');
    const petSelectionGroup = document.getElementById('pet_selection_group');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    // Function to handle owner selection
    ownerSelect.addEventListener('change', async function() {
        console.log('Owner selection changed');
        console.log('Selected value:', this.value);
        console.log('Selected option:', this.options[this.selectedIndex]);

        const selectedOption = this.options[this.selectedIndex];
        
        // Debug elements existence
        console.log('Elements check:', {
            ownerNameGroup: document.getElementById('owner_name_group'),
            petSelectionGroup: document.getElementById('pet_selection_group'),
            walkinPetGroup: document.getElementById('walkin_pet_group'),
            registeredPetDetails: document.getElementById('registered_pet_details')
        });

        if (selectedOption.value === 'no_account') {
            console.log('Walk-in customer selected');
            ownerAvatar.src = '/storage/defaults/avatar.png';
            
            // Add null checks before accessing style
            const ownerNameGroup = document.getElementById('owner_name_group');
            const petSelectionGroup = document.getElementById('pet_selection_group');
            const walkinPetGroup = document.getElementById('walkin_pet_group');
            const registeredPetDetails = document.getElementById('registered_pet_details');

            if (ownerNameGroup) ownerNameGroup.style.display = 'block';
            if (petSelectionGroup) petSelectionGroup.style.display = 'block';
            if (walkinPetGroup) walkinPetGroup.style.display = 'block';
            if (registeredPetDetails) registeredPetDetails.style.display = 'none';
            
            petSelect.innerHTML = '<option value="">Select Pet</option>';
        } else if (selectedOption.value) {
            console.log('Registered owner selected, fetching data...');
            try {
                // Fetch owner details
                const response = await fetch(`/api/owners/${selectedOption.value}`);
                console.log('Owner API response:', response);
                
                if (!response.ok) {
                    console.error('API response not ok:', response.status, response.statusText);
                    throw new Error('Failed to fetch owner data');
                }
                
                const ownerData = await response.json();
                console.log('Owner data received:', ownerData);
                
                // Update owner avatar
                ownerAvatar.src = ownerData.avatar_url || '/storage/defaults/avatar.png';
                
                // Fetch and update pets dropdown
                console.log('Fetching pets data...');
                const petsResponse = await fetch(`/api/owners/${selectedOption.value}/pets`);
                console.log('Pets API response:', petsResponse);
                
                if (!petsResponse.ok) {
                    console.error('Pets API response not ok:', petsResponse.status, petsResponse.statusText);
                    throw new Error('Failed to fetch pets data');
                }
                
                const petsData = await petsResponse.json();
                console.log('Pets data received:', petsData);
                
                // Update pets dropdown
                updatePetsDropdown(petsData);
                
                // Show/hide appropriate sections with null checks
                const ownerNameGroup = document.getElementById('owner_name_group');
                const petSelectionGroup = document.getElementById('pet_selection_group');
                const walkinPetGroup = document.getElementById('walkin_pet_group');
                const registeredPetDetails = document.getElementById('registered_pet_details');

                if (ownerNameGroup) ownerNameGroup.style.display = 'none';
                if (petSelectionGroup) petSelectionGroup.style.display = 'block';
                if (walkinPetGroup) walkinPetGroup.style.display = 'none';
                if (registeredPetDetails) registeredPetDetails.style.display = 'block';
                
            } catch (error) {
                console.error('Error in owner selection:', error);
                console.error('Error stack:', error.stack);
                // Show error notification
                showNotification('error', 'Failed to fetch owner data');
            }
        } else {
            console.log('No owner selected, resetting form');
            resetForm();
        }
    });

    // Helper Functions
    function updatePetsDropdown(pets) {
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        pets.forEach(pet => {
            const option = document.createElement('option');
            option.value = pet.id;
            option.textContent = `${pet.name} (${pet.category})`;
            option.dataset.photo = pet.photo_url || '/img/default-pet.png';
            option.dataset.name = pet.name;
            option.dataset.category = pet.category;
            option.dataset.breed = pet.breed;
            option.dataset.age = pet.age;
            option.dataset.weight = pet.weight;
            option.dataset.gender = pet.gender.toLowerCase();
            petSelect.appendChild(option);
        });
    }

    function resetForm() {
        ownerAvatar.src = '/storage/defaults/avatar.png';
        ownerNameGroup.style.display = 'none';
        petSelectionGroup.style.display = 'block';
        walkinPetGroup.style.display = 'none';
        registeredPetDetails.style.display = 'none';
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        resetPetDetails();
    }

    function showNotification(type, message) {
        // You can implement this using your preferred notification library
        // For example, using SweetAlert2:
        Swal.fire({
            icon: type,
            title: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('page-styles'); ?>
<style>
:root {
    --primary-color: #4361ee;
    --primary-light: #eef2ff;
    --primary-dark: #3a4db4;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    border-radius: 12px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.6rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.btn-soft {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background-color: var(--primary-light);
    color: var(--primary-color);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-soft .icon {
    stroke-width: 1.5;
    transition: all 0.2s ease;
}

.btn-soft:hover .icon,
.btn-soft.active .icon {
    stroke: white;
}

.btn-soft:hover {
    background-color: var(--primary-color);
    color: white;
}

.btn-soft.active {
    background-color: var(--primary-color);
    color: white;
}

.badge {
    background-color: var(--primary-light);
    color: var(--primary-color);
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
}

.required:after {
    content: ' *';
    color: #dc3545;
}

.form-label {
    font-weight: 500;
    color: #444;
    margin-bottom: 0.5rem;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] {
    --primary-light: rgba(67, 97, 238, 0.15);
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    border-color: rgba(255,255,255,0.1);
    background-color: rgba(0,0,0,0.2);
}

[data-bs-theme="dark"] .form-label {
    color: rgba(255,255,255,0.9);
}

[data-bs-theme="dark"] .btn-soft {
    background-color: rgba(67, 97, 238, 0.15);
    color: #8ba4f9;
}

[data-bs-theme="dark"] .btn-soft:hover,
[data-bs-theme="dark"] .btn-soft.active {
    background-color: var(--primary-color);
    color: white;
}

[data-bs-theme="dark"] .btn-soft .icon {
    stroke: #8ba4f9;
}

[data-bs-theme="dark"] .btn-soft:hover .icon,
[data-bs-theme="dark"] .btn-soft.active .icon {
    stroke: white;
}

.bg-primary-soft {
    background-color: var(--primary-light);
    color: var(--primary-color);
}

.btn-close {
    padding: 0.25rem;
    margin-left: 0.25rem;
}

.selected-reasons-box {
    border: 1px solid var(--primary-light);
    border-radius: 8px;
    padding: 1rem;
    min-height: 60px;
    margin-top: 0.5rem;
    background-color: rgba(var(--primary-rgb), 0.02);
    position: relative;
}

.selected-reasons-box:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

#empty-reason-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    transition: opacity 0.2s ease;
}

#selected-reasons:not(:empty) + #empty-reason-text {
    opacity: 0;
}

.badge {
    background-color: var(--primary-color);
    color: white;
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge .btn-close {
    padding: 0.25rem;
    margin-left: 0.25rem;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.badge .btn-close:hover {
    opacity: 1;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .selected-reasons-box {
    background-color: rgba(67, 97, 238, 0.05);
    border-color: rgba(67, 97, 238, 0.2);
}

[data-bs-theme="dark"] #empty-reason-text {
    color: rgba(255, 255, 255, 0.5);
}

:root {
    --primary-rgb: 67, 97, 238;
}

/* Add these new styles */
input[type="date"] {
    position: relative;
    cursor: pointer;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    position: absolute;
    right: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    color: transparent;
    cursor: pointer;
}

.date-warning {
    font-size: 0.875rem;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] input[type="date"][data-booked="true"] {
    background-color: rgba(67, 97, 238, 0.15);
}

.form-section {
    min-height: 450px;
    overflow-y: auto;
}

.diagnosis-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 3.5rem);
}

.modal-content {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.form-control-plaintext {
    padding: 0.5rem;
    background-color: var(--tblr-bg-surface);
    border-radius: 4px;
    min-height: 40px;
}

.form-sections {
    background-color: var(--tblr-bg-surface);
    border-color: var(--tblr-border-color) !important;
}

.form-section {
    transition: all 0.3s ease;
}

.btn-group .btn {
    flex: 1;
}

.card-header.bg-primary {
    background-color: var(--primary-color) !important;
}

.card-header.bg-primary .card-title {
    color: white;
}

.form-sections {
    min-height: 300px;
    position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .diagnosis-group {
        grid-template-columns: 1fr;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 4px !important;
        margin-bottom: 0.25rem;
    }
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.input-group-text {
    padding: 0.25rem;
}

.card {
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

.form-label {
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.input-group {
    position: relative;
}

.input-group .form-control:not(:first-child) {
    padding-left: 3rem;
}

.input-group .avatar {
    margin-right: 0.5rem;
}

.avatar-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-lg {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card {
    border: 1px solid rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .avatar-lg {
    border-color: rgba(255,255,255,0.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

[data-bs-theme="dark"] .card {
    border-color: rgba(255,255,255,0.1);
}

#registered_pet_details {
    transition: all 0.3s ease;
}

#registered_pet_details .card {
    height: 300px; /* Fixed height */
    display: flex;
    flex-direction: column;
    margin-bottom: 0;
}

#registered_pet_details .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

#registered_pet_details .row {
    flex: 1;
}

/* Add these styles for the pet selection/owner name switch */
#pet_select_container,
#owner_name_group {
    transition: opacity 0.3s ease;
}

.form-control[readonly] {
    background-color: var(--tblr-bg-surface);
    opacity: 0.8;
}

/* Add these new styles */
.bg-primary-soft {
    background-color: rgba(var(--primary-rgb), 0.1);
    color: var(--primary-color);
}

.card-header .icon {
    width: 24px;
    height: 24px;
    stroke-width: 1.5;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-weight: 500;
}

.form-label .icon {
    width: 18px;
    height: 18px;
    stroke-width: 1.5;
    opacity: 0.8;
}

.card-header.bg-primary-soft {
    border-bottom: 1px solid rgba(var(--primary-rgb), 0.1);
}

#registered_pet_details .form-control[readonly],
#registered_pet_details .form-select[disabled] {
    background-color: rgba(var(--primary-rgb), 0.03);
    border-color: rgba(var(--primary-rgb), 0.1);
    color: var(--tblr-body-color);
    opacity: 1;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .bg-primary-soft {
    background-color: rgba(var(--primary-rgb), 0.15);
}

[data-bs-theme="dark"] .form-label {
    color: rgba(255, 255, 255, 0.8);
}

[data-bs-theme="dark"] #registered_pet_details .form-control[readonly],
[data-bs-theme="dark"] #registered_pet_details .form-select[disabled] {
    background-color: rgba(var(--primary-rgb), 0.1);
    border-color: rgba(var(--primary-rgb), 0.2);
    color: rgba(255, 255, 255, 0.8);
}

.form-selectgroup {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.form-selectgroup-item {
    margin: 0;
}

.form-selectgroup-input {
    position: absolute;
    opacity: 0;
}

.form-selectgroup-label {
    display: block;
    padding: 0.5rem 1rem;
    border: 1px solid var(--tblr-border-color);
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-selectgroup-input:checked + .form-selectgroup-label {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.form-selectgroup-input:focus + .form-selectgroup-label {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.25);
}

#service-details-card {
    transition: all 0.3s ease;
}

#service-details-card .card {
    margin-bottom: 0;
}

/* Add these new styles for multiple service cards */
#service-details-card .card {
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

#service-details-card .card:last-child {
    margin-bottom: 0;
}

.card-header .btn-action {
    padding: 0.25rem;
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.card-header .btn-action[aria-expanded="false"] {
    transform: rotate(-90deg);
}

.collapse {
    transition: all 0.3s ease;
}

/* Adjust spacing between multiple cards */
#service-details-card .card + .card {
    margin-top: 1rem;
}

/* Style for nested form groups */
.service-form-group {
    border-left: 3px solid var(--primary-color);
    padding-left: 1rem;
    margin-bottom: 1.5rem;
}

.service-form-group:last-child {
    margin-bottom: 0;
}

/* Add visual separation between different service types */
.card-header {
    border-bottom: 1px solid rgba(var(--primary-rgb), 0.1);
}

/* Improve form layout on mobile */
@media (max-width: 768px) {
    .row.g-3 > [class*="col-"] {
        margin-bottom: 1rem;
    }
}

/* Add these styles to your existing CSS */
.table-sm th, .table-sm td {
    padding: 0.3rem;
    font-size: 0.875rem;
}

.sticky-top {
    z-index: 1020;
}

/* Make the service history table more compact */
#service-history-section .card-header {
    padding: 0.5rem 1rem;
}

#service-history-section .card-title {
    font-size: 1rem;
    margin: 0;
}

#service-history-section .empty {
    padding: 1rem;
}

#service-history-section .empty-icon {
    width: 2rem;
    height: 2rem;
    margin-bottom: 0.5rem;
}

#service-history-section .empty-title {
    margin-bottom: 0.25rem;
}

#service-history-section .empty-subtitle {
    font-size: 0.75rem;
}

/* Make service details cards more compact */
#service-details-card .card {
    margin-bottom: 1rem;
}

#service-details-card .card-header {
    padding: 0.5rem 1rem;
}

#service-details-card .card-body {
    padding: 1rem;
}

#service-details-card .form-label {
    margin-bottom: 0.25rem;
}

#service-details-card .form-control,
#service-details-card .form-select {
    padding: 0.25rem 0.5rem;
}

/* Adjust spacing in the grid */
.row.g-3 {
    --bs-gutter-y: 0.5rem;
}

/* Update the service history styles */
#service-history-section {
    height: calc(100vh - 300px); /* Adjust the height as needed */
    display: flex;
    flex-direction: column;
}

#service-history-section .card-body {
    flex: 1;
    overflow: hidden;
}

#service-history-section .table-responsive {
    height: 100%;
}

#service-history-section table {
    margin-bottom: 0;
}

#service-history-section th {
    background: var(--tblr-bg-surface);
    position: sticky;
    top: 0;
    z-index: 1;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#service-type-badge {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Make the history section sticky */
@media (min-width: 992px) {
    #service-history-section {
        position: sticky;
        top: 1rem;
    }
}

/* Update service histories container styles */
#service-histories-container {
    display: none;
}

#service-histories-container .card {
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

#service-histories-container .card:last-child {
    margin-bottom: 0;
}

#service-histories-container .card-header {
    padding: 0.5rem 1rem;
    background-color: var(--tblr-bg-surface);
}

#service-histories-container .table-responsive {
    border-radius: 0 0 4px 4px;
}

#service-histories-container .empty {
    padding: 1.5rem;
}

#service-histories-container .empty-icon {
    width: 1.5rem;
    height: 1.5rem;
    margin-bottom: 0.5rem;
}

/* Adjust column widths for better layout */
@media (min-width: 992px) {
    .col-lg-5 {
        width: 40%;
    }
    .col-lg-7 {
        width: 60%;
    }
}

#service-details-container {
    position: relative;
    margin-top: 1rem;
}

#vaccination-details {
    margin-bottom: 1rem;
}

/* Maintain the two-column layout */
@media (min-width: 992px) {
    .col-lg-5 {
        width: 40%;
    }
    .col-lg-7 {
        width: 60%;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        // Remove any existing error messages
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        // Basic form validation
        let isValid = true;
        
        // Required fields validation
        const requiredFields = this.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'This field is required';
                field.parentNode.appendChild(feedback);
            }
        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Get the reason for visit select element
    const reasonSelect = document.querySelector('select[name="reason_for_visit"]');
    const vaccinationDetails = document.getElementById('vaccination-details');
    const serviceDetailsContainer = document.getElementById('service-details-container');
    
    // Move vaccination details to the service details container
    serviceDetailsContainer.appendChild(vaccinationDetails);
    
    function toggleVaccinationDetails() {
        const isVaccination = reasonSelect.value === 'Vaccination';
        vaccinationDetails.style.display = isVaccination ? 'block' : 'none';
        
        // Toggle required attributes
        const requiredFields = vaccinationDetails.querySelectorAll('input[required], select[required]');
        requiredFields.forEach(field => {
            if (isVaccination) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }
    
    // Initial setup
    reasonSelect.addEventListener('change', toggleVaccinationDetails);
    
    // Show vaccination details if it was previously selected or there were errors
    if (reasonSelect.value === 'Vaccination' || <?php echo json_encode(session('error_section') === 'vaccination', 15, 512) ?>) {
        toggleVaccinationDetails();
    }
</script>
<?php $__env->stopPush(); ?>

<!-- Replace the vaccination details section with this updated version -->
<div id="vaccination-details" style="display: none;">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Vaccination Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Vaccine Type</label>
                        <select name="vaccine_type" class="form-select <?php $__errorArgs = ['vaccine_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select Vaccine Type</option>
                            <option value="anti_rabies">Anti-Rabies</option>
                            <option value="dhpp">DHPP</option>
                            <option value="fvrcp">FVRCP</option>
                            <option value="deworming">Deworming</option>
                        </select>
                        <?php $__errorArgs = ['vaccine_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Batch Number</label>
                        <input type="text" name="batch_number" class="form-control <?php $__errorArgs = ['batch_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('batch_number')); ?>">
                        <?php $__errorArgs = ['batch_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Next Due Date</label>
                        <input type="date" name="next_due_date" class="form-control <?php $__errorArgs = ['next_due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('next_due_date')); ?>">
                        <?php $__errorArgs = ['next_due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Administered By</label>
                        <input type="text" name="administered_by" class="form-control <?php $__errorArgs = ['administered_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('administered_by')); ?>">
                        <?php $__errorArgs = ['administered_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Reactions/Notes</label>
                <textarea name="reactions" class="form-control" rows="3"><?php echo e(old('reactions')); ?></textarea>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const appointmentForm = document.getElementById('appointmentForm');
    const reasonSelect = document.querySelector('select[name="reason_for_visit"]');
    const vaccinationDetails = document.getElementById('vaccination-details');

    function toggleVaccinationDetails() {
        const isVaccination = reasonSelect.value === 'Vaccination';
        vaccinationDetails.style.display = isVaccination ? 'block' : 'none';
        
        // Get all the input and select elements in vaccination details
        const vaccineFields = vaccinationDetails.querySelectorAll('input, select');
        
        vaccineFields.forEach(field => {
            if (isVaccination) {
                if (field.name === 'vaccine_type' || 
                    field.name === 'batch_number' || 
                    field.name === 'next_due_date') {
                    field.setAttribute('required', '');
                }
            } else {
                field.removeAttribute('required');
                // Clear the field value when hiding
                if (field.type === 'select-one') {
                    field.selectedIndex = 0;
                } else {
                    field.value = '';
                }
            }
        });
    }

    // Form validation
    appointmentForm.addEventListener('submit', function(e) {
        const isVaccination = reasonSelect.value === 'Vaccination';
        
        if (isVaccination) {
            const vaccineType = this.querySelector('[name="vaccine_type"]').value;
            const batchNumber = this.querySelector('[name="batch_number"]').value;
            const nextDueDate = this.querySelector('[name="next_due_date"]').value;
            const administeredBy = this.querySelector('[name="administered_by"]').value;
            
            console.log('Vaccination form submission:', {
                vaccineType,
                batchNumber,
                nextDueDate,
                administeredBy
            });
            
            if (!vaccineType || !batchNumber || !nextDueDate || !administeredBy) {
                e.preventDefault();
                const missingFields = [];
                if (!vaccineType) missingFields.push('Vaccine Type');
                if (!batchNumber) missingFields.push('Batch Number');
                if (!nextDueDate) missingFields.push('Next Due Date');
                if (!administeredBy) missingFields.push('Administered By');
                
                alert(`Please fill in all required vaccination fields: ${missingFields.join(', ')}`);
                return false;
            }
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleVaccinationDetails();
    });

    // Add change event listener
    reasonSelect.addEventListener('change', toggleVaccinationDetails);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/appointment/create.blade.php ENDPATH**/ ?>