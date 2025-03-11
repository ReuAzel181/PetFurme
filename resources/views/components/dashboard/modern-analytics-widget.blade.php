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
    <div class="card-body p-0">
        <div class="analytics-top-content">
            <div class="analytics-icon-text">
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
                <div class="analytics-text-content">
                    <h3 class="analytics-value mb-0">
                        @switch($title)
                            @case("Today's Orders")
                                <span class="analytics-value-number">{{ $value }}</span>
                                <span class="analytics-value-text">{{ $value == 1 ? 'Order' : 'Orders' }}</span>
                                @break
                            @default
                                <span class="analytics-value-number">{{ $value }}</span>
                                <span class="analytics-value-text">{{ $value == 1 ? Str::singular($title) : Str::plural($title) }}</span>
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
                             {{ abs(number_format($percentage, 1)) }}% {{ $trend === 'up' ? 'increase' : 'decrease' }} in pet registrations this month
                             @break
                         @case('Appointments')
                             {{ abs(number_format($percentage, 1)) }}% {{ $trend === 'up' ? 'more' : 'fewer' }} appointments compared to last month
                             @break
                         @case('Pet Owners')
                             {{ abs(number_format($percentage, 1)) }}% {{ $trend === 'up' ? 'growth' : 'decline' }} in active pet owners
                             @break
                         @case("Today's Orders")
                             {{ abs(number_format($percentage, 1)) }}% {{ $trend === 'up' ? 'higher' : 'lower' }} than daily average
                             @break
                     @endswitch">
                    <span class="percentage">{{ number_format($percentage, 1) }}%</span>
                    <i class="fas fa-arrow-{{ $trend === 'up' ? 'up' : 'down' }}"></i>
                </div>
            @endif
        </div>
        <div class="analytics-context">
            @switch($title)
                @case('Total Pets')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One pet is' : "{$value} pets are" }} registered in the system. 
                        Pet registrations {{ abs(number_format($percentage, 1)) }}% higher than last month.
                    @else
                        Currently managing {{ $value == 1 ? 'one pet' : "{$value} pets" }}. 
                        {{ abs(number_format($percentage, 1)) }}% decrease in registrations from previous month.
                    @endif
                    @break
                @case('Appointments')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One appointment' : "{$value} appointments" }} in the system. 
                        Booking volume up {{ abs(number_format($percentage, 1)) }}% from last month.
                    @else
                        {{ $value == 1 ? 'One active appointment' : "{$value} active appointments" }}. 
                        {{ abs(number_format($percentage, 1)) }}% reduction in bookings compared to last month.
                    @endif
                    @break
                @case('Pet Owners')
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One active pet owner' : "{$value} active pet owners" }} registered. 
                        {{ abs(number_format($percentage, 1)) }}% increase in client base this month.
                    @else
                        {{ $value == 1 ? 'One registered owner' : "{$value} registered owners" }} in database. 
                        {{ abs(number_format($percentage, 1)) }}% decrease in new registrations.
                    @endif
                    @break
                @case("Today's Orders")
                    @if($trend === 'up')
                        {{ $value == 1 ? 'One order processed' : "{$value} orders processed" }} today. 
                        Performance {{ abs(number_format($percentage, 1)) }}% above 30-day average.
                    @else
                        {{ $value == 1 ? 'One order received' : "{$value} orders received" }} today. 
                        {{ abs(number_format($percentage, 1)) }}% below typical daily volume.
                    @endif
                    @break
            @endswitch
        </div>
    </div>
</div>

<style>
.modern-analytics-card {
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    padding: 1.25rem;
    height: 180px;
    display: flex;
    flex-direction: column;
}

.modern-analytics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.analytics-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    position: relative;
}

.analytics-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #000000;
    line-height: 1.2;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: baseline;
    gap: 0.3rem;
    white-space: nowrap;
    overflow: hidden;
}

.analytics-value-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000000;
}

.analytics-value-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: #000000;
}

.analytics-title {
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 400;
    margin-top: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.01em;
}

.trend-indicator {
    padding: 0.2rem 0.5rem;
    border-radius: 16px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    cursor: help;
    margin-top: 0.25rem;
    width: fit-content;
    max-width: 90px;
    text-align: center;
}

.trend-indicator.positive {
    background: rgba(46, 202, 106, 0.2);
    color: #2e7d32;
}

.trend-indicator.negative {
    background: rgba(255, 71, 87, 0.2);
    color: #c62828;
}

.analytics-context {
    font-size: 0.8rem;
    line-height: 1.3;
    margin-top: 0.5rem;
    color: #64748b;
    padding-left: calc(42px + 0.75rem);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
    font-weight: 400;
}

.today-count {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #007bff;
    color: white;
    border-radius: 10px;
    padding: 1px 4px;
    font-size: 0.7rem;
    font-weight: 600;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.analytics-top-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.25rem;
}

.analytics-icon-text {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.analytics-text-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
</style>

<script>
function navigateTo(route) {
    if (route && route !== '#') {
        window.location.href = route;
    }
}
</script> 