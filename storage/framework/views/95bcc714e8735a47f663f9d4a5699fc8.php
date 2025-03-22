

<?php $__env->startSection('content'); ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Invoice Records
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Patient Name</th>
                                <th>Services Total</th>
                                <th>Products Total</th>
                                <th>Discount</th>
                                <th>Grand Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $chargeSlips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($slip->invoice_number); ?></td>
                                <td><?php echo e($slip->patient_name); ?></td>
                                <td>₱<?php echo e(number_format($slip->services_total, 2)); ?></td>
                                <td>₱<?php echo e(number_format($slip->products_total, 2)); ?></td>
                                <td>
                                    <?php if($slip->discount_type === 'percentage'): ?>
                                        <?php echo e($slip->discount_amount); ?>%
                                    <?php else: ?>
                                        ₱<?php echo e(number_format($slip->discount_amount, 2)); ?>

                                    <?php endif; ?>
                                </td>
                                <td>₱<?php echo e(number_format($slip->grand_total, 2)); ?></td>
                                <td><?php echo e($slip->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" onclick="printInvoice(<?php echo e($slip->id); ?>)">
                                            <i class="fas fa-print me-1"></i> Print
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails(<?php echo e($slip->id); ?>)">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <i class="fas fa-file-invoice fa-3x text-muted"></i>
                                        </div>
                                        <p class="empty-title">No invoices found</p>
                                        <p class="empty-subtitle text-muted">
                                            No charge slips have been created yet.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <?php echo e($chargeSlips->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function printInvoice(id) {
    // Implement print functionality
    alert('Print functionality coming soon');
}

function viewDetails(id) {
    // Implement view details functionality
    alert('View details functionality coming soon');
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/settings/invoice.blade.php ENDPATH**/ ?>