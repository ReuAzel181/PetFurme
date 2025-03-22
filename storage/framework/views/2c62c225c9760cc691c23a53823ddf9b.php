<?php $__env->startSection('content'); ?>
<div class="text-center">
    <div class="my-5">
        <p class="fs-h3 text-secondary">
            <?php echo e(__('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')); ?>

        </p>
    </div>
</div>


<form action="<?php echo e(route('verification.send')); ?>" method="POST" autocomplete="off">
    <?php echo csrf_field(); ?>

    <button type="submit" class="btn btn-primary w-100">
        <?php echo e(__('Resend Verification Email')); ?>

    </button>

    <div class="mt-4">
        <?php if(session('status') == 'verification-link-sent'): ?>
            <div class="alert alert-success" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        <div class="text-secondary">
                            <?php echo e(__('A new verification link has been sent to the email address you provided during registration.')); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>

<form action="<?php echo e(route('logout')); ?>" method="POST" autocomplete="off">
    <?php echo csrf_field(); ?>

    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100">
            <?php echo e(__('Log Out')); ?>

        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>