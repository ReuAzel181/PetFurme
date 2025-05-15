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
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center gap-3">
                <?php if($icon): ?>
                    <div class="analytics-icon" style="background: var(--tblr-<?php echo e($color); ?>)">
                        <i class="<?php echo e($icon); ?>"></i>
                        <?php if(isset($todayCount)): ?>
                            <div class="today-count" data-bs-toggle="tooltip" title="Added today">
                                +<?php echo e($todayCount); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <h3 class="analytics-value mb-0">
                        <?php switch($title):
                            case ("Today's Orders"): ?>
                                <?php echo e($value); ?> <?php echo e($value == 1 ? 'Order' : 'Orders'); ?>

                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($value); ?> <?php echo e($value == 1 ? Str::singular($title) : Str::plural($title)); ?>

                        <?php endswitch; ?>
                    </h3>
                    <div class="analytics-title">
                        <?php switch($title):
                            case ('Total Pets'): ?>
                                Active Pets in System
                                <?php break; ?>
                            <?php case ('Appointments'): ?>
                                Scheduled Appointments
                                <?php break; ?>
                            <?php case ('Pet Owners'): ?>
                                Registered Pet Owners
                                <?php break; ?>
                            <?php case ("Today's Orders"): ?>
                                Daily Order Summary
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
            </div>
            <?php if($percentage !== null): ?>
                <div class="trend-indicator <?php echo e($trend === 'up' ? 'positive' : ($trend === 'down' ? 'negative' : '')); ?>"
                     data-bs-toggle="tooltip" 
                     title="<?php switch($title):
                         case ('Total Pets'): ?>
                             <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% <?php echo e($trend === 'up' ? 'increase' : 'decrease'); ?> in pet registrations this month
                             <?php break; ?>
                         <?php case ('Appointments'): ?>
                             <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% <?php echo e($trend === 'up' ? 'more' : 'fewer'); ?> appointments compared to last month
                             <?php break; ?>
                         <?php case ('Pet Owners'): ?>
                             <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% <?php echo e($trend === 'up' ? 'growth' : 'decline'); ?> in active pet owners
                             <?php break; ?>
                         <?php case ("Today's Orders"): ?>
                             <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% <?php echo e($trend === 'up' ? 'higher' : 'lower'); ?> than daily average
                             <?php break; ?>
                     <?php endswitch; ?>">
                    <span class="percentage"><?php echo e(is_numeric($percentage) ? number_format($percentage, 1) : 0); ?>%</span>
                    <i class="fas fa-arrow-<?php echo e($trend === 'up' ? 'up' : 'down'); ?>"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="analytics-context text-muted">
            <?php switch($title):
                case ('Total Pets'): ?>
                    <?php if($trend === 'up'): ?>
                        <?php echo e($value == 1 ? 'One pet is' : "{$value} pets are"); ?> registered in the system. 
                        Pet registrations <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% higher than last month.
                    <?php else: ?>
                        Currently managing <?php echo e($value == 1 ? 'one pet' : "{$value} pets"); ?>. 
                        <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% decrease in registrations from previous month.
                    <?php endif; ?>
                    <?php break; ?>
                <?php case ('Appointments'): ?>
                    <?php if($trend === 'up'): ?>
                        <?php echo e($value == 1 ? 'One appointment' : "{$value} appointments"); ?> in the system. 
                        Booking volume up <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% from last month.
                    <?php else: ?>
                        <?php echo e($value == 1 ? 'One active appointment' : "{$value} active appointments"); ?>. 
                        <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% reduction in bookings compared to last month.
                    <?php endif; ?>
                    <?php break; ?>
                <?php case ('Pet Owners'): ?>
                    <?php if($trend === 'up'): ?>
                        <?php echo e($value == 1 ? 'One active pet owner' : "{$value} active pet owners"); ?> registered. 
                        <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% increase in client base this month.
                    <?php else: ?>
                        <?php echo e($value == 1 ? 'One registered owner' : "{$value} registered owners"); ?> in database. 
                        <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% decrease in new registrations.
                    <?php endif; ?>
                    <?php break; ?>
                <?php case ("Today's Orders"): ?>
                    <?php if($trend === 'up'): ?>
                        <?php echo e($value == 1 ? 'One order processed' : "{$value} orders processed"); ?> today. 
                        Performance <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% above 30-day average.
                    <?php else: ?>
                        <?php echo e($value == 1 ? 'One order received' : "{$value} orders received"); ?> today. 
                        <?php echo e(is_numeric($percentage) ? number_format(abs($percentage), 1) : 0); ?>% below typical daily volume.
                    <?php endif; ?>
                    <?php break; ?>
            <?php endswitch; ?>
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
</style>

<script>
function navigateTo(route) {
    if (route && route !== '#') {
        window.location.href = route;
    }
}
</script> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/dashboard/modern-analytics-widget.blade.php ENDPATH**/ ?>