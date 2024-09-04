<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/styles1.css')); ?>">

<?php $__env->startSection('content'); ?>

<div class="side-bar"> 
    <div class="main-title">
        <h1 class="main-title text"> Customize your pet based on your preferences
        </h1>
    </div>
    <div><img src="assets/img2/login_icon.png" alt="Login Icon" style="width: 300px;"></div>
</div>

<div class="background-wrapper">

    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">
                Login to your account
            </h2>
            <form action="<?php echo e(route('login')); ?>" method="POST" autocomplete="off">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">
                        Email address
                    </label>
                    <input type="email"
                        name="email"
                        id="email"
                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="your@email.com"
                        autocomplete="off"
                        value="<?php echo e(old('email')); ?>"
                    >

                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <!-- <div class="input-group input-group-flat"> -->
                    <input type="password"
                        name="password"
                        id="password"
                        class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Your password"
                        autocomplete="off"
                    >

                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <!-- </div> -->
                </div>

                <div class="mb-2">
                    <label for="remember" class="form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input"/>
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="text-center text-secondary mt-3">
            Don't have account yet? <a href="<?php echo e(route('register')); ?>" tabindex="-1">
                Sign up
            </a>

            <span class="form-label-description">
                <a href="<?php echo e(route('password.request')); ?>">I forgot password</a>
            </span>
            </div>



        </div>




    </div>





</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/auth/login.blade.php ENDPATH**/ ?>