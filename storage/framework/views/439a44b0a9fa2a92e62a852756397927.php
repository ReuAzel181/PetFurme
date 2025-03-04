<div class="card calendar-card">
    <div class="card-header position-relative">
        <div class="header-content">
            <!-- Left Section -->
            <div class="header-section">
                <h3 class="card-title">Appointments Calendar</h3>
            </div>

            <!-- Center Section -->
            <div class="header-section">
                <div class="d-flex align-items-center gap-3">
                    <button id="prevMonth" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="current-month text-dark fw-medium">January</span>
                    <button id="nextMonth" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Right Section -->
            <div class="header-section">
                <div class="d-flex align-items-center gap-2 calendar-controls">
                    <button id="today" class="btn btn-sm btn-primary">Today</button>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="monthSelect" data-bs-toggle="dropdown" aria-expanded="false">
                            January
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="monthSelect">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <button class="dropdown-item month-item" data-month="<?php echo e($month - 1); ?>" <?php echo e(now()->month == $month ? 'selected' : ''); ?>>
                                        <?php echo e(date('F', mktime(0, 0, 0, $month, 1))); ?>

                                    </button>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="yearSelect" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo e(now()->year); ?>

                        </button>
                        <ul class="dropdown-menu" aria-labelledby="yearSelect">
                            <?php for($year = now()->year - 2; $year <= now()->year + 2; $year++): ?>
                                <li>
                                    <button class="dropdown-item year-item" data-year="<?php echo e($year); ?>" <?php echo e(now()->year == $year ? 'selected' : ''); ?>>
                                        <?php echo e($year); ?>

                                    </button>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body calendar-container">
        <div id="calendar" class="calendar-wrapper"></div>
    </div>
</div>

<style>
.calendar-container {
    max-height: none;
    padding: 1rem;
    height: 300px;
    position: relative;
    z-index: 1;
}

.calendar-wrapper {
    height: 100%;
    width: 100%;
}

#calendar {
    font-size: 0.8em; /* Slightly smaller font for better fit */
    height: 100%;
}

/* Hide the default FullCalendar header */
.fc-header-toolbar {
    display: none !important;
}

.fc .fc-daygrid-day {
    min-height: 35px !important; /* Reduced minimum height */
    height: auto !important;
}

.calendar-card {
    position: relative;
    min-height: 370px;
    z-index: 1;
}

.calendar-card .card-header {
    overflow: visible;
    position: relative;
    z-index: 2 !important; /* Higher than calendar container */
}

/* Dropdown container */
.calendar-card .dropdown {
    position: relative !important;
}

/* Dropdown button */
.calendar-card .dropdown-toggle {
    position: relative;
    z-index: 3 !important;
}

/* Dropdown menu */
.calendar-card .dropdown-menu {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    z-index: 4 !important; /* Highest in the stack */
    margin-top: 2px;
    max-height: 200px;
    overflow-y: auto;
    min-width: 120px;
    background: var(--tblr-bg-surface);
    border: 1px solid var(--tblr-border-color);
    box-shadow: 0 2px 16px rgba(0,0,0,0.1);
}

/* Calendar view */
.fc-view-harness {
    position: relative;
    z-index: 1 !important;
}

/* Ensure dropdowns don't get cut off */
.dropdown-menu.show {
    transform: none !important;
    display: block !important;
}

/* Month/Year dropdown items */
.dropdown-item {
    padding: 0.5rem 1rem;
    cursor: pointer;
    white-space: nowrap;
}

.dropdown-item:hover {
    background-color: var(--tblr-bg-surface-secondary);
}

/* Fix calendar positioning */
.flatpickr-calendar {
    z-index: 1060 !important;
}

/* Ensure proper stacking context */
.calendar-navigation {
    position: relative;
    z-index: 1070 !important;
}

/* Calendar controls */
.calendar-controls {
    position: relative;
    z-index: 3 !important; /* Higher than header */
}

/* Make dropdowns more prominent */
.btn-outline-secondary.dropdown-toggle {
    background-color: var(--tblr-bg-surface);
    border-color: var(--tblr-border-color);
}

.btn-outline-secondary.dropdown-toggle:hover,
.btn-outline-secondary.dropdown-toggle:focus {
    background-color: var(--tblr-bg-surface-secondary);
}

/* Custom select styles */
#monthSelect, #yearSelect {
    font-size: 0.8rem;
    height: 24px;
    padding: 0 0.5rem;
    border: 1px solid #dee2e6;
    background: #fff;
    border-radius: 4px;
    cursor: pointer;
    color: #1e293b;
}

/* Button group styles */
.btn-group {
    border-radius: 4px;
    overflow: hidden;
    display: inline-flex;
}

.btn-group .btn {
    padding: 2px 8px;
    font-size: 0.8rem;
    border: 1px solid #dee2e6;
    background-color: #fff;
    color: #1e293b;
}

.btn-primary {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    background-color: #206bc4;
    border-color: #206bc4;
}

.btn-primary:hover {
    background-color: #1a569d !important;
}

.btn-group .btn:not(:last-child) {
    border-right: none;
}

.btn-group .btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

/* Calendar day styles */
.fc-day-today {
    background: rgba(32, 107, 196, 0.03) !important;
}

.fc-day-header {
    font-weight: 600 !important;
    color: #1e293b !important;
}

.fc-daygrid-day.fc-day-has-events {
    background-color: rgba(32, 107, 196, 0.03);
}

/* Event tooltip styles */
.tippy-box {
    background-color: white;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tippy-box[data-theme~='light-border'] .tippy-content {
    padding: 0;
}

.current-month {
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    min-width: 80px;
    text-align: center;
}

.gap-2 {
    gap: 0.5rem !important;
}

.gap-3 {
    gap: 0.75rem !important;
}

.gap-4 {
    gap: 2rem !important;
}

.card-header {
    padding: 0.75rem 1rem;
    overflow: hidden;
    border-bottom: 1px solid rgba(0,0,0,.075);
    position: relative;
    z-index: 2 !important; /* Higher than calendar container */
}

.calendar-navigation {
    max-width: 300px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.calendar-controls {
    z-index: 3 !important; /* Higher than header */
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1061;
    margin-top: 2px;
    max-height: 300px;
    overflow-y: auto;
    min-width: 120px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dropdown-item {
    padding: 0.25rem 1rem;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.btn-outline-secondary {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-color: #dee2e6;
    background-color: #fff;
    min-width: 32px;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.btn-outline-secondary:focus {
    box-shadow: none;
}

.dropdown-toggle {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    white-space: nowrap;
}

.dropdown-toggle::after {
    margin-left: 0.5rem;
}

.card-title {
    font-size: 1rem;
    margin: 0;
    color: #1e293b;
    white-space: nowrap;
}

/* Make sure the calendar fills the available space */
#calendar {
    width: 100%;
    font-size: 0.7em;
}

/* Ensure consistent button heights */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Remove any unwanted margins from flex containers */
.d-flex {
    margin: 0;
}

/* Ensure the center section stays centered */
.d-flex.justify-content-between {
    gap: 1rem;
}

/* Keep dropdowns from wrapping */
.dropdown-toggle {
    white-space: nowrap;
}

.calendar-section {
    padding: 0 1rem;
}

.calendar-section:first-child {
    padding-left: 0;
}

.calendar-section:last-child {
    padding-right: 0;
}

.flex-grow-1 {
    flex: 1;
}

/* Ensure proper spacing between sections */
.d-flex.align-items-center {
    gap: 1rem;
}

/* Remove the calendar section styles that were adding extra padding */
.calendar-section {
    display: none;
}

/* Ensure proper spacing between elements */
.d-flex.justify-content-between {
    width: 100%;
}

/* Style for days with events - much stronger highlight */
.fc-daygrid-day.fc-day-has-events {
    background-color: rgba(55, 136, 216, 0.2) !important;
    border: 2px solid rgba(55, 136, 216, 0.3) !important;
    border-radius: 6px;
    position: relative;
    box-shadow: 0 2px 4px rgba(55, 136, 216, 0.1);
}

.fc-daygrid-day-number.has-events {
    font-weight: 700;
    color: #206bc4;
    background: rgba(55, 136, 216, 0.1);
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 2px;
}

/* Today's date highlight - stronger */
.fc-day-today {
    background-color: rgba(56, 193, 114, 0.2) !important;
    border: 2px solid rgba(56, 193, 114, 0.3) !important;
    border-radius: 6px !important;
    box-shadow: 0 2px 4px rgba(56, 193, 114, 0.1);
}

.fc-day-today .fc-daygrid-day-number {
    color: #2ca05a;
    font-weight: 700;
    background: rgba(56, 193, 114, 0.1);
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 2px;
}

/* Hover effect for days with events */
.fc-daygrid-day:hover {
    background-color: rgba(55, 136, 216, 0.15);
    transition: background-color 0.2s ease;
}

/* Add event indicator dots */
.fc-daygrid-day.fc-day-has-events::after {
    content: '';
    position: absolute;
    bottom: 1px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    background-color: #206bc4;
    border-radius: 50%;
    box-shadow: -6px 0 0 #206bc4, 6px 0 0 #206bc4;
}

/* Update the calendar dropdown styles */
.calendar-card .card-header {
    position: relative;
    z-index: 1060; /* Increase z-index */
}

.calendar-card .dropdown {
    position: relative; /* Change from static to relative */
}

.calendar-card .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1061;
    margin-top: 2px;
    max-height: 300px;
    overflow-y: auto;
    min-width: 120px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Remove any interfering styles */
.fc-view-harness {
    z-index: 1;
}

.calendar-card {
    overflow: visible !important; /* Ensure dropdowns can overflow */
}

/* Make sure the calendar grid fills the space */
.fc-daygrid-body {
    height: 100% !important;
}

.fc-scrollgrid-sync-table {
    height: 100% !important;
}

/* Adjust day cell frame spacing */
.fc-daygrid-day-frame {
    padding: 1px !important;
    min-height: 35px !important; /* Match the day cell height */
}

/* Optional: Adjust day number size for smaller cells */
.fc-daygrid-day-number {
    font-size: 0.75em;
    padding: 2px !important;
}

/* Adjust event dot size */
.fc-daygrid-event-dot {
    width: 4px !important;
    height: 4px !important;
}

/* Add these styles */
.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.header-section {
    flex: 1;
    display: flex;
    align-items: center;
}

/* Left section alignment */
.header-section:first-child {
    justify-content: flex-start;
}

/* Center section alignment */
.header-section:nth-child(2) {
    justify-content: center;
}

/* Right section alignment */
.header-section:last-child {
    justify-content: flex-end;
}

/* Ensure the card title doesn't grow too wide */
.card-title {
    white-space: nowrap;
    margin: 0;
}

/* Keep the calendar controls from growing too wide */
.calendar-controls {
    white-space: nowrap;
}

/* Remove any overflow restrictions from parent elements */
.card-body {
    overflow: visible !important;
}

/* Optional: Adjust dropdown position for better visibility */
.calendar-controls .dropdown-menu {
    overflow-x: hidden;
    min-width: 120px;
    max-width: 200px;
}

/* Ensure parent containers don't clip dropdowns */
.card-body,
.calendar-container,
.calendar-wrapper {
    overflow: visible !important;
}

/* Optional: Adjust dropdown appearance */
.calendar-controls .dropdown-menu {
    border-radius: 4px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

/* Update dark mode styles for activities */
.activities-container {
    /* Existing styles */
    background: var(--tblr-bg-surface);
    color: var(--tblr-body-color);
}

/* Activity item styles */
.activity-item {
    border-left: 2px solid var(--tblr-border-color);
    padding: 0.75rem 1rem;
    position: relative;
    background: var(--tblr-bg-surface);
}

.activity-item:hover {
    background: var(--tblr-bg-surface-secondary);
}

/* Activity content styles */
.activity-content {
    color: var(--tblr-body-color);
}

/* Activity meta text */
.activity-meta {
    color: var(--tblr-muted);
    font-size: 0.875rem;
}

/* Activity icons */
.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: var(--tblr-primary);
    color: #ffffff;
}

/* Activity types */
.activity-appointment {
    border-left-color: var(--tblr-primary);
}

.activity-order {
    border-left-color: var(--tblr-success);
}

.activity-user {
    border-left-color: var(--tblr-info);
}

.activity-product {
    border-left-color: var(--tblr-warning);
}

/* Activity links */
.activity-item a {
    color: var(--tblr-primary);
    text-decoration: none;
}

.activity-item a:hover {
    text-decoration: underline;
}

/* Time stamp */
.activity-time {
    color: var(--tblr-muted);
    font-size: 0.75rem;
}

/* Status badges */
.activity-status {
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pending {
    background: var(--tblr-warning-subtle);
    color: var(--tblr-warning);
}

.status-completed {
    background: var(--tblr-success-subtle);
    color: var(--tblr-success);
}

.status-cancelled {
    background: var(--tblr-danger-subtle);
    color: var(--tblr-danger);
}

/* Dark mode compatibility styles */
[data-bs-theme="dark"] .card-header {
    background-color: var(--tblr-bg-surface) !important;
    border-color: var(--tblr-border-color);
}

[data-bs-theme="dark"] .sticky-top {
    background-color: var(--tblr-bg-surface) !important;
}

[data-bs-theme="dark"] .btn-outline-secondary {
    border-color: var(--tblr-border-color);
    color: var(--tblr-body-color);
    background-color: var(--tblr-bg-surface);
}

[data-bs-theme="dark"] .btn-outline-secondary:hover {
    background-color: var(--tblr-bg-surface-secondary);
    border-color: var(--tblr-border-color);
    color: var(--tblr-body-color);
}

[data-bs-theme="dark"] .current-month {
    color: var(--tblr-body-color);
}

[data-bs-theme="dark"] .card-title {
    color: var(--tblr-body-color);
}

[data-bs-theme="dark"] .fc-day-today {
    background: rgba(var(--tblr-primary-rgb), 0.1) !important;
}

[data-bs-theme="dark"] .fc-daygrid-day.fc-day-has-events {
    background-color: rgba(var(--tblr-primary-rgb), 0.1);
}

[data-bs-theme="dark"] .fc-daygrid-day-number {
    color: var(--tblr-body-color);
}

[data-bs-theme="dark"] .fc th {
    color: var(--tblr-muted);
}

/* Update dropdown styles for dark mode */
[data-bs-theme="dark"] .dropdown-menu {
    background-color: var(--tblr-bg-surface);
    border-color: var(--tblr-border-color);
}

[data-bs-theme="dark"] .dropdown-item {
    color: var(--tblr-body-color);
}

[data-bs-theme="dark"] .dropdown-item:hover {
    background-color: var(--tblr-bg-surface-secondary);
    color: var(--tblr-body-color);
}

/* Update tooltip styles for dark mode */
[data-bs-theme="dark"] .tippy-box {
    background-color: var(--tblr-bg-surface);
    border-color: var(--tblr-border-color);
    color: var(--tblr-body-color);
}

/* Calendar grid lines for dark mode */
[data-bs-theme="dark"] .fc-theme-standard td,
[data-bs-theme="dark"] .fc-theme-standard th {
    border-color: var(--tblr-border-color);
}

[data-bs-theme="dark"] .fc-theme-standard .fc-scrollgrid {
    border-color: var(--tblr-border-color);
}
</style>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tippy.js@6.3.7/dist/tippy.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: '100%',
        headerToolbar: false,
        events: <?php echo json_encode($appointments, 15, 512) ?>,
        eventDidMount: function(info) {
            tippy(info.el, {
                content: `
                    <div class="p-2">
                        <strong>${info.event.title}</strong><br>
                        <small>${info.event.extendedProps.description}</small>
                    </div>
                `,
                allowHTML: true,
                theme: 'light-border',
                placement: 'top',
                interactive: true
            });
        },
        eventClick: function(info) {
            window.location.href = `/appointments/${info.event.id}`;
        },
        dayCellDidMount: function(info) {
            const events = calendar.getEvents();
            const hasEvent = events.some(event => {
                return info.date.toDateString() === new Date(event.start).toDateString();
            });
            
            if (hasEvent) {
                info.el.style.backgroundColor = 'rgba(55, 136, 216, 0.1)';
                info.el.style.borderRadius = '4px';
            }
        },
        dayCellContent: function(info) {
            const events = calendar.getEvents();
            const dayEvents = events.filter(event => 
                info.date.toDateString() === new Date(event.start).toDateString()
            );
            
            const dayNumber = document.createElement('div');
            dayNumber.classList.add('fc-daygrid-day-number');
            dayNumber.innerText = info.dayNumberText;
            
            if (dayEvents.length > 0) {
                dayNumber.classList.add('has-events');
            }
            
            return { domNodes: [dayNumber] };
        }
    });
    calendar.render();

    // Set initial values
    const currentDate = calendar.getDate();
    document.getElementById('monthSelect').value = currentDate.getMonth();
    document.getElementById('yearSelect').value = currentDate.getFullYear();

    // Navigation handlers
    document.getElementById('monthSelect').addEventListener('change', function() {
        const year = document.getElementById('yearSelect').value;
        calendar.gotoDate(new Date(year, this.value, 1));
    });

    document.getElementById('yearSelect').addEventListener('change', function() {
        const month = document.getElementById('monthSelect').value;
        calendar.gotoDate(new Date(this.value, month, 1));
    });

    document.getElementById('prevMonth').addEventListener('click', function() {
        calendar.prev();
        updateSelects();
    });

    document.getElementById('nextMonth').addEventListener('click', function() {
        calendar.next();
        updateSelects();
    });

    document.getElementById('today').addEventListener('click', function() {
        calendar.today();
        updateSelects();
    });

    function updateSelects() {
        const date = calendar.getDate();
        document.getElementById('monthSelect').value = date.getMonth();
        document.getElementById('yearSelect').value = date.getFullYear();
        // Update the month text in header
        document.querySelector('.current-month').textContent = date.toLocaleString('default', { month: 'long' });
    }

    // Call updateSelects initially and after any navigation
    updateSelects();
    
    calendar.on('datesSet', function() {
        updateSelects();
    });

    // Update month dropdown text
    function updateMonthDropdown(month) {
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];
        document.getElementById('monthSelect').textContent = monthNames[month];
    }

    // Update year dropdown text
    function updateYearDropdown(year) {
        document.getElementById('yearSelect').textContent = year;
    }

    // Month dropdown handler
    document.querySelectorAll('.month-item').forEach(item => {
        item.addEventListener('click', function() {
            const month = parseInt(this.dataset.month);
            const year = calendar.getDate().getFullYear();
            calendar.gotoDate(new Date(year, month, 1));
            updateMonthDropdown(month);
        });
    });

    // Year dropdown handler
    document.querySelectorAll('.year-item').forEach(item => {
        item.addEventListener('click', function() {
            const year = parseInt(this.dataset.year);
            const month = calendar.getDate().getMonth();
            calendar.gotoDate(new Date(year, month, 1));
            updateYearDropdown(year);
        });
    });

    function updateSelects() {
        const date = calendar.getDate();
        updateMonthDropdown(date.getMonth());
        updateYearDropdown(date.getFullYear());
        document.querySelector('.current-month').textContent = 
            date.toLocaleString('default', { month: 'long' });
    }

    // Initial update
    updateSelects();

    // Make calendar available globally for resize
    window.calendar = calendar;
});
</script>
<?php $__env->stopPush(); ?> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/dashboard/appointment-calendar.blade.php ENDPATH**/ ?>