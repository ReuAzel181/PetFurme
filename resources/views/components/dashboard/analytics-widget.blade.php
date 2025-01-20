@props(['title', 'value', 'percentage' => null, 'trend' => null, 'icon' => null])

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            @if($icon)
                <div class="subheader">
                    <i class="{{ $icon }} me-2"></i>
                    {{ $title }}
                </div>
            @else
                <div class="subheader">{{ $title }}</div>
            @endif
        </div>
        <div class="d-flex align-items-baseline">
            <div class="h1 mb-0 me-2">{{ $value }}</div>
            @if($percentage !== null)
                <div class="me-auto">
                    <span class="text-{{ $trend === 'up' ? 'success' : ($trend === 'down' ? 'danger' : 'muted') }} d-inline-flex align-items-center lh-1">
                        @if($trend === 'up')
                            <i class="fas fa-arrow-up"></i>
                        @elseif($trend === 'down')
                            <i class="fas fa-arrow-down"></i>
                        @endif
                        {{ $percentage }}%
                    </span>
                </div>
            @endif
        </div>
    </div>
</div> 