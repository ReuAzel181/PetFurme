<?php $__env->startSection('content'); ?>
<div class="px-4 py-4 bg-gray-50 min-h-screen overflow-auto">
    <!-- Profile Setup Alert -->
    <?php if(!auth()->user()->profile_completed): ?>
    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg p-2 shadow-sm mb-3 border-l-4 border-yellow-400 transform hover:scale-102 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div class="flex-shrink-0 bg-yellow-200 rounded-full p-1">
                <i class="fas fa-user-edit text-yellow-600 text-lg"></i>
            </div>
            <div class="ml-2 flex-1">
                <h3 class="text-base font-semibold text-gray-800">Profile Setup</h3>
                <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                    Complete your profile for better service.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="<?php echo e(route('pet-owner.profile.setup')); ?>" 
                   class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-yellow-600 text-white hover:bg-yellow-700 transition-colors duration-200">
                    <i class="fas fa-arrow-right text-base"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="text-center mb-6">
        <div class="relative inline-block">
            <?php
                $defaultAvatarPath = asset('storage/user_photos/no-avatar.jpg');
                $avatarUrl = auth()->user()->photo ? 
                    asset('storage/' . auth()->user()->photo) : 
                    $defaultAvatarPath;
            ?>
            
            <?php if(auth()->user()->verified): ?>
                <div class="absolute -top-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fas fa-check text-white text-lg"></i>
                </div>
            <?php else: ?>
                <div class="absolute -top-2 -right-2 bg-yellow-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-white text-sm"></i>
                </div>
            <?php endif; ?>
            
            <img src="<?php echo e($avatarUrl); ?>" 
                 alt="<?php echo e(auth()->user()->name); ?>" 
                 class="w-24 h-24 mx-auto rounded-full shadow-lg object-cover"
                 data-fallback="<?php echo e($defaultAvatarPath); ?>"
                 onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
        </div>
        <h1 class="text-xl font-bold text-gray-800">Welcome, <?php echo e(auth()->user()->name); ?>!</h1>
        <p class="text-gray-500 mt-1">Ready to take care of your pets?</p>
    </div>

    <!-- Stats Grid -->
    <div class="mb-6">
        <!-- My Pets Card -->
        <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center text-indigo-600">
                    <div class="bg-indigo-100 rounded-full p-2 mr-2">
                        <i class="fas fa-paw text-lg"></i>
                    </div>
                    <span class="font-semibold">My Pets</span>
                </div>
            </div>

            <div class="flex space-x-3 overflow-hidden pb-2">
                <?php $__empty_1 = true; $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex-shrink-0">
                        <div class="relative w-14 h-14">
                            <img src="<?php echo e($pet->photo ? asset('storage/' . $pet->photo) : asset('storage/pet_photos/no-image.jpg')); ?>"
                                 alt="<?php echo e($pet->name); ?>"
                                 class="w-full h-full rounded-full object-cover border-2 border-indigo-100"
                                 data-fallback="<?php echo e(asset('storage/pet_photos/no-image.jpg')); ?>"
                                 onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
                            <p class="text-xs text-center mt-1 text-gray-600 font-medium whitespace-nowrap overflow-hidden text-ellipsis" 
                               title="<?php echo e($pet->name); ?>"><?php echo e($pet->name); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-gray-500 text-sm">
                        No pets registered yet. 
                        <a href="<?php echo e(route('pets.create')); ?>" class="text-blue-500 hover:text-blue-600">Add your first pet</a>
                    </div>
                <?php endif; ?>

                <!-- Add New Pet Button -->
                <div class="flex-shrink-0">
                    <a href="<?php echo e(route('pet-owner.pets.create')); ?>" 
                       class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center border-2 border-dashed border-indigo-200 hover:bg-indigo-100 transition-colors duration-200">
                        <i class="fas fa-plus text-indigo-400 text-lg"></i>
                    </a>
                    <p class="text-xs text-center mt-1 text-indigo-600 font-medium">Add Pet</p>
                </div>
            </div>
        </div>

        <!-- Featured Products Card -->
        <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-3">
            <div class="flex justify-between items-center mb-3">
                <div class="flex items-center text-blue-600">
                    <div class="bg-blue-100 rounded-full p-2 mr-2">
                        <i class="fas fa-shopping-bag text-lg"></i>
                    </div>
                    <span class="font-semibold">Featured Products</span>
                </div>
                <a href="<?php echo e(route('pet-owner.products.index')); ?>" class="text-sm text-blue-600 hover:text-blue-700 flex items-center">
                    View All 
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>

            <?php if($products->isNotEmpty()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <!-- Product Image -->
                            <div class="relative w-14 h-14 bg-gray-100 rounded-lg flex-shrink-0">
                                <img src="<?php echo e($product->image_url); ?>" 
                                     alt="<?php echo e($product->name); ?>"
                                     class="w-full h-full object-cover rounded-lg"
                                     data-fallback="<?php echo e(asset('storage/products/no-image.jpg')); ?>"
                                     onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 truncate"><?php echo e($product->name); ?></h3>
                                <?php if(isset($product->description)): ?>
                                <div class="text-sm text-gray-500 truncate">
                                    <?php echo e(Str::limit($product->description, 50)); ?>

                                </div>
                                <?php endif; ?>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-indigo-600 font-semibold">
                                        ₱<?php echo e(number_format($product->price, 2)); ?>

                                    </span>
                                    <?php if($product->stock > 0): ?>
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                            In Stock (<?php echo e($product->stock); ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                            Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-box text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm">No products available</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Visits Card -->
        <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-3">
            <div class="flex items-center text-purple-600 mb-2">
                <div class="bg-purple-100 rounded-full p-2 mr-2">
                    <i class="fas fa-calendar text-lg"></i>
                </div>
                <span class="font-semibold">Visits</span>
            </div>
            <div class="text-2xl font-bold text-gray-800 mb-1">
                <?php echo e($appointments->where('appointment_date', '>=', now())->count()); ?>

            </div>
            <div class="text-sm text-gray-500 mb-2">Scheduled Visits</div>
            <a href="<?php echo e(route('pet-owner.appointments.create')); ?>" 
               class="text-purple-600 text-sm flex items-center hover:text-purple-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Book Visit
            </a>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-3">Recent Appointments</h2>
        <?php if($appointments->isEmpty()): ?>
            <div class="bg-white rounded-lg p-6 text-center shadow-sm">
                <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-day text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 mb-4">No appointments scheduled yet</p>
                <a href="<?php echo e(route('pet-owner.appointments.create')); ?>" 
                   class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>
                    Book Your First Appointment
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/pet-owner/dashboard.blade.php ENDPATH**/ ?>