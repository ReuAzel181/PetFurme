<?php $__env->startSection('content'); ?>
    <div class="page">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <?php echo $__env->make('partials._page_header', [
                            'title' => __('Notifications'),
                            'section' => 'OVERVIEW'
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-auto ms-auto">
                        <div class="btn-list">
                            <form action="<?php echo e(route('notifications.markAllRead')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    <?php echo e(__('Mark All as Read')); ?>

                                </button>
                            </form>
                            <a href="<?php echo e(route('notifications.index')); ?>" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                </svg>
                                <?php echo e(__('Refresh')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('partials._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo e(__('Low Stock Alerts')); ?></h3>
                        <span class="badge bg-red ms-2"><?php echo e($notifications->count()); ?></span>
                    </div>
                    <div class="card-body">
                        <?php if($notifications->isEmpty()): ?>
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <p class="empty-title"><?php echo e(__('All Good!')); ?></p>
                                <p class="empty-subtitle text-muted"><?php echo e(__('No products need attention.')); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="list-group">
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1"><?php echo e($product->name); ?></h3>
                                            <p class="mb-1"><?php echo e(__('Quantity: ')); ?> <?php echo e($product->quantity); ?> / <?php echo e(__('Alert Level: ')); ?> <?php echo e($product->quantity_alert); ?></p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge <?php if($product->quantity <= 5): ?> bg-danger <?php else: ?> bg-warning <?php endif; ?> rounded-pill">
                                                <?php if($product->quantity <= 5): ?>
                                                    <?php echo e(__('Very Low Stock')); ?>

                                                <?php else: ?>
                                                    <?php echo e(__('Stock Alert')); ?>

                                                <?php endif; ?>
                                            </span>
                                            <a href="<?php echo e(route('products.edit', ['product' => $product->uuid])); ?>" class="btn btn-sm btn-outline-primary">
                                                <?php echo e(__('Update Stock')); ?>

                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- New Expiration Alerts Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo e(__('Expiration Alerts')); ?>

                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if($expiringProducts->isEmpty()): ?>
                            <p><?php echo e(__('No products are near expiration.')); ?></p>
                        <?php else: ?>
                            <div class="list-group">
                                <?php $__currentLoopData = $expiringProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1"><?php echo e($product->name); ?></h3>
                                            <p class="mb-1">
                                                <?php echo e(__('Expires: ')); ?> <?php echo e($product->expiry_date->format('M d, Y')); ?>

                                                <br>
                                                <small class="text-muted">
                                                    <?php echo e($product->expiry_date->diffForHumans()); ?>

                                                </small>
                                            </p>
                                        </div>
                                        <span class="badge 
                                            <?php if($product->expiry_date->isPast()): ?> 
                                                bg-danger
                                            <?php elseif($product->expiry_date->diffInDays(now()) <= 30): ?> 
                                                bg-warning
                                            <?php else: ?> 
                                                bg-info
                                            <?php endif; ?> 
                                            rounded-pill">
                                            <?php if($product->expiry_date->isPast()): ?>
                                                <?php echo e(__('Expired')); ?>

                                            <?php elseif($product->expiry_date->diffInDays(now()) <= 30): ?>
                                                <?php echo e(__('Expires Soon')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('Upcoming Expiration')); ?>

                                            <?php endif; ?>
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Appointment Alerts Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo e(__('Upcoming Appointments')); ?>

                        </h3>
                        <span class="badge bg-blue ms-2"><?php echo e($upcomingAppointments->count()); ?></span>
                    </div>
                    <div class="card-body">
                        <?php if($upcomingAppointments->isEmpty()): ?>
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        <path d="M16 3l0 4" />
                                        <path d="M8 3l0 4" />
                                        <path d="M4 11l16 0" />
                                    </svg>
                                </div>
                                <p class="empty-title"><?php echo e(__('No Upcoming Appointments')); ?></p>
                                <p class="empty-subtitle text-muted"><?php echo e(__('No appointments scheduled for the next week.')); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="list-group">
                                <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-1"><?php echo e($appointment->title); ?></h3>
                                            <p class="mb-1">
                                                <?php echo e(__('Date: ')); ?> <?php echo e($appointment->scheduled_at->format('M d, Y H:i')); ?>

                                                <br>
                                                <small class="text-muted">
                                                    <?php echo e($appointment->scheduled_at->diffForHumans()); ?>

                                                </small>
                                            </p>
                                            <?php if($appointment->description): ?>
                                                <p class="text-muted mb-0"><?php echo e($appointment->description); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge 
                                                <?php if($appointment->scheduled_at->isToday()): ?> 
                                                    bg-red
                                                <?php elseif($appointment->scheduled_at->isTomorrow()): ?> 
                                                    bg-orange
                                                <?php else: ?> 
                                                    bg-blue
                                                <?php endif; ?> 
                                                rounded-pill">
                                                <?php if($appointment->scheduled_at->isToday()): ?>
                                                    <?php echo e(__('Today')); ?>

                                                <?php elseif($appointment->scheduled_at->isTomorrow()): ?>
                                                    <?php echo e(__('Tomorrow')); ?>

                                                <?php else: ?>
                                                    <?php echo e(__('Upcoming')); ?>

                                                <?php endif; ?>
                                            </span>
                                            <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="btn btn-sm btn-outline-primary">
                                                <?php echo e(__('View Details')); ?>

                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS: Enhanced styling for warning alert -->
    <?php $__env->startPush('styles'); ?>
    <style>

        /* Badge color overrides */
        .badge {
            font-size: 2.00rem; /* Larger font size for better readability */
            padding: 0.75rem 1rem; /* Moderate padding for the badge */
            border-radius: 30px; /* Slightly rounded pill shape */
            color: white !important; /* White text color */
        }

        /* Adjust colors for each alert type */
        .badge.bg-danger {
            background-color: #d9534f !important; /* More formal red */
        }

        .badge.bg-warning {
            background-color: #f39c12 !important; /* Orange for alert */
        }

        .badge.bg-success {
            background-color: #28a745 !important; /* Green for sufficient stock */
        }

        .badge.bg-danger:hover {
            background-color: #c9302c !important; /* Slightly darker red */
        }

        .badge.bg-warning:hover {
            background-color: #e67e22 !important; /* Slightly darker orange */
        }

        .badge.bg-success:hover {
            background-color: #218838 !important; /* Darker green for hover */
        }

        /* Additional styles for expiration badges */
        .badge.bg-info {
            background-color: #17a2b8 !important;
        }

        .badge.bg-info:hover {
            background-color: #138496 !important;
        }

        /* Add some spacing between list items */
        .list-group-item {
            margin-bottom: 0.5rem;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* Improve text readability */
        .text-muted {
            color: #6c757d !important;
        }

        /* Animation for new notifications */
        @keyframes notificationPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .new-notification {
            animation: notificationPulse 2s infinite;
        }

        /* Notification counter bounce animation */
        @keyframes counterBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .badge.notification-counter {
            animation: counterBounce 2s ease infinite;
        }

        /* Highlight effect for new items */
        .highlight-new {
            position: relative;
            overflow: hidden;
        }

        .highlight-new::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shine 1.5s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Notification Indicator */
        .notification-indicator {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .notification-dot {
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background-color: #dc3545;
            border-radius: 50%;
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                transform: translateY(-50%) scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            
            70% {
                transform: translateY(-50%) scale(1);
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }
            
            100% {
                transform: translateY(-50%) scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Browser Notifications
        document.addEventListener('DOMContentLoaded', function() {
            // Request notification permission
            if ("Notification" in window) {
                Notification.requestPermission();
            }

            // Function to show browser notification
            function showNotification(title, message) {
                if ("Notification" in window && Notification.permission === "granted") {
                    new Notification(title, {
                        body: message,
                        icon: '/path/to/your/icon.png' // Add your notification icon path
                    });
                }
            }

            // Function to update notification indicators
            function updateNotificationIndicators(hasNewNotifications) {
                const indicators = document.querySelectorAll('.notification-indicator');
                indicators.forEach(indicator => {
                    const dot = indicator.querySelector('.notification-dot');
                    if (hasNewNotifications) {
                        if (!dot) {
                            const newDot = document.createElement('span');
                            newDot.className = 'notification-dot';
                            indicator.appendChild(newDot);
                        }
                    } else {
                        if (dot) {
                            dot.remove();
                        }
                    }
                });
            }

            // Check for new notifications and update indicators
            function checkNewNotifications() {
                fetch('/api/check-notifications')
                    .then(response => response.json())
                    .then(data => {
                        if (data.hasNew) {
                            showNotification('New Alert', data.message);
                            updateNotificationIndicators(true);
                            document.querySelectorAll('.list-group-item.new').forEach(item => {
                                item.classList.add('highlight-new');
                            });
                        } else {
                            updateNotificationIndicators(false);
                        }
                    });
            }

            // Start checking for new notifications
            setInterval(checkNewNotifications, 30000);

            // Initial check
            checkNewNotifications();

            // Update indicators when marking all as read
            document.querySelector('form[action*="markAllRead"]').addEventListener('submit', function(e) {
                document.querySelectorAll('.list-group-item').forEach(item => {
                    item.style.transition = 'opacity 0.5s ease';
                    item.style.opacity = '0.5';
                });
                updateNotificationIndicators(false);
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/notifications/index.blade.php ENDPATH**/ ?>