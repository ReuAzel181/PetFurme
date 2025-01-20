<div class="card calendar-card">
    <div class="card-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Appointments Calendar</h3>
            <div class="d-flex align-items-center gap-3">
                <button id="prevMonth" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="current-month text-dark fw-medium">January</span>
                <button id="nextMonth" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button id="today" class="btn btn-sm btn-primary">Today</button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="monthSelect" data-bs-toggle="dropdown" aria-expanded="false">
                        January
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="monthSelect">
                        @foreach(range(1, 12) as $month)
                            <option class="dropdown-item month-item" data-month="{{ $month - 1 }}" {{ now()->month == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="yearSelect" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ now()->year }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="yearSelect">
                        @for($year = now()->year - 2; $year <= now()->year + 2; $year++)
                            <option class="dropdown-item year-item" data-year="{{ $year }}" {{ now()->year == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </ul>
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
    height: calc(100% - 60px); /* Subtract header height */
}

.calendar-wrapper {
    height: 100%;
    width: 100%;
}

#calendar {
    font-size: 0.7em;
}

/* Hide the default FullCalendar header */
.fc-header-toolbar {
    display: none !important;
}

.fc .fc-daygrid-day {
    height: 10px !important;
}

.calendar-card {
    height: 370px;
    overflow: visible !important; /* Ensure dropdowns can overflow */
}

.fc-view-harness {
    height: 250px !important;
    z-index: 1;
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
    z-index: 1060; /* Increase z-index */
}

.calendar-navigation {
    max-width: 300px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.calendar-controls {
    z-index: 2;
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
    bottom: 4px;
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
</style>

@push('scripts')
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
        events: @json($appointments),
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
@endpush 