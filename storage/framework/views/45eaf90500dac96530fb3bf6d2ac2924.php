<?php $__env->startPush('page-styles'); ?>
<style>
    /* Increase table row height */
    .table > tbody > tr > td {
        padding-top: 1.5rem;    /* Increased from 1rem */
        padding-bottom: 1.5rem;  /* Increased from 1rem */
        vertical-align: middle;  /* Center content vertically */
    }
    
    /* Make table header taller */
    .table > thead > tr > th {
        padding-top: 1.25rem;    /* Increased padding */
        padding-bottom: 1.25rem;
        vertical-align: middle;
        background-color: #f8fafc;  /* Light background for header */
        border-bottom: 2px solid #e9ecef;
    }
    
    /* Adjust status badge */
    .status-badge {
        padding: 0.75rem 1.25rem;  /* Larger padding */
        font-size: 0.9rem;        /* Slightly larger text */
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Make avatar larger */
    .avatar.customer-avatar {
        width: 3rem;          /* Increased from 2.5rem */
        height: 3rem;         /* Increased from 2.5rem */
        font-size: 1.2rem;    /* Increased from 1rem */
    }

    /* Make the dropdown button taller */
    .btn-outline-secondary.btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    /* Add some spacing to the card */
    .card {
        margin-bottom: 2rem;
    }

    /* Make the table more spacious */
    .table-responsive {
        padding: 0.5rem;
    }

    /* Adjust text sizes */
    .table td {
        font-size: 1rem;
    }

    /* Add hover effect to rows */
    .table > tbody > tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Make the card taller by setting a minimum height */
    .card-table-container {
        min-height: 800px;  /* Increased height */
    }

    /* Ensure the table fills the available space */
    .table-responsive {
        overflow-x: visible;
        height: auto !important; /* Remove fixed height */
        overflow-x: auto;
        padding: 0;
    }

    /* Keep the header at the top */
    .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Keep the footer at the bottom */
    .card-footer {
        background-color: white;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Compact dropdown menu */
    .dropdown-menu-compact {
        min-width: 180px;  /* Reduce minimum width */
        padding: 0.25rem 0;
    }

    .dropdown-menu-compact .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dropdown-menu-compact .icon {
        width: 18px;
        height: 18px;
    }

    /* Card and table styles */
    .card-table-container {
        min-height: 800px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* Table styles */
    .sales-table {
        width: 100%;
        margin-bottom: 0;
    }

    .sales-table thead th {
        background: #f8fafc;
        padding: 1rem;
        font-weight: 600;
        color: #1e293b;
        border-bottom: 2px solid #e2e8f0;
    }

    .sales-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Status badge */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Actions dropdown */
    .actions-dropdown {
        position: relative;
        display: inline-block;
    }

    .actions-btn {
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #475569;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .actions-btn:hover {
        background: #f8fafc;
    }

    .actions-menu {
        min-width: 200px;
        padding: 0.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .actions-menu .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #475569;
        font-weight: 500;
    }

    .actions-menu .dropdown-item:hover {
        background: #f1f5f9;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Sales History</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <div class="btn-list">
                            <a href="<?php echo e(route('sales.export')); ?>" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                    <path d="M7 11l5 5l5 -5"></path>
                                    <path d="M12 4l0 12"></path>
                                </svg>
                                Export Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Summary Cards -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Today's Sales</div>
                        </div>
                        <div class="h1 mb-3">₱<?php echo e(number_format($totals['today']['sales'], 2)); ?></div>
                        <div class="d-flex mb-2">
                            <div>Orders: <?php echo e($totals['today']['orders']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Weekly Sales</div>
                        </div>
                        <div class="h1 mb-3">₱<?php echo e(number_format($totals['weekly']['sales'], 2)); ?></div>
                        <div class="d-flex mb-2">
                            <div>Orders: <?php echo e($totals['weekly']['orders']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Monthly Sales</div>
                        </div>
                        <div class="h1 mb-3">₱<?php echo e(number_format($totals['monthly']['sales'], 2)); ?></div>
                        <div class="d-flex mb-2">
                            <div>Orders: <?php echo e($totals['monthly']['orders']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Sales</div>
                        </div>
                        <div class="h1 mb-3">₱<?php echo e(number_format($totals['total']['sales'], 2)); ?></div>
                        <div class="d-flex mb-2">
                            <div>Orders: <?php echo e($totals['total']['orders']); ?></div>
                            <?php if($totals['deleted'] > 0): ?>
                                <div class="ms-auto text-danger">
                                    Deleted: <?php echo e($totals['deleted']); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('sales.index')); ?>" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" name="customer" value="<?php echo e(request('customer')); ?>" placeholder="Search customer...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Orders</option>
                            <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            <option value="deleted" <?php echo e(request('status') === 'deleted' ? 'selected' : ''); ?>>Deleted</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date Range</label>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" name="start_date" value="<?php echo e(request('start_date')); ?>">
                            <input type="date" class="form-control" name="end_date" value="<?php echo e(request('end_date')); ?>">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Customer</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-medium"><?php echo e($sale->invoice_no); ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                            <?php echo e(strtoupper(substr($sale->user->name, 0, 1))); ?>

                                        </span>
                                        <span><?php echo e($sale->user->name); ?></span>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo e($sale->created_at->format('M d, Y H:i')); ?></td>
                                <td class="text-center"><?php echo e($sale->details->count()); ?></td>
                                <td class="text-end fw-bold">₱<?php echo e(number_format($sale->total, 2)); ?></td>
                                <td class="text-center">
                                    <?php if($sale->deleted_at): ?>
                                        <span class="badge bg-danger text-white">
                                            Deleted
                                            <span class="d-block small"><?php echo e($sale->deleted_at->format('M d, Y')); ?></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-<?php echo e($sale->order_status_color); ?> text-white">
                                            <?php echo e(ucfirst($sale->order_status)); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="<?php echo e(route('orders.show', $sale->uuid)); ?>" class="dropdown-item">
                                                View Details
                                            </a>
                                            <?php if(!$sale->deleted_at): ?>
                                                <a href="<?php echo e(route('orders.print-invoice', $sale->uuid)); ?>" class="dropdown-item">
                                                    Print Invoice
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                <path d="M9 12h6" />
                                                <path d="M9 16h6" />
                                            </svg>
                                        </div>
                                        <p class="empty-title">No sales records found</p>
                                        <p class="empty-subtitle text-secondary">
                                            Try adjusting your search or filter to find what you're looking for.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <?php echo e($sales->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('page-scripts'); ?>
<script>
    // Initialize tooltips and dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/sales/index.blade.php ENDPATH**/ ?>