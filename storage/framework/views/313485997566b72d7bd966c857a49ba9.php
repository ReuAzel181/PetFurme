<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'label' => null ?? ucfirst($name),
    'type' => null ?? 'text',
    'name',
    'id'    => null ?? $name,
    'placeholder' => null,
    'autocomplete' => null ?? 'off',
    'readonly' => false,
    'disabled' => false,
    'required' => false,
    'value' => null ?? old($name)
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'label' => null ?? ucfirst($name),
    'type' => null ?? 'text',
    'name',
    'id'    => null ?? $name,
    'placeholder' => null,
    'autocomplete' => null ?? 'off',
    'readonly' => false,
    'disabled' => false,
    'required' => false,
    'value' => null ?? old($name)
]); ?>
<?php foreach (array_filter(([
    'label' => null ?? ucfirst($name),
    'type' => null ?? 'text',
    'name',
    'id'    => null ?? $name,
    'placeholder' => null,
    'autocomplete' => null ?? 'off',
    'readonly' => false,
    'disabled' => false,
    'required' => false,
    'value' => null ?? old($name)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="mb-3">
    <label for="<?php echo e($id); ?>"
           class="form-label <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> text-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php echo e($required ? 'required' : ''); ?>"
    >
        <?php echo e(__($label)); ?>

    </label>

    <input type="<?php echo e($type); ?>"
           name="<?php echo e($name); ?>"
           id="<?php echo e($id); ?>"
           class="form-control <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           placeholder="<?php echo e($placeholder); ?>"
           autocomplete="<?php echo e($autocomplete); ?>"
           <?php echo e($readonly ? 'readonly' : ''); ?>

           <?php echo e($disabled ? 'disabled' : ''); ?>

           <?php echo e($required ? 'required' : ''); ?>

           
           value="<?php echo e($value); ?>"
    >

    <?php $__errorArgs = [$name];
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
<?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/input/index.blade.php ENDPATH**/ ?>