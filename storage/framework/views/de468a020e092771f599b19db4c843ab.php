<?php $__env->startSection('content'); ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-muted text-uppercase">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <!-- Analytics Widgets -->
            <div class="row g-2 mb-3">
                        <div class="col-sm-6 col-lg-3">
                    <?php if (isset($component)) { $__componentOriginal5a6306c8503c5483afcfc5cbee823f09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.modern-analytics-widget','data' => ['title' => 'Total Pets','value' => $totalPets,'todayCount' => $todayPets,'percentage' => $petGrowth,'trend' => $petGrowth > 0 ? 'up' : 'down','icon' => 'fas fa-paw','color' => 'primary','route' => ''.e(route('pets.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.modern-analytics-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Pets','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPets),'todayCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayPets),'percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($petGrowth),'trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($petGrowth > 0 ? 'up' : 'down'),'icon' => 'fas fa-paw','color' => 'primary','route' => ''.e(route('pets.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $attributes = $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $component = $__componentOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
                                        </div>
                <div class="col-sm-6 col-lg-3">
                    <?php if (isset($component)) { $__componentOriginal5a6306c8503c5483afcfc5cbee823f09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.modern-analytics-widget','data' => ['title' => 'Appointments','value' => $appointments,'todayCount' => $todayAppointments,'percentage' => $appointmentGrowth,'trend' => $appointmentGrowth > 0 ? 'up' : 'down','icon' => 'fas fa-calendar-check','color' => 'info','route' => ''.e(route('appointment.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.modern-analytics-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Appointments','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointments),'todayCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayAppointments),'percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentGrowth),'trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentGrowth > 0 ? 'up' : 'down'),'icon' => 'fas fa-calendar-check','color' => 'info','route' => ''.e(route('appointment.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $attributes = $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $component = $__componentOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
                                            </div>
                <div class="col-sm-6 col-lg-3">
                    <?php if (isset($component)) { $__componentOriginal5a6306c8503c5483afcfc5cbee823f09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.modern-analytics-widget','data' => ['title' => 'Pet Owners','value' => $totalPetOwners,'todayCount' => $todayPetOwners,'percentage' => number_format(($totalPetOwners - $todayPetOwners) / ($todayPetOwners ?: 1) * 100, 1),'trend' => $todayPetOwners > 0 ? 'up' : 'down','icon' => 'fas fa-users','color' => 'success','route' => ''.e(url('user-management?role=pet_owner')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.modern-analytics-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pet Owners','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPetOwners),'todayCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayPetOwners),'percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format(($totalPetOwners - $todayPetOwners) / ($todayPetOwners ?: 1) * 100, 1)),'trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayPetOwners > 0 ? 'up' : 'down'),'icon' => 'fas fa-users','color' => 'success','route' => ''.e(url('user-management?role=pet_owner')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $attributes = $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $component = $__componentOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                    <?php if (isset($component)) { $__componentOriginal5a6306c8503c5483afcfc5cbee823f09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.modern-analytics-widget','data' => ['title' => 'Today\'s Orders','value' => $todayOrders,'todayCount' => $todayOrders,'percentage' => number_format(($todayOrders - $orders) / ($orders ?: 1) * 100, 1),'trend' => $todayOrders > $orders ? 'up' : 'down','icon' => 'fas fa-shopping-cart','color' => 'warning','route' => ''.e(url('orders')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.modern-analytics-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Today\'s Orders','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayOrders),'todayCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayOrders),'percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format(($todayOrders - $orders) / ($orders ?: 1) * 100, 1)),'trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($todayOrders > $orders ? 'up' : 'down'),'icon' => 'fas fa-shopping-cart','color' => 'warning','route' => ''.e(url('orders')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $attributes = $__attributesOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__attributesOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09)): ?>
<?php $component = $__componentOriginal5a6306c8503c5483afcfc5cbee823f09; ?>
<?php unset($__componentOriginal5a6306c8503c5483afcfc5cbee823f09); ?>
<?php endif; ?>
                            </div>
                        </div>

            <div class="row g-2">
                <!-- Calendar -->
                <div class="col-lg-8 resizable-col">
                    <div class="resize-handle"></div>
                    <?php if (isset($component)) { $__componentOriginalf2e298de8b792cc033c77f0d5bb70b8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf2e298de8b792cc033c77f0d5bb70b8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.appointment-calendar','data' => ['appointments' => $calendarAppointments]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.appointment-calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['appointments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($calendarAppointments)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf2e298de8b792cc033c77f0d5bb70b8a)): ?>
<?php $attributes = $__attributesOriginalf2e298de8b792cc033c77f0d5bb70b8a; ?>
<?php unset($__attributesOriginalf2e298de8b792cc033c77f0d5bb70b8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf2e298de8b792cc033c77f0d5bb70b8a)): ?>
<?php $component = $__componentOriginalf2e298de8b792cc033c77f0d5bb70b8a; ?>
<?php unset($__componentOriginalf2e298de8b792cc033c77f0d5bb70b8a); ?>
<?php endif; ?>
                </div>

                <!-- Monthly Statistics -->
                <div class="col-lg-4 resizable-col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <h3 class="card-title" style="font-size: 0.9rem;">Monthly Statistics</h3>
                            <div class="d-flex gap-2">
                                <select id="statsMonth" class="form-select form-select-sm" style="width: auto;">
                                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($month); ?>" <?php echo e(now()->month == $month ? 'selected' : ''); ?>>
                                            <?php echo e(date('F', mktime(0, 0, 0, $month, 1))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <select id="statsYear" class="form-select form-select-sm" style="width: auto;">
                                    <?php $__currentLoopData = range(now()->year - 2, now()->year); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($year); ?>" <?php echo e(now()->year == $year ? 'selected' : ''); ?>>
                                            <?php echo e($year); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <canvas id="monthlyStats" style="height: 310px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                <div class="card">
                    <div class="card-header sticky-top bg-white d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title mb-0">Recent Activities</h3>
                            <small class="text-muted">Track all system activities</small>
                        </div>
                        <div class="ms-auto">
                            <form method="GET" class="d-flex gap-2">
                                <div class="date-range-inputs">
                                    <div class="input-group">
                                        <span class="input-group-text">From</span>
                                        <input type="date" class="form-control" name="from_date" value="<?php echo e($fromDate); ?>">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">to</span>
                                        <input type="date" class="form-control" name="to_date" value="<?php echo e($toDate); ?>">
                                    </div>
                                </div>
                                <div class="filter-controls">
                                    <select name="sort_by" class="form-select" style="width: auto;">
                                        <option value="date" <?php echo e($sortBy === 'date' ? 'selected' : ''); ?>>Latest First</option>
                                        <option value="type" <?php echo e($sortBy === 'type' ? 'selected' : ''); ?>>By Activity Type</option>
                                        <option value="description" <?php echo e($sortBy === 'description' ? 'selected' : ''); ?>>By Description</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i>
                                        Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="activities-container">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-hover table-sticky mb-0">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            <th class="w-1">Time</th>
                                            <th class="w-1">Type</th>
                                            <th>Details</th>
                                            <th class="w-1">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="text-muted">
                                                    <span data-bs-toggle="tooltip" 
                                                          title="<?php echo e(Carbon\Carbon::parse($event->created_at)->format('M d, Y h:i A')); ?>">
                                                        <?php echo e(Carbon\Carbon::parse($event->date)->format('M d')); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                        $typeInfo = match($event->type) {
                                                            'appointment' => [
                                                                'color' => 'blue',
                                                                'icon' => 'calendar',
                                                                'label' => 'Appointment',
                                                                'status' => 'Upcoming'
                                                            ],
                                                            'low_stock' => [
                                                                'color' => 'yellow',
                                                                'icon' => 'alert-triangle',
                                                                'label' => 'Low Stock',
                                                                'status' => 'Warning'
                                                            ],
                                                            'out_of_stock' => [
                                                                'color' => 'red',
                                                                'icon' => 'x-circle',
                                                                'label' => 'Out of Stock',
                                                                'status' => 'Critical'
                                                            ],
                                                            'new_product' => [
                                                                'color' => 'azure',
                                                                'icon' => 'package',
                                                                'label' => 'New Product',
                                                                'status' => 'Added'
                                                            ],
                                                            'new_pet' => [
                                                                'color' => 'green',
                                                                'icon' => 'paw',
                                                                'label' => 'New Pet',
                                                                'status' => 'Registered'
                                                            ],
                                                            'new_pet_owner' => [
                                                                'color' => 'purple',
                                                                'icon' => 'user-plus',
                                                                'label' => 'New Owner',
                                                                'status' => 'Registered'
                                                            ],
                                                            'new_order' => [
                                                                'color' => 'indigo',
                                                                'icon' => 'shopping-cart',
                                                                'label' => 'New Order',
                                                                'status' => 'Placed'
                                                            ],
                                                            default => [
                                                                'color' => 'gray',
                                                                'icon' => 'info-circle',
                                                                'label' => 'Activity',
                                                                'status' => 'Info'
                                                            ]
                                                        };
                                                    ?>
                                                    <span class="badge bg-<?php echo e($typeInfo['color']); ?>-lt" 
                                                          style="font-size: 0.9em; padding: 0.5em 0.8em;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                                             class="icon icon-<?php echo e($typeInfo['icon']); ?>" 
                                                             width="24" height="24" viewBox="0 0 24 24" 
                                                             stroke-width="2" stroke="currentColor" 
                                                             fill="none" stroke-linecap="round" 
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <!-- Add appropriate icon path here -->
                                                        </svg>
                                                        <?php echo e($typeInfo['label']); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="font-weight-medium"><?php echo e($event->description); ?></div>
                                                            <div class="text-muted small">
                                                                <?php switch($event->type):
                                                                    case ('appointment'): ?>
                                                                        Scheduled appointment
                                                                        <?php break; ?>
                                                                    <?php case ('new_pet'): ?>
                                                                        New pet registered in the system
                                                                        <?php break; ?>
                                                                    <?php case ('new_pet_owner'): ?>
                                                                        New pet owner account created
                                                                        <?php break; ?>
                                                                <?php endswitch; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php switch($event->type):
                                                        case ('appointment'): ?>
                                                            <span class="status status-blue">
                                                                Scheduled
                                                            </span>
                                                            <?php break; ?>
                                                        <?php case ('new_pet'): ?>
                                                            <span class="status status-green">
                                                                Active
                                                            </span>
                                                            <?php break; ?>
                                                        <?php case ('new_pet_owner'): ?>
                                                            <span class="status status-purple">
                                                                Registered
                                                            </span>
                                                            <?php break; ?>
                                                    <?php endswitch; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <circle cx="12" cy="12" r="9" />
                                                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                                                <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                                                            </svg>
                                                        </div>
                                                        <p class="empty-title">No activities found</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Try adjusting your search or date range to find what you're looking for.
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button class="scroll-to-bottom" id="scrollToBottom" title="Scroll to bottom">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-libraries'); ?>
    <script src="<?php echo e(asset('dist/libs/apexcharts/dist/apexcharts.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('dist/libs/jsvectormap/dist/maps/world.js')); ?>" defer></script>
    <script src="<?php echo e(asset('dist/libs/jsvectormap/dist/maps/world-merc.js')); ?>" defer></script>
<?php $__env->stopPush(); ?>

<?php if (! $__env->hasRenderedOnce('c8b4cd97-0341-43dd-9ce8-31dccea45beb')): $__env->markAsRenderedOnce('c8b4cd97-0341-43dd-9ce8-31dccea45beb');
$__env->startPush('page-scripts'); ?>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "Profits",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
                chart: {
                    type: "line",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                fill: {
                    opacity: 1,
                },
                stroke: {
                    width: [2, 1],
                    dashArray: [0, 3],
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "May",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67
                    ]
                }, {
                    name: "April",
                    data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35,
                        41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary"), tabler.getColor("gray-600")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-active-users'), {
                chart: {
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: "Profits",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
<?php $__env->stopPush(); endif; ?>

<style>
    .scrollable-container::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .table-sticky thead {
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .scrollable-container {
        border-top: 1px solid rgba(98, 105, 118, 0.16);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(98, 105, 118, 0.06);
    }

    /* Add these styles to make the dashboard scrollable */
    .page-wrapper {
        height: calc(100vh - 70px); /* Subtract header height */
        overflow-y: auto;
        padding: 20px;
    }

    .container-xl {
        max-width: 100%;
        padding: 0 15px;
    }

    /* Smooth scrolling */
    .page-wrapper {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    .page-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .page-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .page-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .page-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .resizable-col {
        position: relative;
        transition: none; /* Remove transition for smoother resize */
    }

    /* Add smooth transition only for hover effect */
    .resize-handle {
        position: absolute;
        right: -2px; /* Adjust position to be more grabbable */
        top: 0;
        bottom: 0;
        width: 8px; /* Wider handle for easier grabbing */
        background: transparent;
        cursor: col-resize;
        z-index: 100;
        transition: background 0.2s ease;
    }

    .resize-handle:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .resizing {
        user-select: none;
        cursor: col-resize;
    }

    .resizing .calendar-card,
    .resizing .card {
        transition: none !important;
    }

    /* Activities Container Styles */
    .activities-container {
        max-height: calc(100vh - 500px);
        min-height: 300px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        padding-bottom: 60px; /* Add padding at bottom */
        position: relative; /* For scroll button positioning */
    }

    .activities-container::-webkit-scrollbar {
        width: 6px;
    }

    .activities-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .activities-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .activities-container::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.3);
    }

    /* Scroll to bottom button */
    .scroll-to-bottom {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #206bc4;
        color: white;
        border: none;
        border-radius: 10%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
    }

    .scroll-to-bottom:hover {
        background: #1a569d;
        transform: translateY(-2px);
    }

    .scroll-to-bottom.visible {
        opacity: 1;
        visibility: visible;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .activities-container {
            max-height: 400px;
        }

        .card-header form {
            flex-direction: column;
            gap: 1rem;
        }

        .card-header .input-group {
            width: 100%;
        }

        .card-header select,
        .card-header button {
            width: 100% !important;
        }
    }

    /* Make table header sticky */
    .table-sticky thead th {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Responsive adjustments for statistics and calendar */
    @media (max-width: 992px) {
        .resizable-col {
            width: 100% !important;
            margin-bottom: 1rem;
        }

        .resize-handle {
            display: none;
        }

        .calendar-card {
            height: 400px;
        }

        #monthlyStats {
            height: 250px !important;
        }
    }

    /* Adjust card paddings for smaller screens */
    @media (max-width: 576px) {
        .card-body {
            padding: 0.5rem;
        }

        .card-header {
            padding: 0.75rem 0.5rem;
        }

        .analytics-context {
            font-size: 0.7rem;
        }
    }

    /* Add these styles to your existing CSS */
    .row.g-2.mb-3 {
        display: flex;
        flex-wrap: wrap;
    }

    .col-sm-6.col-lg-3 {
        display: flex;
        flex: 0 0 auto;
        width: 25%;
    }

    @media (max-width: 992px) {
        .col-sm-6.col-lg-3 {
            width: 50%;
        }
    }

    @media (max-width: 576px) {
        .col-sm-6.col-lg-3 {
            width: 100%;
        }
    }

    .modern-analytics-card {
        width: 100%;
        min-height: 160px;
        display: flex;
        flex-direction: column;
    }

    .modern-analytics-card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Update the form styles */
    .card-header form {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .date-range-inputs {
        display: flex;
        gap: 0.5rem;
        flex: 1;
        min-width: 300px;
    }

    .filter-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .card-header form {
            flex-direction: column;
            align-items: stretch;
        }
        
        .date-range-inputs {
            min-width: 100%;
        }
    }

    /* Add these styles */
    .calendar-card .card-header {
        position: relative;
        z-index: 1050; /* Higher than default dropdown z-index */
    }

    .calendar-card .dropdown-menu {
        z-index: 1051; /* Even higher than the header */
    }

    .calendar-card .dropdown {
        position: static; /* This helps with dropdown positioning */
    }

    .calendar-card .dropdown-menu {
        position: absolute;
        margin-top: 2px;
        max-height: 300px;
        overflow-y: auto;
    }

    /* Ensure dropdowns appear above calendar */
    .fc-view-harness {
        z-index: 1;
    }

    .avatar {
        --tblr-avatar-size: 40px;
        --tblr-avatar-bg: #929dab;
        position: relative;
        width: var(--tblr-avatar-size);
        height: var(--tblr-avatar-size);
        font-size: calc(var(--tblr-avatar-size) * 0.4);
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: var(--tblr-avatar-bg) no-repeat center/cover;
        border-radius: 50%;
        vertical-align: middle;
        text-align: center;
        text-decoration: none;
    }

    .avatar.avatar-sm {
        --tblr-avatar-size: 40px;
        font-size: 1rem;
    }

    /* Ensure images inside avatars maintain the circular shape */
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyStats').getContext('2d');
let monthlyStatsChart;

function initChart(data) {
    if (monthlyStatsChart) {
        monthlyStatsChart.destroy();
    }
    
    const colors = {
        pets: {
            border: '#1e40af',  // navy blue
            background: 'rgba(30, 64, 175, 0.1)'
        },
        appointments: {
            border: '#0ea5e9',  // sky blue
            background: 'rgba(14, 165, 233, 0.1)'
        },
        petOwners: {
            border: '#16a34a',  // green
            background: 'rgba(22, 163, 74, 0.1)'
        },
        orders: {
            border: '#f97316',  // orange
            background: 'rgba(249, 115, 22, 0.1)'
        }
    };

    monthlyStatsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'New Pets',
                data: data.pets,
                borderColor: colors.pets.border,
                backgroundColor: colors.pets.background,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }, {
                label: 'Appointments',
                data: data.appointments,
                borderColor: colors.appointments.border,
                backgroundColor: colors.appointments.background,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }, {
                label: 'Pet Owners',
                data: data.petOwners,
                borderColor: colors.petOwners.border,
                backgroundColor: colors.petOwners.background,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }, {
                label: 'Orders',
                data: data.orders,
                borderColor: colors.orders.border,
                backgroundColor: colors.orders.background,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 8,
                        font: { size: 11 },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    titleFont: {
                        size: 13
                    },
                    bodyFont: {
                        size: 12
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y || '0';
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: { size: 10 },
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 10 }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Initialize with current data
initChart({
    labels: <?php echo json_encode($monthlyStats->pluck('month'), 15, 512) ?>,
    appointments: <?php echo json_encode($monthlyStats->pluck('appointments'), 15, 512) ?>,
    pets: <?php echo json_encode($monthlyStats->pluck('pets'), 15, 512) ?>,
    orders: <?php echo json_encode($monthlyStats->pluck('orders'), 15, 512) ?>,
    petOwners: <?php echo json_encode($monthlyStats->pluck('petOwners'), 15, 512) ?>
});

// Add event listeners for month/year selectors
document.getElementById('statsMonth').addEventListener('change', updateStatistics);
document.getElementById('statsYear').addEventListener('change', updateStatistics);

function updateStatistics() {
    const month = document.getElementById('statsMonth').value;
    const year = document.getElementById('statsYear').value;
    
    // Show loading state
    const chartContainer = document.getElementById('monthlyStats').parentElement;
    chartContainer.style.opacity = '0.5';
    chartContainer.style.pointerEvents = 'none';
    
    fetch(`/api/statistics?month=${month}&year=${year}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            initChart(data);
        })
        .catch(error => {
            console.error('Error fetching statistics:', error);
            alert('Failed to update statistics. Please try again.');
        })
        .finally(() => {
            // Remove loading state
            chartContainer.style.opacity = '';
            chartContainer.style.pointerEvents = '';
        });
}

// Make columns resizable
document.addEventListener('DOMContentLoaded', function() {
    const calendarCol = document.querySelector('.col-lg-8');
    const statsCol = document.querySelector('.col-lg-4');
    const handle = document.querySelector('.resize-handle');
    let isResizing = false;
    let startX, startWidth;
    let resizeTimeout;

    handle.addEventListener('mousedown', function(e) {
        isResizing = true;
        startX = e.pageX;
        startWidth = calendarCol.offsetWidth;
        document.body.classList.add('resizing');
    });

    document.addEventListener('mousemove', function(e) {
        if (!isResizing) return;

        // Use requestAnimationFrame for smooth resizing
        cancelAnimationFrame(resizeTimeout);
        resizeTimeout = requestAnimationFrame(() => {
            const width = startWidth + (e.pageX - startX);
            const totalWidth = calendarCol.parentElement.offsetWidth;
            const minWidth = totalWidth * 0.3;
            const maxWidth = totalWidth * 0.7;

            if (width >= minWidth && width <= maxWidth) {
                const percentage = (width / totalWidth) * 100;
                calendarCol.style.width = `${percentage}%`;
                statsCol.style.width = `${100 - percentage}%`;
            }
        });
    });

    document.addEventListener('mouseup', function() {
        if (!isResizing) return;
        
        isResizing = false;
        document.body.classList.remove('resizing');
        
        // Update components after resize is complete
        if (monthlyStatsChart) {
            monthlyStatsChart.resize();
        }
        if (window.calendar) {
            window.calendar.updateSize();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const activitiesContainer = document.querySelector('.activities-container');
    const scrollButton = document.getElementById('scrollToBottom');

    if (activitiesContainer && scrollButton) {
        activitiesContainer.addEventListener('scroll', function() {
            const maxScroll = this.scrollHeight - this.clientHeight;
            const currentScroll = this.scrollTop;
            
            if (maxScroll - currentScroll > 100) {
                scrollButton.classList.add('visible');
            } else {
                scrollButton.classList.remove('visible');
            }
        });

        scrollButton.addEventListener('click', function() {
            activitiesContainer.scrollTo({
                top: activitiesContainer.scrollHeight,
                behavior: 'smooth'
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/dashboard.blade.php ENDPATH**/ ?>