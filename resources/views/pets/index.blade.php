<div class="col">
    @include('partials._page_header', [
        'title' => __('Pets'),
        'section' => 'OVERVIEW',
        'button' => [
            'text' => __('Add New Pet'),
            'icon' => 'plus',
            'link' => route('pets.create'),
            'class' => 'btn-primary'
        ]
    ])
</div> 