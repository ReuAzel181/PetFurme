<div class="col-sm-3">
    <div class="card stat-card h-100">
        <div class="card-body p-2">
            <div class="d-flex align-items-center">
                <span class="bg-blue-lt rounded p-2 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 5h2"></path>
                        <path d="M19 12c-.667 5.333-2.333 8-5 8h-4c-2.667 0-4.333-2.667-5-8"></path>
                        <path d="M11 16c0 .667.333 1 1 1s1-.333 1-1h-2z"></path>
                        <path d="M12 18v2"></path>
                        <path d="M10 11v.01"></path>
                        <path d="M14 11v.01"></path>
                        <path d="M5 4l6 .97l6-.97l2 4l-4 2l-8 0l-4-2z"></path>
                    </svg>
                </span>
                <div>
                    <div class="font-weight-medium">{{ $user->pets_count }}</div>
                    <div class="text-muted small">{{ Str::plural('Pet', $user->pets_count) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-3">
    <div class="card stat-card h-100">
        <div class="card-body p-2">
            <div class="d-flex align-items-center">
                <span class="bg-green-lt rounded p-2 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 5m0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2z"></path>
                        <path d="M16 3v4"></path>
                        <path d="M8 3v4"></path>
                        <path d="M4 11h16"></path>
                        <path d="M9 16l2 2l4-4"></path>
                    </svg>
                </span>
                <div>
                    <div class="font-weight-medium">{{ $user->appointments_count }}</div>
                    <div class="text-muted small">{{ Str::plural('Appointment', $user->appointments_count) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-3">
    <div class="card stat-card h-100">
        <div class="card-body p-2">
            <div class="d-flex align-items-center">
                <span class="bg-purple-lt rounded p-2 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0"></path>
                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0"></path>
                        <path d="M17 17h-11v-14h-2"></path>
                        <path d="M6 5l14 1l-1 7h-13"></path>
                    </svg>
                </span>
                <div>
                    <div class="font-weight-medium">{{ $user->orders_count }}</div>
                    <div class="text-muted small">{{ Str::plural('Order', $user->orders_count) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-3">
    <div class="card stat-card h-100">
        <div class="card-body p-2">
            <div class="d-flex align-items-center">
                <span class="bg-yellow-lt rounded p-2 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-peso" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 19v-14h3.5a4.5 4.5 0 1 1 0 9h-3.5"></path>
                        <path d="M18 8h-12"></path>
                        <path d="M18 11h-12"></path>
                    </svg>
                </span>
                <div>
                    <div class="font-weight-medium">₱{{ number_format($user->orders->sum('total'), 2) }}</div>
                    <div class="text-muted small">Total Spent</div>
                </div>
            </div>
        </div>
    </div>
</div> 