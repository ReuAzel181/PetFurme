@props([
    'title',
    'value',
    'percentage' => null,
    'trend' => null,
    'icon' => null,
    'color' => 'primary',
    'route' => null,
    'todayCount' => null
])

<div class="card modern-analytics-card" onclick="navigateTo('{{ $route ?? '#' }}')">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center gap-3">
                @if($icon)
                    <div class="analytics-icon" style="background: var(--tblr-{{ $color }})">
                        <i class="{{ $icon }}"></i>
                        @if(isset($todayCount))
                            <div class="today-count" data-bs-toggle="tooltip" title="Added today">
                                +{{ $todayCount }}
                            </div>
                        @endif
                    </div>
                @endif
                <div>
                    <h3 class="analytics-value mb-0">
                        @switch($title)
                            @case("Today's Orders")
                                {{ $value }} {{ $value == 1 ? 'Order' : 'Orders' }}
                                @break
                            @default
                                {{ $value }} {{ $value == 1 ? Str::singular($title) : Str::plural($title) }}
                        @endswitch
                    </h3>
                    <div class="analytics-title">
                        @switch($title)
                            @case('Total Pets')
                                Active Pets in System
                                @break
                            @case('Appointments')
                                Scheduled Appointments
                                @break
                            @case('Pet Owners')
                                Registered Pet Owners
                                @break
                            @case("Today's Orders")
                                Daily Order Summary
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
            @if($percentage !== null)
                <div class="trend-indicator {{ $trend === 'up' ? 'positive' : ($trend === 'down' ? 'negative' : '') }}"
                     data-bs-toggle="tooltip" 
                     title="@switch($title)
                         @case('Total Pets')
                             {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% {{ $trend === 'up' ? 'increase' : 'decrease' }} in pet registrations this month
                             @break
                         @case('Appointments')
                             {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% {{ $trend === 'up' ? 'more' : 'fewer' }} appointments compared to last month
                             @break
                         @case('Pet Owners')
                             {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% {{ $trend === 'up' ? 'growth' : 'decline' }} in active pet owners
                             @break
                         @case("Today's Orders")
                             {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% {{ $trend === 'up' ? 'higher' : 'lower' }} than daily average
                             @break
                     @endswitch">
                    <span class="percentage">{{ is_numeric($percentage) ? number_format($percentage, 1) : 0 }}%</span>
                    <i class="fas fa-arrow-{{ $trend === 'up' ? 'up' : 'down' }}"></i>
                </div>
            @endif
        </div>
        <div class="analytics-context text-muted">
            @switch($title)
                @case('Total Pets')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One pet is' : "{$value} pets are" }} registered in the system. 
                        Pet registrations {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% higher than last month.
                    @else
                        Currently managing {{ $value == 1 ? 'one pet' : "{$value} pets" }}. 
                        {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% decrease in registrations from previous month.
                    @endif
                    @break
                @case('Appointments')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One appointment' : "{$value} appointments" }} in the system. 
                        Booking volume up {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% from last month.
                    @else
                        {{ $value == 1 ? 'One active appointment' : "{$value} active appointments" }}. 
                        {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% reduction in bookings compared to last month.
                    @endif
                    @break
                @case('Pet Owners')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One active pet owner' : "{$value} active pet owners" }} registered. 
                        {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% increase in client base this month.
                    @else
                        {{ $value == 1 ? 'One registered owner' : "{$value} registered owners" }} in database. 
                        {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% decrease in new registrations.
                    @endif
                    @break
                @case("Today's Orders")
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One order processed' : "{$value} orders processed" }} today. 
                        Performance {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% above 30-day average.
                    @else
                        {{ $value == 1 ? 'One order received' : "{$value} orders received" }} today. 
                        {{ is_numeric($percentage) ? number_format(abs($percentage), 1) : 0 }}% below typical daily volume.
                    @endif
                    @break
            @endswitch
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
</script> 