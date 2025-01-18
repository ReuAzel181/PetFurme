@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">

            <div class="row g-2 align-items-center">

                <div class="col">
                    <div class="page-pretitle text-muted text-uppercase">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <x-icon.plus />
                            Create new order
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn btn-primary d-sm-none btn-icon"
                            aria-label="Create new report">
                            <x-icon.plus />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <!-- COMMENT MULA DITO -->
                <!-- DELETED COMMENT #1 -->
                <!-- COMMENT HANGGANG DITO -->

                <!-- PETS -->

                <div class="col-12">
                    <div class="row row-cards">

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm" style="background-color: rgba(93, 74, 199, 0.40) !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span
                                                class="bg-violet text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                                <img src="assets/img2/pet_icon.png" alt="Pet Icon"
                                                    class="icon icon-tabler icon-tabler-files" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                                    <path
                                                        d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                {{ $totalPets ?? 0 }} Pets <!-- Use $totalPets for total count -->
                                            </div>
                                            <div class="text-muted">
                                                {{ $todayPets ?? 0 }} today <!-- Use $todayPets for today's count -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- PET OWNERS -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm" style="background-color: rgba(187, 88, 205, 0.40) !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span
                                                class="bg-orchid text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                                <img src="assets/img2/user_icon.png" alt="Pet Owner Icon"
                                                    class="icon icon-tabler icon-tabler-files" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                                    <path
                                                        d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                        <div class="font-weight-medium">
                                                {{ $totalPetOwners }} Pet Owners
                                            </div>
                                            <div class="text-muted">
                                                {{ $todayPetOwners }} today
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- APPOINTMENTS -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm" style="background-color: rgba(238, 83, 79, 0.40) !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-crimson text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                            <img src="assets/img2/apmt_icon.png" alt="Appointment Icon"
                                                    class="icon icon-tabler icon-tabler-files" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                                    <path
                                                        d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                            </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                {{ $appointments }} Appointments
                                            </div>
                                            <div class="text-muted">
                                                {{ $todayAppointments }} today
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PRODUCTS -->
                    
                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm" style="background-color: rgba(2, 84, 155, 0.40) !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span
                                                class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                <img src="assets/img2/shop_icon.png" alt="Products Icon"
                                                    class="icon icon-tabler icon-tabler-packages" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                                    <path d="M2 13.5v5.5l5 3" />
                                                    <path d="M7 16.545l5 -3.03" />
                                                    <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                                    <path d="M12 19l5 3" />
                                                    <path d="M17 16.5l5 -3" />
                                                    <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                                                    <path d="M7 5.03v5.455" />
                                                    <path d="M12 8l5 -3" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                {{ $products }} Products
                                            </div>
                                            <div class="text-muted">
                                                {{ $categories }} categories
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-13">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-3">
                        </div>
                    </div>
                </div>

                
            </div>
        </div>

        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title mb-0">Recent Activities</h3>
                            <small class="text-muted">Track all system activities</small>
                        </div>
                        <div class="ms-auto">
                            <form method="GET" class="d-flex gap-2">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                        </svg>
                                    </span>
                                    <input type="date" class="form-control" name="from_date" value="{{ $fromDate }}">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control" name="to_date" value="{{ $toDate }}">
                                </div>
                                <select name="sort_by" class="form-select" style="width: auto;">
                                    <option value="date" {{ $sortBy === 'date' ? 'selected' : '' }}>Latest First</option>
                                    <option value="type" {{ $sortBy === 'type' ? 'selected' : '' }}>By Activity Type</option>
                                    <option value="description" {{ $sortBy === 'description' ? 'selected' : '' }}>By Description</option>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                    Filter
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="scrollable-container" style="max-height: 500px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-hover table-sticky">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            <th class="w-1">Time</th>
                                            <th class="w-1">Type</th>
                                            <th>Details</th>
                                            <th class="w-1">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentEvents as $event)
                                            <tr>
                                                <td class="text-muted">
                                                    <span data-bs-toggle="tooltip" 
                                                          title="{{ Carbon\Carbon::parse($event->created_at)->format('M d, Y h:i A') }}">
                                                        {{ Carbon\Carbon::parse($event->date)->format('M d') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $typeInfo = match($event->type) {
                                                            'appointment' => [
                                                                'color' => 'blue',
                                                                'icon' => 'calendar',
                                                                'label' => 'Appointment',
                                                                'status' => 'Upcoming'
                                                            ],
                                                            'low_stock' => [
                                                                'color' => 'yellow',
                                                                'icon' => 'alert-triangle',
                                                                'label' => 'Low Stock',
                                                                'status' => 'Warning'
                                                            ],
                                                            'out_of_stock' => [
                                                                'color' => 'red',
                                                                'icon' => 'x-circle',
                                                                'label' => 'Out of Stock',
                                                                'status' => 'Critical'
                                                            ],
                                                            'new_product' => [
                                                                'color' => 'azure',
                                                                'icon' => 'package',
                                                                'label' => 'New Product',
                                                                'status' => 'Added'
                                                            ],
                                                            'new_pet' => [
                                                                'color' => 'green',
                                                                'icon' => 'paw',
                                                                'label' => 'New Pet',
                                                                'status' => 'Registered'
                                                            ],
                                                            'new_pet_owner' => [
                                                                'color' => 'purple',
                                                                'icon' => 'user-plus',
                                                                'label' => 'New Owner',
                                                                'status' => 'Registered'
                                                            ],
                                                            'new_order' => [
                                                                'color' => 'indigo',
                                                                'icon' => 'shopping-cart',
                                                                'label' => 'New Order',
                                                                'status' => 'Placed'
                                                            ],
                                                            default => [
                                                                'color' => 'gray',
                                                                'icon' => 'info-circle',
                                                                'label' => 'Activity',
                                                                'status' => 'Info'
                                                            ]
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $typeInfo['color'] }}-lt" 
                                                          style="font-size: 0.9em; padding: 0.5em 0.8em;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                                             class="icon icon-{{ $typeInfo['icon'] }}" 
                                                             width="24" height="24" viewBox="0 0 24 24" 
                                                             stroke-width="2" stroke="currentColor" 
                                                             fill="none" stroke-linecap="round" 
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <!-- Add appropriate icon path here -->
                                                        </svg>
                                                        {{ $typeInfo['label'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="font-weight-medium">{{ $event->description }}</div>
                                                            <div class="text-muted small">
                                                                @switch($event->type)
                                                                    @case('appointment')
                                                                        Scheduled appointment
                                                                        @break
                                                                    @case('new_pet')
                                                                        New pet registered in the system
                                                                        @break
                                                                    @case('new_pet_owner')
                                                                        New pet owner account created
                                                                        @break
                                                                @endswitch
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @switch($event->type)
                                                        @case('appointment')
                                                            <span class="status status-blue">
                                                                Scheduled
                                                            </span>
                                                            @break
                                                        @case('new_pet')
                                                            <span class="status status-green">
                                                                Active
                                                            </span>
                                                            @break
                                                        @case('new_pet_owner')
                                                            <span class="status status-purple">
                                                                Registered
                                                            </span>
                                                            @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <circle cx="12" cy="12" r="9" />
                                                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                                                <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                                                            </svg>
                                                        </div>
                                                        <p class="empty-title">No activities found</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Try adjusting your search or date range to find what you're looking for.
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-libraries')
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script>
@endpush

@pushonce('page-scripts')
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "Profits",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
                chart: {
                    type: "line",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                fill: {
                    opacity: 1,
                },
                stroke: {
                    width: [2, 1],
                    dashArray: [0, 3],
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "May",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67
                    ]
                }, {
                    name: "April",
                    data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35,
                        41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary"), tabler.getColor("gray-600")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-active-users'), {
                chart: {
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: "Profits",
                    data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93,
                        53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67
                    ]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
                    '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29',
                    '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04',
                    '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09',
                    '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14',
                    '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
                ],
                colors: [tabler.getColor("primary")],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
    </script>
@endpushonce

<style>
    .scrollable-container::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .table-sticky thead {
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .scrollable-container {
        border-top: 1px solid rgba(98, 105, 118, 0.16);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(98, 105, 118, 0.06);
    }
</style>
