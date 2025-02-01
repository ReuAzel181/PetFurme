@extends('layouts.tabler')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Pet List'),
                        'section' => 'OVERVIEW'
                    ])
                </div>
            </div>
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Add New Pet
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($pets->isEmpty())
        <div class="alert alert-info text-center">
            No pets found! Click "Add New Pet" to start managing your pets.
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Pet</th>
                            <th>Details</th>
                            <th>Owner</th>
                            <th>Category</th>
                            <th>Next Appointment</th>
                            <th class="w-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $pet)
                        <tr class="cursor-pointer" onclick="showPetDetails({{ $pet->id }})">
                            <td style="width: 15%">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-md me-2" style="background-image: url({{ 
                                        $pet->photo 
                                            ? Storage::disk('public')->exists($pet->photo) 
                                                ? asset('storage/' . $pet->photo)
                                                : asset('images/default-pet.png')
                                            : asset('images/default-pet.png') 
                                    }})"></span>
                                    <div class="font-weight-bold text-primary">{{ $pet->name }}</div>
                                </div>
                            </td>
                            <td style="width: 20%">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                            <path d="M14.7 13.5c-1.1 1.4-2.3 2.5-3.7 2.5-1.4 0-2.6-1.1-3.7-2.5-2.2-2.8-3.3-6.5-3.3-8.5 0-1.1.9-2 2-2 .8 0 1.5.4 1.8 1.1l.2.4c.3.7 1 1.2 1.8 1.2.8 0 1.5-.5 1.8-1.2l.2-.4c.3-.7 1-1.1 1.8-1.1 1.1 0 2 .9 2 2 0 2-1.1 5.7-3.3 8.5z"/>
                                        </svg>
                                        {{ $pet->breed }}
                                    </div>
                                    <div class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                            <path d="M12 7v5l3 3"/>
                                        </svg>
                                        @if($pet->age >= 12)
                                            {{ floor($pet->age/12) }}y
                                            @if($pet->age % 12 > 0)
                                                {{ $pet->age % 12 }}m
                                            @endif
                                        @else
                                            {{ $pet->age }}m
                                        @endif
                                    </div>
                                    <div class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-weight me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                            <path d="M12 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                            <path d="M6.835 9h10.33a1 1 0 0 1 .984 .821l1.637 9a1 1 0 0 1 -.984 1.179h-13.604a1 1 0 0 1 -.984 -1.179l1.637 -9a1 1 0 0 1 .984 -.821z"/>
                                        </svg>
                                        {{ number_format($pet->weight, 1) }} kg
                                    </div>
                                </div>
                            </td>
                            <td style="width: 25%">
                                <div class="d-flex align-items-center gap-2">
                                    @if($pet->user && $pet->user->photo)
                                        <span class="avatar avatar-sm" style="background-image: url({{ Storage::disk('public')->exists($pet->user->photo) ? asset('storage/' . $pet->user->photo) : asset('images/default-avatar.png') }})"></span>
                                    @else
                                        <span class="avatar avatar-sm bg-blue-lt">
                                            {{ strtoupper(substr($pet->user ? $pet->user->name : $pet->owner_name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <div>
                                        <div class="font-weight-medium">{{ $pet->user ? $pet->user->name : $pet->owner_name }}</div>
                                        @if($pet->user)
                                            <div class="text-muted small">
                                                {{ $pet->user->email }}
                                                @if($pet->user->phone)
                                                    <div>{{ $pet->user->phone }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-yellow">Not registered</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="width: 15%">
                                <div class="d-flex flex-column gap-2">
                                    <span class="badge bg-{{ $pet->category === 'Dog' ? 'blue' : ($pet->category === 'Cat' ? 'purple' : 'green') }}-lt">
                                        {{ $pet->category }}
                                    </span>
                                    @if($pet->gender)
                                        <span class="text-muted small d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler {{ $pet->gender === 'Male' ? 'icon-tabler-gender-male' : 'icon-tabler-gender-female' }} me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                @if($pet->gender === 'Male')
                                                    <path d="M10 14m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"/>
                                                    <path d="M19 5l-5.4 5.4"/>
                                                    <path d="M19 5h-5"/>
                                                    <path d="M19 5v5"/>
                                                @else
                                                    <path d="M12 9m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"/>
                                                    <path d="M12 14v7"/>
                                                    <path d="M9 18h6"/>
                                                @endif
                                            </svg>
                                            {{ $pet->gender }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $nextAppointment = $pet->appointments 
                                        ? $pet->appointments->where('appointment_date', '>=', now())->sortBy('appointment_date')->first() 
                                        : null;
                                    $lastAppointment = $pet->appointments 
                                        ? $pet->appointments->where('appointment_date', '<', now())->sortByDesc('appointment_date')->first() 
                                        : null;
                                @endphp
                                @if($nextAppointment)
                                    <div class="d-flex align-items-center">
                                        <span class="status-dot status-green me-2"></span>
                                        <div>
                                            <div class="text-primary">{{ $nextAppointment->appointment_date->format('M d, Y') }}</div>
                                            <div class="text-muted small">{{ $nextAppointment->service_type }}</div>
                                        </div>
                                    </div>
                                @elseif($lastAppointment)
                                    <div class="d-flex align-items-center">
                                        <span class="status-dot status-gray me-2"></span>
                                        <div>
                                            <div class="text-muted">Last visit: {{ $lastAppointment->appointment_date->format('M d, Y') }}</div>
                                            <div class="text-muted small">{{ $lastAppointment->service_type }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <span class="status-dot status-gray me-2"></span>
                                        <span class="text-muted">No appointment history</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap" onclick="event.stopPropagation();">
                                    <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-icon btn-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Are you sure?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Pet Details Div (Hidden by default) -->
                        <div id="petDetails{{ $pet->id }}" class="pet-details-popup" style="display: none;">
                            <div class="card border-0">
                                <!-- Header Section with gradient background -->
                                <div class="pet-details-header position-relative p-4">
                                    <div class="d-flex align-items-center position-relative z-1">
                                        <span class="avatar avatar-xl avatar-rounded border-white border-3 me-3" 
                                              style="background-image: url({{ $pet->photo ? asset('storage/' . $pet->photo) : asset('images/default-pet.png') }})">
                                        </span>
                                        <div class="text-white">
                                            <h2 class="mb-0">{{ $pet->name }}</h2>
                                            <div class="d-flex align-items-center mt-2">
                                                <span class="badge bg-white bg-opacity-20 me-2">{{ $pet->category }}</span>
                                                <span class="badge bg-white bg-opacity-20">{{ $pet->breed }}</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" onclick="hideAllPetDetails()"></button>
                                    </div>
                                    <!-- Decorative element -->
                                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-pet" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none">
                                            <path d="M14.7 13.5c-1.1 1.4-2.3 2.5-3.7 2.5-1.4 0-2.6-1.1-3.7-2.5-2.2-2.8-3.3-6.5-3.3-8.5 0-1.1.9-2 2-2 .8 0 1.5.4 1.8 1.1l.2.4c.3.7 1 1.2 1.8 1.2.8 0 1.5-.5 1.8-1.2l.2-.4c.3-.7 1-1.1 1.8-1.1 1.1 0 2 .9 2 2 0 2-1.1 5.7-3.3 8.5z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Content Section -->
                                <div class="p-4">
                                    <div class="row g-4">
                                        <!-- Left Column - Pet Details -->
                                        <div class="col-md-6">
                                            <div class="info-card bg-azure-lt">
                                                <div class="info-card-header">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                            <path d="M12 8l.01 0"></path>
                                                            <path d="M11 12l1 0l0 4l1 0"></path>
                                                        </svg>
                                                    Pet Details
                                                    </div>
                                                <div class="info-card-body">
                                                    <div class="info-item">
                                                        <span class="info-label">Age</span>
                                                        <span class="info-value">{{ floor($pet->age/12) }}y {{ $pet->age % 12 }}m</span>
                                                    </div>
                                                    <div class="info-item">
                                                        <span class="info-label">Weight</span>
                                                        <span class="info-value">{{ $pet->weight }} kg</span>
                                                    </div>
                                                    @if($pet->allergies)
                                                    <div class="info-item">
                                                        <span class="info-label">Allergies</span>
                                                        <span class="info-value">{{ $pet->allergies }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column - Owner Information -->
                                        <div class="col-md-6">
                                            <div class="info-card bg-purple-lt">
                                                <div class="info-card-header">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                                        <path d="M6.168 18.849a4 4 0 0 1 3.832-2.849h4a4 4 0 0 1 3.834 2.855"/>
                                                    </svg>
                                                        Owner Information
                                                </div>
                                                <div class="info-card-body">
                                                    <div class="info-item">
                                                        <span class="info-label">Name</span>
                                                        <span class="info-value">{{ $pet->user ? $pet->user->name : $pet->owner_name }}</span>
                                                    </div>
                                                    @if($pet->user)
                                                    <div class="info-item">
                                                        <span class="info-label">Email</span>
                                                        <span class="info-value">{{ $pet->user->email }}</span>
                                                        </div>
                                                    @if($pet->user->phone)
                                                    <div class="info-item">
                                                        <span class="info-label">Phone</span>
                                                        <span class="info-value">{{ $pet->user->phone }}</span>
                                                        </div>
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Appointments Section -->
                                        <div class="col-12">
                                            <div class="info-card">
                                                <div class="info-card-header d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                                                            <path d="M16 3v4"/>
                                                            <path d="M8 3v4"/>
                                                            <path d="M4 11h16"/>
                                                        </svg>
                                                        Appointments
                                                    </div>
                                                    <a href="{{ route('appointments.create', ['pet_id' => $pet->id]) }}" class="btn btn-primary">
                                                        Schedule Now
                                                    </a>
                                                </div>
                                                <div class="info-card-body">
                                                    @if($pet->appointments && $pet->appointments->count() > 0)
                                                        <div class="appointment-timeline">
                                                            @foreach($pet->appointments->sortByDesc('appointment_date')->take(3) as $appointment)
                                                            <div class="appointment-item">
                                                                <div class="appointment-date">
                                                                    <div class="date-badge">
                                                                        <div class="month">{{ $appointment->appointment_date->format('M') }}</div>
                                                                        <div class="day">{{ $appointment->appointment_date->format('d') }}</div>
                                                                        <div class="year text-muted">{{ $appointment->appointment_date->format('Y') }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="appointment-content">
                                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                                        @php
                                                                            $serviceTypeColor = match($appointment->service_type) {
                                                                                'Checkup' => 'blue',
                                                                                'Vaccination' => 'green',
                                                                                'Surgery' => 'red',
                                                                                'Grooming' => 'purple',
                                                                                default => 'azure'
                                                                            };
                                                                        @endphp
                                                                        <span class="service-type-icon bg-{{ $serviceTypeColor }}-lt">
                                                                            @switch($appointment->service_type)
                                                                                @case('Checkup')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                                                                        <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                                                                        <path d="M11 3v2" />
                                                                                        <path d="M6 3v2" />
                                                                                        <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Vaccination')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M17 3l4 4" />
                                                                                        <path d="M19 5l-4.5 4.5" />
                                                                                        <path d="M11.5 6.5l6 6" />
                                                                                        <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5" />
                                                                                        <path d="M7.5 12.5l1.5 1.5" />
                                                                                        <path d="M10.5 9.5l1.5 1.5" />
                                                                                        <path d="M3 21l3 -3" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Surgery')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-emergency-bed" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M16 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                        <path d="M8 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                        <path d="M4 8l2.1 2.8a3 3 0 0 0 2.4 1.2h11.5" />
                                                                                        <path d="M10 6h4" />
                                                                                        <path d="M12 4v4" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Grooming')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cut" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M7 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                                        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                                        <path d="M9.15 14.85l8.85 -8.85" />
                                                                                        <path d="M6 4l8.85 8.85" />
                                                                                    </svg>
                                                                                    @break
                                                                                @default
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z" />
                                                                                    </svg>
                                                                            @endswitch
                                                                        </span>
                                                                        <span class="h4 mb-0">{{ $appointment->service_type }}</span>
                                                                    </div>
                                                                    @if($appointment->reason_for_visit)
                                                                    <div class="text-muted mb-2 reason-text">
                                                                        <strong>Reason:</strong> 
                                                                        @if(is_array($appointment->reason_for_visit))
                                                                            {{ implode(', ', $appointment->reason_for_visit) }}
                                                                        @else
                                                                            {{ $appointment->reason_for_visit }}
                                                                        @endif
                                                                    </div>
                                                                    @endif
                                                                    @if($appointment->notes)
                                                                    <div class="text-muted small">
                                                                        <strong>Notes:</strong> {{ $appointment->notes }}
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="empty-state">
                                                            <div class="empty-state-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                                    <path d="M19.823 19.824a2 2 0 0 1-1.823 1.176h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 1.175-1.823m3.825-.177h9a2 2 0 0 1 2 2v9"/>
                                                                    <path d="M16 3v4"/>
                                                                    <path d="M8 3v1"/>
                                                                    <path d="M4 11h7m4 0h5"/>
                                                                    <path d="M3 3l18 18"/>
                                                                </svg>
                                                            </div>
                                                            <p>No appointments scheduled yet</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}
.table-hover tbody tr:hover {
    background-color: rgba(32, 107, 196, 0.03);
}
.pet-details-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.list-group-flush .list-group-item {
    border-color: #f0f0f0;
}

.avatar-lg {
    width: 64px;
    height: 64px;
}

.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}

.status-dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    display: inline-block;
}
.status-green {
    background-color: #2fb344;
}
.status-gray {
    background-color: #dadcde;
}
.bg-light {
    background-color: #f8f9fa;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.04em;
}

.card-banner {
    background: linear-gradient(135deg, #206bc4, #4299e1);
}

.avatar-rounded {
    border-radius: 0.5rem;
}

.border-4 {
    border-width: 4px !important;
}

.bg-azure-lt {
    background-color: rgba(66, 153, 225, 0.1) !important;
}

.bg-purple-lt {
    background-color: rgba(159, 122, 234, 0.1) !important;
}

.bg-green-lt {
    background-color: rgba(72, 187, 120, 0.1) !important;
}

.text-azure {
    color: #4299e1 !important;
}

.text-purple {
    color: #9f7aea !important;
}

.text-green {
    color: #48bb78 !important;
}

.timeline-event-icon {
    background: linear-gradient(135deg, #206bc4, #4299e1);
    box-shadow: 0 0.5rem 1rem rgba(32, 107, 196, 0.1);
}

.timeline-event-card {
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-sm {
    transition: transform 0.2s ease-in-out;
}

.card-sm:hover {
    transform: translateY(-2px);
}

.pet-details-header {
    background: linear-gradient(135deg, #206bc4, #4299e1);
    color: white;
    overflow: hidden;
}

.info-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    height: 100%;
}

.info-card-header {
    padding: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.info-card-body {
    padding: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-size: 0.875rem;
}

.info-value {
    font-weight: 500;
}

.appointment-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.appointment-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.date-badge {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 0.5rem;
    text-align: center;
    min-width: 60px;
}

.date-badge .month {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6c757d;
}

.date-badge .day {
    font-size: 1.25rem;
    font-weight: 600;
    color: #206bc4;
}

.appointment-content {
    flex: 1;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state-icon {
    margin-bottom: 1rem;
    color: #adb5bd;
}

.avatar-xl {
    width: 80px;
    height: 80px;
}

.z-1 {
    z-index: 1;
}

.icon-pet {
    stroke: white;
}

.opacity-10 {
    opacity: 0.1;
}

.service-type-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.service-type-icon svg {
    width: 20px;
    height: 20px;
}

.appointment-item {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
}

.appointment-item:hover {
    transform: translateX(4px);
}

.date-badge {
    background: linear-gradient(to bottom, rgba(32, 107, 196, 0.1), rgba(32, 107, 196, 0.05));
    border-radius: 8px;
    padding: 0.75rem;
    text-align: center;
    min-width: 70px;
    border: 1px solid rgba(32, 107, 196, 0.1);
}

.date-badge .month {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #206bc4;
    font-weight: 600;
}

.date-badge .day {
    font-size: 1.5rem;
    font-weight: 700;
    color: #206bc4;
    line-height: 1.2;
}

.date-badge .year {
    font-size: 0.75rem;
    color: #6c757d;
}

.appointment-content {
    flex: 1;
    background: transparent;
    padding: 0;
}

.h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.gap-2 {
    gap: 0.5rem;
}

.reason-text {
    font-size: 1.1rem !important;  /* Reduced from 1.25rem */
    line-height: 1.4;
    color: #1e293b !important;
}

.info-card-header .btn-primary {
    font-size: 1rem;  /* Reduced from 1.125rem */
    padding: 0.5rem 1rem;  /* Reduced padding slightly */
    font-weight: 500;
}
</style>

<script>
function showPetDetails(petId) {
    // Hide all pet details first
    hideAllPetDetails();
    
    // Show the clicked pet's details
    const detailsDiv = document.getElementById('petDetails' + petId);
    if (detailsDiv) {
        detailsDiv.style.display = 'block';
    }
}

function hideAllPetDetails() {
    // Hide all pet details
    document.querySelectorAll('.pet-details-popup').forEach(el => {
        el.style.display = 'none';
    });
}

// Close popup when clicking escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideAllPetDetails();
    }
});

// Close popup when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.pet-details-popup') && 
        !event.target.closest('.cursor-pointer')) {
        hideAllPetDetails();
    }
});
</script>
@endsection
