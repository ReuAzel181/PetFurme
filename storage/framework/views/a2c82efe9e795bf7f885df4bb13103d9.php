<div class="col">
    <?php echo $__env->make('partials._page_header', [
        'title' => __('Pets'),
        'section' => 'OVERVIEW',
        'button' => [
            'text' => __('Add New Pet'),
            'icon' => 'plus',
            'link' => route('pets.create'),
            'class' => 'btn-primary'
        ]
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/pets/index.blade.php ENDPATH**/ ?>