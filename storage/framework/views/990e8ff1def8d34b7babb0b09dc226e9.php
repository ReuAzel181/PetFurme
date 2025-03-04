<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => null ?? 'button',
    'route'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => null ?? 'button',
    'route'
]); ?>
<?php foreach (array_filter(([
    'type' => null ?? 'button',
    'route'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php if(isset($route)): ?>
    <a href="<?php echo e($route); ?>" <?php echo e($attributes->class(['btn btn-primary'])); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->class(['btn btn-primary'])); ?>>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?>
<?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/button/index.blade.php ENDPATH**/ ?>