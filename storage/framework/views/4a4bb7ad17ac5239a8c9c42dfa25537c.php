<?php $__env->startPush('page-styles'); ?>
<link href="<?php echo e(asset('css/appointment.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Schedule New Appointment</h2>
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
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if(session('error_section')): ?>
                        <div class="alert alert-info">
                            Error Section: <?php echo e(session('error_section')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="<?php echo e(isset($owner) && $owner->photo_data ? 'data:image/jpeg;base64,' . base64_encode($owner->photo_data) : (isset($owner) && $owner->photo ? asset('storage/' . $owner->photo) : asset('storage/defaults/avatar.png'))); ?>" 
                                                             class="avatar avatar-lg" 
                                                             id="owner_avatar"
                                                             alt="Owner Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label required">Pet Owner</label>
                                                        <select name="owner_id" id="owner_id" class="form-select" required>
                                                            <option value="">Select Owner</option>
                                                            <option value="no_account">No Account (Walk-in)</option>
                                                            <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ownerOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($ownerOption->id); ?>" 
                                                                    data-avatar="<?php echo e($ownerOption->photo_data ? 'data:image/jpeg;base64,' . base64_encode($ownerOption->photo_data) : ($ownerOption->photo ? asset('storage/' . $ownerOption->photo) : asset('storage/defaults/avatar.png'))); ?>"
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

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="<?php echo e(isset($pet) && $pet->photo_data ? 'data:image/jpeg;base64,' . base64_encode($pet->photo_data) : (isset($pet) && $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/defaults/paw.png'))); ?>" 
                                                             class="avatar avatar-lg" 
                                                             id="dynamic_avatar"
                                                             alt="Pet Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div id="pet_select_container">
                                                            <label class="form-label required">Select Pet</label>
                                                            <select name="pet_id" id="pet_id" class="form-select" required>
                                                                <option value="">Select Pet</option>
                                                                <?php if(isset($ownerPets)): ?>
                                                                    <?php $__currentLoopData = $ownerPets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($petOption->id); ?>" 
                                                                            data-photo="<?php echo e($petOption->photo_data ? 'data:image/jpeg;base64,' . base64_encode($petOption->photo_data) : ($petOption->photo ? asset('storage/' . $petOption->photo) : asset('storage/defaults/paw.png'))); ?>"
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

                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label required">Date</label>
                                        <input type="text" name="appointment_date" id="appointment_date" class="form-control" 
                                               placeholder="dd/mm/yyyy" required autocomplete="off" 
                                               value="<?php echo e(old('appointment_date', isset($appointment) ? $appointment->formatted_date : '')); ?>">
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

                                    <div class="col-md-4">
                                        <label class="form-label required">Time</label>
                                        <select name="appointment_time" id="appointment_time" class="form-select" required>
                                            <option value="">Select Time</option>
                                            <optgroup label="Morning">
                                                <?php $__currentLoopData = ['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($time); ?>" <?php echo e(old('appointment_time') == $time ? 'selected' : ''); ?>>
                                                        <?php echo e($time); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <optgroup label="Afternoon">
                                                <?php $__currentLoopData = ['01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" id="today_button" class="btn btn-outline-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M16 3l0 4" />
                                                <path d="M8 3l0 4" />
                                                <path d="M4 11l16 0" />
                                                <path d="M8 15h2v2h-2z" />
                                            </svg>
                                            Today
                                        </button>
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

                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information about the visit..."></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

    const existingUserId = '<?php echo e(old("owner_id", $appointment->owner_id ?? "")); ?>';
    const existingOwnerName = '<?php echo e(old("owner_name", $appointment->owner_name ?? "")); ?>';

    if (existingOwnerName && !existingUserId) {
        userSelect.value = 'no_account';
        ownerNameGroup.style.display = 'block';
        petSelectionGroup.style.display = 'none';
        ownerNameInput.value = existingOwnerName;
    } else if (existingUserId) {
        userSelect.value = existingUserId;
        userSelect.dispatchEvent(new Event('change'));
    }

    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_category').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
        document.getElementById('pet_gender').value = '';
    }

    userSelect.addEventListener('change', function() {
        const userId = this.value;
        const ownerNameGroup = document.getElementById('owner_name_group');
        const petSelectionGroup = document.getElementById('pet_selection_group');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        if (userId === 'no_account') {
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'none';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            
            document.getElementById('owner_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            document.getElementById('walkin_pet_weight').setAttribute('required', 'required');
            document.getElementById('walkin_pet_gender').setAttribute('required', 'required');
            
            document.getElementById('pet_id').removeAttribute('required');
            
            clearPetDetails();
        } else {
            ownerNameGroup.style.display = 'none';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'none';
            registeredPetDetails.style.display = 'flex';
            
            document.getElementById('pet_id').setAttribute('required', 'required');
            
            document.getElementById('owner_name').removeAttribute('required');
            document.getElementById('walkin_pet_name').removeAttribute('required');
            document.getElementById('walkin_pet_type').removeAttribute('required');
            document.getElementById('walkin_pet_age').removeAttribute('required');
            document.getElementById('walkin_pet_weight').removeAttribute('required');
            document.getElementById('walkin_pet_gender').removeAttribute('required');
            
            if (userId) {
                loadPetsForOwner(userId);
            } else {
                clearPetSelect();
            }
        }
    });

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
                updatePetSelect(data.pets);
            })
            .catch(error => {
                console.error('Error:', error);
                petSelect.innerHTML = '<option value="">Error loading pets</option>';
            });
    }

    function updatePetSelect(pets) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        
        if (Array.isArray(pets) && pets.length > 0) {
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.text = `${pet.name} (${pet.category})`;
                
                option.dataset.name = pet.name || '';
                option.dataset.category = pet.category || '';
                option.dataset.type = pet.type || pet.category || '';
                option.dataset.breed = pet.breed || '';
                option.dataset.age = pet.age ? pet.age.toString() : '';
                option.dataset.weight = pet.weight ? pet.weight.toString() : '';
                option.dataset.gender = pet.gender ? 
                    pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : '';
                
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

    petSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const dynamicAvatar = document.getElementById('dynamic_avatar');
        
        if (!this.value) {
            clearPetDetails();
            if (dynamicAvatar) {
                dynamicAvatar.src = '/storage/defaults/paw.png';
            }
            return;
        }
        
        const petData = {
            name: selectedOption.dataset.name,
            category: selectedOption.dataset.category,
            breed: selectedOption.dataset.breed,
            age: selectedOption.dataset.age,
            weight: selectedOption.dataset.weight,
            gender: selectedOption.dataset.gender,
            photo: selectedOption.dataset.photo
        };
        
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

        if (dynamicAvatar) {
            dynamicAvatar.src = petData.photo || '/storage/defaults/paw.png';
        }

        try {
            const response = await fetch(`/api/pets/${this.value}`);
            if (!response.ok) throw new Error('Failed to fetch pet data');
            const apiPetData = await response.json();
            
            updatePetDetails(apiPetData);
            
            if (dynamicAvatar && apiPetData.photo) {
                dynamicAvatar.src = '/storage/' + apiPetData.photo;
            }
        } catch (error) {
            console.error('Error fetching pet data:', error);
        }
    });

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

    function updateReasonInput() {
        const reasonsArray = Array.from(selectedReasons);
        reasonForVisitInput.value = reasonsArray.join(', ');
        
        updateSelectedReasonsDisplay();
        
        const emptyReasonText = document.getElementById('empty-reason-text');
        if (reasonsArray.length > 0) {
            emptyReasonText.style.display = 'none';
        } else {
            emptyReasonText.style.display = 'block';
        }
    }

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
            
            const button = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
            if (button) {
                button.classList.remove('active');
            }
            
            updateReasonInput();
        });

        return badge;
    }

    reasonButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const reason = this.dataset.reason;
            
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                selectedReasons.delete(reason);
            } else {
                this.classList.add('active');
                selectedReasons.add(reason);
            }

            updateReasonInput();
        });
    });

    function updateSelectedReasonsDisplay() {
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        const emptyReasonText = document.getElementById('empty-reason-text');
        
        selectedReasonsContainer.innerHTML = '';
        
        const reasonsArray = Array.from(selectedReasons);
        
        if (reasonsArray.length > 0) {
            emptyReasonText.style.display = 'none';
            
            reasonsArray.forEach(reason => {
                const badge = createReasonBadge(reason);
                selectedReasonsContainer.appendChild(badge);
            });
        } else {
            emptyReasonText.style.display = 'block';
        }
    }

    otherReasonBtn.addEventListener('click', function() {
        otherReasonGroup.style.display = otherReasonGroup.style.display === 'none' ? 'block' : 'none';
    });

    otherReasonInput.addEventListener('input', function() {
        if (this.value.trim()) {
            selectedReasons.add('Other: ' + this.value.trim());
        } else {
            const otherReasons = Array.from(selectedReasons).filter(r => r.startsWith('Other: '));
            otherReasons.forEach(r => selectedReasons.delete(r));
        }
        updateReasonInput();
    });

    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedDate = document.getElementById('appointment_date').value;
        const selectedTime = document.getElementById('appointment_time').value;
        
        if (!selectedDate || !selectedTime) {
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                text: 'Please select both date and time for the appointment.',
            });
            return;
        }
        
        if (selectedReasons.size === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                text: 'Please select at least one reason for the visit.',
            });
            return;
        }
        
        this.submit();
    });

    function initializeDatePicker() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const datePicker = document.getElementById('appointment_date');
        datePicker.min = tomorrow.toISOString().split('T')[0];
        
        datePicker.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();
            
            const timeSelect = document.getElementById('appointment_time');
            timeSelect.innerHTML = '';
            
            if (dayOfWeek === 0) {
                timeSelect.innerHTML = '<option value="">Clinic is closed on Sundays</option>';
                timeSelect.disabled = true;
                return;
            }
            
            timeSelect.disabled = false;
            
            const timeSlots = generateTimeSlots(dayOfWeek === 6);
            timeSlots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = slot;
                timeSelect.appendChild(option);
            });
        });
    }

    function generateTimeSlots(isSaturday) {
        const slots = [];
        const startHour = 8;
        const endHour = isSaturday ? 12 : 17;
        
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                const formattedHour = hour.toString().padStart(2, '0');
                const formattedMinute = minute.toString().padStart(2, '0');
                slots.push(`${formattedHour}:${formattedMinute}`);
            }
        }
        
        return slots;
    }

    initializeDatePicker();
});

document.getElementById('pet_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (!this.value) {
        clearPetDetails();
        return;
    }
    
    document.getElementById('pet_name').value = selectedOption.text.split(' (')[0] || '';
    document.getElementById('pet_type').value = selectedOption.dataset.type || '';
    document.getElementById('pet_age').value = selectedOption.dataset.age || '';
    document.getElementById('pet_weight').value = selectedOption.dataset.weight || '';
    document.getElementById('pet_gender').value = selectedOption.dataset.gender || '';
});

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
            
            dynamicAvatar.src = petData.photo ? 
                '/storage/' + petData.photo : 
                '/storage/defaults/paw.png';
                
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

function updatePetsDropdown(pets) {
    const petSelect = document.getElementById('pet_id');
    if (!petSelect) return;

    petSelect.innerHTML = '<option value="">Select Pet</option>';
    pets.forEach(pet => {
        const option = document.createElement('option');
        option.value = pet.id;
        option.textContent = `${pet.name} (${pet.category})`;
        
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
        
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameDisplay.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        if (isWalkIn) {
            ownerNameInput.addEventListener('input', function() {
                ownerNameValue.textContent = this.value || 'Not specified';
            });
        }
    });

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

    const defaultAvatarPath = '/storage/defaults/avatar.png';
    const defaultPawPath = '/storage/defaults/paw.png';

    ownerSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameContainer.style.display = isWalkIn ? 'block' : 'none';
        walkinPetGroup.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        if (isWalkIn) {
            ownerAvatar.src = defaultAvatarPath;
            ownerAvatar.alt = 'Default Owner Avatar';
            dynamicAvatar.src = defaultAvatarPath;
            dynamicAvatar.alt = 'Walk-in Owner Avatar';
        } else {
            const selectedOption = this.options[this.selectedIndex];
            ownerAvatar.src = selectedOption.dataset.avatar || defaultAvatarPath;
            ownerAvatar.alt = selectedOption.text + ' Avatar';
            
            dynamicAvatar.src = defaultPawPath;
            dynamicAvatar.alt = 'Select Pet Avatar';
        }
        
        const ownerNameInput = document.getElementById('owner_name');
        const petSelect = document.getElementById('pet_id');
        
        if (isWalkIn) {
            ownerNameInput.setAttribute('required', 'required');
            petSelect.removeAttribute('required');
            
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

    if (ownerSelect.value === 'no_account') {
        ownerSelect.dispatchEvent(new Event('change'));
    }

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

function updatePetDetails(selectedOption) {
    if (!selectedOption) return;
    
    const dataset = selectedOption.dataset;

    const petPhotoElement = document.getElementById('pet-photo');
    const petNameElement = document.getElementById('pet-name');
    const petCategoryElement = document.getElementById('pet-category');
    const petBreedElement = document.getElementById('pet-breed');
    const petAgeElement = document.getElementById('pet-age');
    const petWeightElement = document.getElementById('pet-weight');
    const petGenderElement = document.getElementById('pet-gender');

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

document.getElementById('pet_id').addEventListener('change', function(e) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    updatePetDetails(selectedOption);
});

function updateServiceDetailsForm(reasons) {
    const serviceDetailsCard = document.getElementById('service-details-card');
    
    if (!serviceDetailsCard) {
        console.error('Service details card element not found!');
        return;
    }
    
    if (typeof reasons === 'string') {
        reasons = [reasons];
    }
    
    serviceDetailsCard.innerHTML = '';
    
    reasons.forEach((reason, index) => {
        let formFields = '';
        
        
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

            cardDiv.querySelector('.btn-close').addEventListener('click', function() {
                cardDiv.remove();
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

reasonButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const reason = this.dataset.reason;

        if (this.classList.contains('active')) {
            this.classList.remove('active');
            selectedReasons.delete(reason);
        } else {
            this.classList.add('active');
            selectedReasons.add(reason);
        }

        updateReasonInput();

        const activeReasons = Array.from(selectedReasons);
        if (activeReasons.length > 0) {
            updateServiceDetailsForm(activeReasons);
            updateServiceHistoryTable(reason);
            document.getElementById('service-history-section').style.display = 'block';
        } else {
            document.getElementById('service-details-card').style.display = 'none';
            document.getElementById('service-history-section').style.display = 'none';
        }

        const petId = document.getElementById('pet_id').value;
        if (petId && this.dataset.reason.toLowerCase().includes('check-up')) {
            const serviceType = this.dataset.reason.replace('Check-up', '').trim();
            loadServiceHistory(petId, serviceType);
        }
    });
});


document.getElementById('pet_id').addEventListener('change', async function() {
    const petId = this.value;
    const petAvatar = document.getElementById('dynamic_avatar');
    const defaultPawImage = '<?php echo e(asset("storage/defaults/paw.png")); ?>';
    
    const currentSrc = petAvatar.src;
    
    if (!petId) {
        petAvatar.src = defaultPawImage;
        return;
    }
    
    try {
        const cachedResponse = await caches.match(`/api/pets/${petId}`);
        let petData;
        
        if (cachedResponse) {
            petData = await cachedResponse.json();
        } else {
            const response = await fetch(`/api/pets/${petId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            petData = await response.json();
        }
        
        console.log('Updating pet details with:', petData);
        
        if (petData.photo_url) {
            const tempImg = new Image();
            
            tempImg.onload = function() {
                petAvatar.src = petData.photo_url;
            };
            
            tempImg.onerror = function() {
                console.error('Failed to load pet image');
                petAvatar.src = defaultPawImage;
            };
            
            // Start loading the image
            tempImg.src = petData.photo_url;
        } else {
            petAvatar.src = defaultPawImage;
        }
        
        updatePetDetails(petData);
        
        const selectedReasons = Array.from(document.querySelectorAll('.reason-btn.active'))
            .map(btn => btn.dataset.reason);
            
        selectedReasons.forEach(reason => {
            loadServiceHistory(petId, reason);
        });
        
    } catch (error) {
        console.error('Error fetching pet data:', error);
        petAvatar.src = defaultPawImage;
    }
});

function updatePetDetails(petData) {
    const petDetailsElements = {
        'pet-name': petData.name,
        'pet-category': petData.category,
        'pet-breed': petData.breed,
        'pet-age': petData.age,
        'pet-weight': petData.weight,
        'pet-gender': petData.gender
    };
    
    Object.entries(petDetailsElements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value || '-';
        }
    });
}

</script>

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

    ownerSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value === 'no_account') {
            ownerAvatar.src = '/storage/defaults/avatar.png';
            
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
            try {
                const response = await fetch(`/api/owners/${selectedOption.value}`);
                
                if (!response.ok) {
                    throw new Error('Failed to fetch owner data');
                }
                
                const ownerData = await response.json();
                
                if (ownerData.photo_data) {
                    ownerAvatar.src = `data:image/jpeg;base64,${ownerData.photo_data}`;
                } else if (ownerData.avatar_url) {
                    ownerAvatar.src = ownerData.avatar_url;
                } else {
                    ownerAvatar.src = defaultAvatarPath;
                }
                
                ownerAvatar.onerror = function() {
                    this.src = defaultAvatarPath;
                };
                
            } catch (error) {
            }
        } else {
            resetForm();
        }
    });

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

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        let isValid = true;
        
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
    const reasonSelect = document.querySelector('select[name="reason_for_visit"]');
    const vaccinationDetails = document.getElementById('vaccination-details');
    const serviceDetailsContainer = document.getElementById('service-details-container');
    
    serviceDetailsContainer.appendChild(vaccinationDetails);
    
    function toggleVaccinationDetails() {
        const isVaccination = reasonSelect.value === 'Vaccination';
        vaccinationDetails.style.display = isVaccination ? 'block' : 'none';
        
        const requiredFields = vaccinationDetails.querySelectorAll('input[required], select[required]');
        requiredFields.forEach(field => {
            if (isVaccination) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const defaultAvatarPath = "<?php echo e(asset('storage/defaults/avatar.png')); ?>";
    const defaultPawPath = "<?php echo e(asset('storage/defaults/paw.png')); ?>";
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing appointment form...');
        
        const ownerSelect = document.getElementById('owner_id');
        const ownerAvatar = document.getElementById('owner_avatar');
        const petSelect = document.getElementById('pet_id');
        const dynamicAvatar = document.getElementById('dynamic_avatar');
        
        const ownerNameGroup = document.getElementById('owner_name_container');
        const petSelectionGroup = document.getElementById('pet_select_container');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        console.log('Elements check:', {
            ownerSelect, ownerAvatar, petSelect, dynamicAvatar,
            ownerNameGroup, petSelectionGroup, walkinPetGroup, registeredPetDetails,
            defaultAvatarPath, defaultPawPath
        });
        
        if (ownerSelect) {
            ownerSelect.addEventListener('change', async function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value === 'no_account') {
                    console.log('Walk-in selection');
                    ownerAvatar.src = defaultAvatarPath;
                    
                    if (petSelectionGroup) petSelectionGroup.style.display = 'none';
                    if (ownerNameGroup) ownerNameGroup.style.display = 'block';
                    if (walkinPetGroup) walkinPetGroup.style.display = 'block';
                    if (registeredPetDetails) registeredPetDetails.style.display = 'none';
                    
                } else if (selectedOption.value) {
                    console.log('Owner selected:', selectedOption.value, selectedOption.text);
                    try {
                        console.log('Fetching owner data...');
                        const ownerResponse = await fetch(`/api/owners/${selectedOption.value}`);
                        
                        if (!ownerResponse.ok) {
                            console.error('Owner API error:', ownerResponse.status, ownerResponse.statusText);
                            throw new Error('Failed to fetch owner data');
                        }
                        
                        const ownerData = await ownerResponse.json();
                        console.log('Owner data received:', ownerData);
                        
                        if (ownerData.photo_data) {
                            ownerAvatar.src = `data:image/jpeg;base64,${ownerData.photo_data}`;
                        } else if (ownerData.avatar_url) {
                            ownerAvatar.src = ownerData.avatar_url;
                        } else {
                            ownerAvatar.src = defaultAvatarPath;
                        }
                        
                        ownerAvatar.onerror = function() {
                            console.log('Owner image failed to load, using default');
                            this.src = defaultAvatarPath;
                        };
                        
                        console.log('Fetching pets for owner ID:', selectedOption.value);
                        const petsResponse = await fetch(`/api/owners/${selectedOption.value}/pets`);
                        
                        if (!petsResponse.ok) {
                            console.error('Pets API error:', petsResponse.status, petsResponse.statusText);
                            throw new Error('Failed to fetch pets data');
                        }
                        
                        const petsData = await petsResponse.json();
                        console.log('Pets data received:', petsData);
                        
                        updatePetsDropdown(petsData);
                        
                        if (petSelectionGroup) petSelectionGroup.style.display = 'block';
                        if (ownerNameGroup) ownerNameGroup.style.display = 'none';
                        if (walkinPetGroup) walkinPetGroup.style.display = 'none';
                        if (registeredPetDetails) registeredPetDetails.style.display = 'block';
                        
                    } catch (error) {
                        console.error('Error in owner selection process:', error);
                        ownerAvatar.src = defaultAvatarPath;
                        
                        if (typeof showNotification === 'function') {
                            showNotification('error', `Failed to load data: ${error.message}`);
                        } else {
                            alert(`Error: ${error.message}`);
                        }
                    }
                } else {
                    console.log('No owner selected');
                    ownerAvatar.src = defaultAvatarPath;
                    
                    if (petSelect) {
                        petSelect.innerHTML = '<option value="">Select Pet</option>';
                    }
                    if (dynamicAvatar) {
                        dynamicAvatar.src = defaultPawPath;
                    }
                }
            });
        }
        
        if (petSelect) {
            petSelect.addEventListener('change', function() {
                console.log('Pet selection changed');
                const selectedOption = this.options[this.selectedIndex];
                
                if (!dynamicAvatar) {
                    console.error('Dynamic avatar element not found');
                    return;
                }
                
                if (selectedOption && selectedOption.value) {
                    const photoSrc = selectedOption.getAttribute('data-photo');
                    console.log('Selected pet photo:', photoSrc);
                    
                    dynamicAvatar.src = photoSrc || defaultPawPath;
                    
                    dynamicAvatar.onerror = function() {
                        console.log('Pet image failed to load, using default');
                        this.src = defaultPawPath;
                    };
                    
                    const petData = {
                        name: selectedOption.getAttribute('data-name'),
                        category: selectedOption.getAttribute('data-category'),
                        breed: selectedOption.getAttribute('data-breed'),
                        age: selectedOption.getAttribute('data-age'),
                        weight: selectedOption.getAttribute('data-weight'),
                        gender: selectedOption.getAttribute('data-gender')
                    };
                    
                    updatePetDetails(petData);
                    
                } else {
                    console.log('No pet selected, using default image');
                    dynamicAvatar.src = defaultPawPath;
                    clearPetDetails();
                }
            });
        }
    });
    
    function updatePetsDropdown(pets) {
        const petSelect = document.getElementById('pet_id');
        if (!petSelect) {
            console.error('Pet select element not found');
            return;
        }
        
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        
        if (!Array.isArray(pets) || pets.length === 0) {
            console.log('No pets found for this owner');
            return;
        }
        
        console.log(`Adding ${pets.length} pets to dropdown`);
        
        pets.forEach(pet => {
            const option = document.createElement('option');
            option.value = pet.id;
            option.textContent = `${pet.name} (${pet.category || 'Unknown'})`;
            
            if (pet.photo_data) {
                option.setAttribute('data-photo', `data:image/jpeg;base64,${pet.photo_data}`);
            } else if (pet.photo) {
                option.setAttribute('data-photo', `/storage/${pet.photo}`);
            } else {
                option.setAttribute('data-photo', defaultPawPath);
            }
            
            option.setAttribute('data-name', pet.name || '');
            option.setAttribute('data-category', pet.category || '');
            option.setAttribute('data-breed', pet.breed || '');
            option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
            option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
            option.setAttribute('data-gender', pet.gender ? pet.gender.toLowerCase() : '');
            
            petSelect.appendChild(option);
        });
        
        console.log(`Pet dropdown updated with ${pets.length} pets`);
    }
    
    function updatePetDetails(petData) {
        console.log('Updating pet details with:', petData);
        
        const petFields = {
            'pet_name': petData.name || '',
            'pet_category': petData.category || '',
            'pet_breed': petData.breed || '',
            'pet_age': petData.age || '',
            'pet_weight': petData.weight || '',
            'pet_gender': petData.gender ? 
                petData.gender.charAt(0).toUpperCase() + petData.gender.slice(1) : ''
        };
        
        Object.entries(petFields).forEach(([id, value]) => {
            const field = document.getElementById(id);
            if (field) field.value = value;
        });
    }

    function updateDynamicPetFields(petData) {
        if (!petData) return;
        
        const fields = {
            'pet_name': petData.name || '',
            'pet_category': petData.type || petData.category || '',
            'pet_breed': petData.breed || '',
            'pet_gender': petData.gender || '',
            'pet_weight': petData.weight || '',
            'pet_age': petData.age || ''
        };
        
        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value;
            }
        });
    }

    function updateDisplayFields(data, fieldMap) {
        if (!data) return;
        
        Object.entries(fieldMap).forEach(([property, elementId]) => {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const value = data[property];
            element.textContent = value || '-';
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const todayButton = document.getElementById('today_button');
        const dateField = document.getElementById('appointment_date');
        const timeField = document.getElementById('appointment_time');
        
        const notificationContainer = document.createElement('div');
        notificationContainer.id = 'time-selection-indicator';
        notificationContainer.className = 'alert alert-info mt-2 d-none';
        notificationContainer.setAttribute('role', 'alert');
        
        const buttonParent = document.querySelector('.col-md-4.d-flex.align-items-end');
        if (buttonParent) {
            buttonParent.parentNode.insertBefore(notificationContainer, buttonParent.nextSibling);
        }
        
        function showTimeIndicator(message, type = 'info') {
            notificationContainer.textContent = message;
            notificationContainer.className = `alert alert-${type} mt-2`;
            
            setTimeout(() => {
                notificationContainer.className = 'alert alert-info mt-2 d-none';
            }, 8000);
        }
        
        if (todayButton && dateField && timeField) {
            todayButton.addEventListener('click', function() {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0
                const year = now.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;
                
                dateField.value = formattedDate;
                
                const hours = now.getHours();
                const minutes = now.getMinutes();
                console.log('Current time:', hours + ':' + minutes);
                
                if (hours < 9) {
                    for (let i = 0; i < timeField.options.length; i++) {
                        if (timeField.options[i].value === '09:00 AM') {
                            timeField.selectedIndex = i;
                            break;
                        }
                    }
                    const timeUntilOpening = 9 - hours;
                    showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) is outside business hours. Selected the first available appointment at 9:00 AM (${timeUntilOpening} hours from now).`, 'warning');
                } 
                else if (hours >= 17 || (hours === 16 && minutes > 30)) {
                    // Select 9:00 AM for tomorrow
                    for (let i = 0; i < timeField.options.length; i++) {
                        if (timeField.options[i].value === '09:00 AM') {
                            timeField.selectedIndex = i;
                            
                            const tomorrow = new Date(now);
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                            const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                            const tomorrowYear = tomorrow.getFullYear();
                            dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                            
                            showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) is after business hours. Selected the first available appointment tomorrow at 9:00 AM.`, 'warning');
                            break;
                        }
                    }
                }
                else {
                    const currentTotalMinutes = hours * 60 + minutes;
                    
                    let bestOptionIndex = -1;
                    let smallestDifference = Infinity;
                    
                    for (let i = 1; i < timeField.options.length; i++) {
                        const option = timeField.options[i];
                        if (!option.value) continue;
                        
                        const [timePart, ampm] = option.value.split(' ');
                        let [slotHours, slotMinutes] = timePart.split(':').map(Number);
                        
                        if (ampm === 'PM' && slotHours !== 12) slotHours += 12;
                        if (ampm === 'AM' && slotHours === 12) slotHours = 0;
                        
                        const slotTotalMinutes = slotHours * 60 + slotMinutes;
                        
                        if (slotTotalMinutes > currentTotalMinutes + 15) {
                            const difference = slotTotalMinutes - currentTotalMinutes;
                            
                            if (difference < smallestDifference) {
                                smallestDifference = difference;
                                bestOptionIndex = i;
                            }
                        }
                    }
                    
                    if (bestOptionIndex !== -1) {
                        timeField.selectedIndex = bestOptionIndex;
                        const selectedTime = timeField.options[bestOptionIndex].value;
                        
                        const minutesDifference = Math.floor(smallestDifference);
                        const hoursDifference = Math.floor(minutesDifference / 60);
                        const remainingMinutes = minutesDifference % 60;
                        
                        let timeMessage;
                        if (hoursDifference > 0) {
                            timeMessage = `${hoursDifference} hour${hoursDifference > 1 ? 's' : ''}`;
                            if (remainingMinutes > 0) {
                                timeMessage += ` and ${remainingMinutes} minute${remainingMinutes > 1 ? 's' : ''}`;
                            }
                        } else {
                            timeMessage = `${remainingMinutes} minute${remainingMinutes > 1 ? 's' : ''}`;
                        }
                        
                        if (minutesDifference <= 30) {
                            showTimeIndicator(`Selected the closest available appointment at ${selectedTime} (${timeMessage} from now).`, 'success');
                        } else {
                            showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) - next available appointment is at ${selectedTime} (${timeMessage} from now).`, 'info');
                        }
                    } else {
                        for (let i = 0; i < timeField.options.length; i++) {
                            if (timeField.options[i].value === '09:00 AM') {
                                timeField.selectedIndex = i;
                                
                                const tomorrow = new Date(now);
                                tomorrow.setDate(tomorrow.getDate() + 1);
                                const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                                const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                                const tomorrowYear = tomorrow.getFullYear();
                                dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                                
                                showTimeIndicator(`No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.`, 'warning');
                                break;
                            }
                        }
                    }
                }
                
                dateField.dispatchEvent(new Event('change', { bubbles: true }));
                timeField.dispatchEvent(new Event('change', { bubbles: true }));
                
                console.log('Today button clicked, set date to:', dateField.value, 'and time to:', timeField.value);
            });
        } else {
            console.error('Today button or date/time fields not found:', { 
                todayButton, dateField, timeField 
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateField = document.getElementById('appointment_date');
        if (dateField) {
            dateField.addEventListener('change', function() {
                const dateValue = this.value;
                const datePattern = /^\d{4}-\d{2}-\d{2}$/;
                
                if (!datePattern.test(dateValue)) {
                    try {
                        const dateParts = dateValue.split(/[\/\-\.]/);
                        
                        if (dateParts.length === 3) {
                            let year, month, day;
                            
                            if (dateParts[0].length === 4) {
                                year = dateParts[0];
                                month = dateParts[1].padStart(2, '0');
                                day = dateParts[2].padStart(2, '0');
                            } 
                            else if (dateParts[2].length === 4) {
                                day = dateParts[0].padStart(2, '0');
                                month = dateParts[1].padStart(2, '0');
                                year = dateParts[2];
                            }
                            else {
                                month = dateParts[0].padStart(2, '0');
                                day = dateParts[1].padStart(2, '0');
                                year = dateParts[2].length === 2 ? '20' + dateParts[2] : dateParts[2];
                            }
                            
                            this.value = `${year}-${month}-${day}`;
                        }
                    } catch (e) {
                        console.error('Error formatting date:', e);
                    }
                }
            });
        }
    });
</script>

<?php $__env->startPush('scripts'); ?>
<script>
    // Constants and Configuration
    const defaultPaths = {
        defaultAvatar: '/images/default-avatar.png',
        defaultPetPhoto: '/images/default-pet-photo.png'
    };

    const serviceTypeMapping = {
        'checkup': 'appt_checkups',
        'vaccination': 'appt_vaccinations',
        'grooming': 'appt_grooming',
        'surgery': 'appt_surgeries',
        'laboratory': 'appt_laboratory'
    };

    // DOM Elements
    const form = document.getElementById('appointment-form');
    const ownerSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');
    const reasonSelect = document.getElementById('reason_for_visit');
    const dateField = document.getElementById('appointment_date');
    const timeField = document.getElementById('appointment_time');
    const todayButton = document.getElementById('today-button');
    const serviceDetailsContainer = document.getElementById('service-details-container') || createServiceDetailsContainer();

    // Initialization
    document.addEventListener('DOMContentLoaded', function() {
        initializeFormValidation();
        initializeOwnerSelection();
        initializePetSelection();
        initializeReasonForVisit();
        initializeDateTimeHandling();
    });

    // Form Validation
    function initializeFormValidation() {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Remove existing error messages
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(message => message.remove());
            
            // Check required fields
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    isValid = false;
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-danger mt-1';
                    errorDiv.textContent = 'This field is required';
                    field.parentNode.appendChild(errorDiv);
                }
            });
            
            if (isValid) {
                form.submit();
            }
        });
    }

    // Owner Selection Handling
    function initializeOwnerSelection() {
        if (ownerSelect) {
            ownerSelect.addEventListener('change', async function() {
                const ownerId = this.value;
                if (ownerId) {
                    try {
                        const response = await fetch(`/api/owners/${ownerId}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            updateOwnerDetails(data.owner);
                            updatePetOptions(data.pets);
                        } else {
                            console.error('Error fetching owner data:', data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });
        }
    }

    // Pet Selection Handling
    function initializePetSelection() {
        if (petSelect) {
            petSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                updatePetDetails(selectedOption);
            });
        }
    }

    // Reason for Visit Handling
    function initializeReasonForVisit() {
        if (reasonSelect) {
            reasonSelect.addEventListener('change', function() {
                toggleVaccinationDetails();
                loadServiceForm(this.value);
            });
        }
    }

    // Date and Time Handling
    function initializeDateTimeHandling() {
        if (todayButton && dateField && timeField) {
            todayButton.addEventListener('click', function() {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                const currentHour = now.getHours();
                
                dateField.value = `${day}/${month}/${year}`;
                
                if (currentHour < 9) {
                    timeField.value = '09:00';
                    showTimeIndicator('Selected first available appointment at 9:00 AM');
                } else if (currentHour >= 17) {
                    const tomorrow = new Date(now);
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                    const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                    const tomorrowYear = tomorrow.getFullYear();
                    dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                    timeField.value = '09:00';
                    showTimeIndicator('No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.', 'warning');
                } else {
                    const nextHour = currentHour + 1;
                    if (nextHour < 17) {
                        timeField.value = `${String(nextHour).padStart(2, '0')}:00`;
                        showTimeIndicator(`Selected next available appointment at ${timeField.value}`);
                    } else {
                        const tomorrow = new Date(now);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                        const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                        const tomorrowYear = tomorrow.getFullYear();
                        dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                        timeField.value = '09:00';
                        showTimeIndicator('No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.', 'warning');
                    }
                }
                
                dateField.dispatchEvent(new Event('change', { bubbles: true }));
                timeField.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }
    }

    // Utility Functions
    function createServiceDetailsContainer() {
        const container = document.createElement('div');
        container.id = 'service-details-container';
        container.className = 'mt-3';
        const reasonSection = document.querySelector('.form-selectgroup').closest('.mb-3');
        reasonSection.parentNode.insertBefore(container, reasonSection.nextSibling);
        return container;
    }

    function showTimeIndicator(message, type = 'info') {
        const container = document.getElementById('time-indicator') || createTimeIndicator();
        container.textContent = message;
        container.className = `alert alert-${type} mt-2`;
        container.style.display = 'block';
        
        setTimeout(() => {
            container.style.display = 'none';
        }, 5000);
    }

    function createTimeIndicator() {
        const container = document.createElement('div');
        container.id = 'time-indicator';
        container.className = 'alert mt-2';
        timeField.parentNode.appendChild(container);
        return container;
    }

    function toggleVaccinationDetails() {
        const vaccinationDetails = document.getElementById('vaccination-details');
        const selectedReason = reasonSelect.value;
        
        if (vaccinationDetails) {
            if (selectedReason === 'Vaccination') {
                vaccinationDetails.style.display = 'block';
                const requiredFields = vaccinationDetails.querySelectorAll('input, select');
                requiredFields.forEach(field => field.setAttribute('required', ''));
            } else {
                vaccinationDetails.style.display = 'none';
                const requiredFields = vaccinationDetails.querySelectorAll('input, select');
                requiredFields.forEach(field => field.removeAttribute('required'));
            }
        }
    }

    function updateOwnerDetails(owner) {
        const ownerDetailsContainer = document.getElementById('owner-details');
        if (ownerDetailsContainer) {
            const avatarImg = ownerDetailsContainer.querySelector('img');
            if (avatarImg) {
                avatarImg.src = owner.photo_data || defaultPaths.defaultAvatar;
            }
            
            const nameElement = ownerDetailsContainer.querySelector('[data-field="name"]');
            if (nameElement) {
                nameElement.textContent = owner.name;
            }
            
            // Update other owner details as needed
        }
    }

    function updatePetOptions(pets) {
        if (petSelect) {
            petSelect.innerHTML = '<option value="">Select a pet</option>';
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.textContent = pet.name;
                option.dataset.photo = pet.photo_data || defaultPaths.defaultPetPhoto;
                option.dataset.name = pet.name;
                option.dataset.category = pet.category;
                option.dataset.breed = pet.breed;
                option.dataset.age = pet.age;
                option.dataset.weight = pet.weight;
                option.dataset.gender = pet.gender;
                petSelect.appendChild(option);
            });
        }
    }

    function updatePetDetails(selectedOption) {
        console.log('Updating pet details with:', selectedOption.dataset);
        const petDetailsContainer = document.getElementById('pet-details');
        if (petDetailsContainer) {
            const avatarImg = petDetailsContainer.querySelector('img');
            if (avatarImg) {
                avatarImg.src = selectedOption.dataset.photo || defaultPaths.defaultPetPhoto;
            }
            
            const fields = ['name', 'category', 'breed', 'age', 'weight', 'gender'];
            fields.forEach(field => {
                const element = petDetailsContainer.querySelector(`[data-field="${field}"]`);
                if (element) {
                    element.textContent = selectedOption.dataset[field] || '';
                }
            });
        }
    }

    function loadServiceForm(serviceType) {
        const formContainer = document.getElementById('service-details-container');
        if (formContainer) {
            formContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading form...</p></div>';
            
            let formUrl = '';
            switch(serviceType) {
                case 'Vaccination':
                    formUrl = '/appointment/forms/vaccination';
                    break;
                case 'Check-up':
                case 'Consultation':
                    formUrl = '/appointment/forms/checkup';
                    break;
                case 'Grooming':
                    formUrl = '/appointment/forms/grooming';
                    break;
                case 'Surgery':
                    formUrl = '/appointment/forms/surgery';
                    break;
                case 'Laboratory':
                    formUrl = '/appointment/forms/laboratory';
                    break;
            }
            
            if (formUrl) {
                fetch(formUrl)
                    .then(response => response.text())
                    .then(html => {
                        formContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading service form:', error);
                        formContainer.innerHTML = '<div class="alert alert-danger">Error loading form. Please try again.</div>';
                    });
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>
</script>

<?php if(isset($pet)): ?>
    <div class="alert alert-info">
        <p>Debug Info:</p>
        <ul>
            <li>Pet ID: <?php echo e($pet->id); ?></li>
            <li>Pet Name: <?php echo e($pet->name); ?></li>
            <li>Vaccination Count: <?php echo e($pet->vaccinations()->count()); ?></li>
            <li>Vaccinations: <pre><?php echo e(json_encode($pet->vaccinations()->get(), JSON_PRETTY_PRINT)); ?></pre></li>
            <li>Raw Query: <pre>SELECT * FROM appt_vaccinations WHERE pet_id = <?php echo e($pet->id); ?> ORDER BY date_given DESC</pre></li>
        </ul>
    </div>
<?php endif; ?>
<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/appointment/create.blade.php ENDPATH**/ ?>