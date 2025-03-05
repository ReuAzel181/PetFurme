<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title',
    'value',
    'percentage' => null,
    'trend' => null,
    'icon' => null,
    'color' => 'primary',
    'route' => null,
    'todayCount' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title',
    'value',
    'percentage' => null,
    'trend' => null,
    'icon' => null,
    'color' => 'primary',
    'route' => null,
    'todayCount' => null
]); ?>
<?php foreach (array_filter(([
    'title',
    'value',
    'percentage' => null,
    'trend' => null,
    'icon' => null,
    'color' => 'primary',
    'route' => null,
    'todayCount' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="card modern-analytics-card" onclick="navigateTo('<?php echo e($route ?? '#'); ?>')">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="analytics-widget-title">
                <i class="<?php echo e($icon); ?> me-2"></i> <?php echo e($title); ?>

            </div>
            <div class="analytics-widget-percentage text-muted">
                <?php echo e($percentage); ?>%
            </div>
        </div>
        <div class="mt-2">
            <span class="text-muted"><?php echo e($todayCount); ?> today</span>
        </div>
    </div>
</div>

<style>
.modern-analytics-card {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.18);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    padding: 0.8rem;
}

.modern-analytics-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    z-index: 1;
}

.modern-analytics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.analytics-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.4rem;
    position: relative;
}

.analytics-value {
    font-size: 1.8rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.2;
}

.analytics-title {
    color: var(--tblr-muted);
    font-size: 1rem;
    font-weight: 500;
    margin-top: -2px;
}

.trend-indicator {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    cursor: help;
    margin-top: 0.25rem;
}

.trend-indicator.positive {
    background: rgba(46, 202, 106, 0.1);
    color: var(--tblr-success);
}

.trend-indicator.negative {
    background: rgba(255, 71, 87, 0.1);
    color: var(--tblr-danger);
}

.analytics-context {
    font-size: 0.8rem;
    line-height: 1.4;
    margin-top: 0.75rem;
    color: #64748b;
    padding-left: calc(48px + 1rem); /* Icon width + gap */
}

.today-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--tblr-primary);
    color: white;
    border-radius: 12px;
    padding: 2px 6px;
    font-size: 0.7rem;
    font-weight: 600;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.analytics-widget-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.analytics-widget-percentage {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<script>
function navigateTo(route) {
    if (route && route !== '#') {
        window.location.href = route;
    }
}
</script> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/dashboard/modern-analytics-widget.blade.php ENDPATH**/ ?>