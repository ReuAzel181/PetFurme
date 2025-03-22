<?php $__env->startSection('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Store Information</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('settings.store.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Business Name</label>
                                <input type="text" class="form-control" name="business_name" value="<?php echo e(old('business_name', $settings->business_name ?? '')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-control" name="contact_email" value="<?php echo e(old('contact_email', $settings->contact_email ?? '')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone" value="<?php echo e(old('phone', $settings->phone ?? '')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="form-select" name="currency">
                                    <option value="PHP" <?php echo e((old('currency', $settings->currency ?? '') == 'PHP') ? 'selected' : ''); ?>>PHP - Philippine Peso</option>
                                    <option value="USD" <?php echo e((old('currency', $settings->currency ?? '') == 'USD') ? 'selected' : ''); ?>>USD - US Dollar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="3"><?php echo e(old('address', $settings->address ?? '')); ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/settings/store.blade.php ENDPATH**/ ?>