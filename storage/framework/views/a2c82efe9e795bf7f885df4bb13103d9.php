<div class="col">
    <?php echo $__env->make('partials._page_header', [
        'title' => __('Pets'),
        'section' => 'OVERVIEW',
        'button' => [
            'text' => __('Add New Pet'),
            'icon' => 'plus',
            'link' => route('pets.create'),
            'class' => 'btn-primary'
        ]
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="verified-pets" role="tabpanel">
        <ul class="nav nav-pills mb-3">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#all-pets">All Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#staff-added">Added by Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#owner-added">Added by Owners</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="all-pets">
                <?php if($organizedPets['all']->isEmpty()): ?>
                    <div class="text-center py-4">
                        <p>No pets found! Click "Add New Pet" to start managing your pets.</p>
                    </div>
                <?php else: ?>
                    <?php echo $__env->make('pets.partials._pets_list', ['pets' => $organizedPets['all']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade" id="staff-added">
                <?php if($organizedPets['staff']->isEmpty()): ?>
                    <div class="text-center py-4">
                        <p>No pets added by staff.</p>
                    </div>
                <?php else: ?>
                    <?php echo $__env->make('pets.partials._pets_list', ['pets' => $organizedPets['staff']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade" id="owner-added">
                <?php if($organizedPets['owners']->isEmpty()): ?>
                    <div class="text-center py-4">
                        <p>No pets added by owners.</p>
                    </div>
                <?php else: ?>
                    <?php echo $__env->make('pets.partials._pets_list', ['pets' => $organizedPets['owners']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="pending-verification" role="tabpanel">
        <?php if($organizedPets['pending']->isEmpty()): ?>
            <div class="text-center py-4">
                <p>No pets pending verification.</p>
            </div>
        <?php else: ?>
            <?php echo $__env->make('pets.partials._pets_list', ['pets' => $organizedPets['pending']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
</div> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/pets/index.blade.php ENDPATH**/ ?>