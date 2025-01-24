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
                            <th>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14.7 13.5c-1.1 1.4-2.3 2.5-3.7 2.5-1.4 0-2.6-1.1-3.7-2.5-2.2-2.8-3.3-6.5-3.3-8.5 0-1.1.9-2 2-2 .8 0 1.5.4 1.8 1.1l.2.4c.3.7 1 1.2 1.8 1.2.8 0 1.5-.5 1.8-1.2l.2-.4c.3-.7 1-1.1 1.8-1.1 1.1 0 2 .9 2 2 0 2-1.1 5.7-3.3 8.5z"/>
                                    </svg>
                                    Pet
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0-18 0"/>
                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0-6 0"/>
                                        <path d="M6.168 18.849a4 4 0 0 1 3.832-2.849h4a4 4 0 0 1 3.834 2.855"/>
                                    </svg>
                                    Owner
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h6v6h-6z"/>
                                        <path d="M14 4h6v6h-6z"/>
                                        <path d="M4 14h6v6h-6z"/>
                                        <path d="M14 14h6v6h-6z"/>
                                    </svg>
                                    Category
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                                        <path d="M16 3l0 4"/>
                                        <path d="M8 3l0 4"/>
                                        <path d="M4 11l16 0"/>
                                        <path d="M8 15h2v2h-2z"/>
                                    </svg>
                                    Next Appointment
                                </div>
                            </th>
                            <th class="w-1">
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                    </svg>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $pet)
                        <tr class="cursor-pointer" onclick="showPetDetails({{ $pet->id }})">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-md me-2" style="background-image: url({{ $pet->photo ? asset('storage/' . $pet->photo) : asset('images/default-pet.png') }})"></span>
                                    <div>
                                        <div class="font-weight-bold text-primary">{{ $pet->name }}</div>
                                        <div class="text-muted small">
                                            {{ $pet->breed }} • 
                                            <span class="text-azure">
                                                @if($pet->age >= 12)
                                                    {{ floor($pet->age/12) }}y
                                                    @if($pet->age % 12 > 0)
                                                        {{ $pet->age % 12 }}m
                                                    @endif
                                                @else
                                                    {{ $pet->age }}m
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs bg-blue-lt me-2">
                                        {{ strtoupper(substr($pet->user ? $pet->user->name : $pet->owner_name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div>{{ $pet->user ? $pet->user->name : $pet->owner_name }}</div>
                                        @if(!$pet->user)
                                            <span class="badge bg-yellow">Not registered</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $pet->category === 'Dog' ? 'blue' : ($pet->category === 'Cat' ? 'purple' : 'green') }}-lt">
                                    {{ $pet->category }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $nextAppointment = $pet->appointments 
                                        ? $pet->appointments->where('appointment_date', '>=', now())->sortBy('appointment_date')->first() 
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
                                @else
                                    <div class="d-flex align-items-center">
                                        <span class="status-dot status-gray me-2"></span>
                                        <span class="text-muted">No upcoming appointments</span>
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
                            <div class="card border-0 shadow">
                                <!-- Add a colorful header banner -->
                                <div class="card-banner bg-primary text-white p-5 position-relative overflow-hidden">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar avatar-xl avatar-rounded border-white border-4" style="background-image: url({{ $pet->photo ? asset('storage/' . $pet->photo) : asset('images/default-pet.png') }})"></span>
                                        </div>
                                        <div class="col">
                                            <h2 class="mb-0">{{ $pet->name }}</h2>
                                            <div class="mt-2">
                                                <span class="badge bg-white text-primary">{{ $pet->category }}</span>
                                                <span class="badge bg-white text-primary">{{ $pet->breed }}</span>
                                                <span class="badge bg-white text-{{ $pet->gender === 'Male' ? 'azure' : 'pink' }}">{{ $pet->gender }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add decorative elements -->
                                    <div class="position-absolute top-0 end-0 p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw opacity-25" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14.7 13.5c-1.1 1.4-2.3 2.5-3.7 2.5-1.4 0-2.6-1.1-3.7-2.5-2.2-2.8-3.3-6.5-3.3-8.5 0-1.1.9-2 2-2 .8 0 1.5.4 1.8 1.1l.2.4c.3.7 1 1.2 1.8 1.2.8 0 1.5-.5 1.8-1.2l.2-.4c.3-.7 1-1.1 1.8-1.1 1.1 0 2 .9 2 2 0 2-1.1 5.7-3.3 8.5z"/>
                                        </svg>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" onclick="hideAllPetDetails()"></button>
                                </div>

                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <!-- Basic Information -->
                                        <div class="col-md-6">
                                            <div class="card card-sm shadow-sm border-0 h-100 bg-azure-lt">
                                                <div class="card-body">
                                                    <h3 class="card-title text-azure d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                            <path d="M12 8l.01 0"></path>
                                                            <path d="M11 12l1 0l0 4l1 0"></path>
                                                        </svg>
                                                        Basic Information
                                                    </h3>
                                                    <div class="mb-2">
                                                        <span class="text-muted">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                                                                <path d="M16 3v4"/>
                                                                <path d="M8 3v4"/>
                                                                <path d="M4 11h16"/>
                                                                <path d="M12 12v3l2 2"/>
                                                            </svg>
                                                            Age:
                                                        </span>
                                                        <strong>{{ floor($pet->age/12) }} years {{ $pet->age % 12 }} months</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted">Weight: </span>
                                                        <strong>{{ $pet->weight }} kg</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted">Allergies: </span>
                                                        <strong>{{ $pet->allergies ?? 'None' }}</strong>
                                                    </div>
                                                    @if($pet->notes)
                                                    <div class="mb-2">
                                                        <span class="text-muted">Special Notes: </span>
                                                        <strong>{{ $pet->notes }}</strong>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Owner Information -->
                                        <div class="col-md-6">
                                            <div class="card card-sm shadow-sm border-0 h-100 bg-purple-lt">
                                                <div class="card-body">
                                                    <h3 class="card-title text-purple d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                                        <path d="M6.168 18.849a4 4 0 0 1 3.832-2.849h4a4 4 0 0 1 3.834 2.855"/>
                                                    </svg>
                                                        Owner Information
                                                    </h3>
                                                    <div class="mb-2">
                                                        <span class="text-muted">Name: </span>
                                                        <strong>{{ $pet->user ? $pet->user->name : $pet->owner_name }}</strong>
                                                    </div>
                                                    @if($pet->user)
                                                        <div class="mb-2">
                                                            <span class="text-muted">Email: </span>
                                                            <strong>{{ $pet->user->email }}</strong>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="text-muted">Phone: </span>
                                                            <strong>{{ $pet->user->phone ?? 'Not provided' }}</strong>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="text-muted">Address: </span>
                                                            <strong>{{ $pet->user->address ?? 'Not provided' }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Appointment History with new styling -->
                                        <div class="col-12">
                                            <div class="card shadow-sm border-0">
                                                <div class="card-header bg-green-lt border-0">
                                                    <h3 class="card-title text-green d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-stats me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                                                            <path d="M16 3v4"/>
                                                            <path d="M8 3v4"/>
                                                            <path d="M4 11h16"/>
                                                            <path d="M8 14v3"/>
                                                            <path d="M12 14v3"/>
                                                            <path d="M16 14v3"/>
                                                        </svg>
                                                        Appointment History
                                                    </h3>
                                                    <a href="{{ route('appointments.create', ['pet_id' => $pet->id]) }}" class="btn btn-primary btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 5v14M5 12h14"/>
                                                        </svg>
                                                        Schedule Appointment
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    @if($pet->appointments && $pet->appointments->count() > 0)
                                                        <div class="timeline">
                                                            @foreach($pet->appointments->sortByDesc('appointment_date') as $appointment)
                                                                <div class="timeline-event">
                                                                    <div class="timeline-event-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M6 4h-1a2 2 0 0 0-2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0-2-2h-1"/>
                                                                            <path d="M8 15a6 6 0 1 0 12 0v-3"/>
                                                                            <path d="M11 3v2"/>
                                                                            <path d="M6 3v2"/>
                                                                            <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="timeline-event-card">
                                                                        <div class="text-muted small">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                                                        <div class="font-weight-bold">{{ $appointment->service_type }}</div>
                                                                        @if($appointment->notes)
                                                                            <div class="text-muted mt-1">{{ $appointment->notes }}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="empty">
                                                            <div class="empty-icon text-muted">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-off" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M19.823 19.824a2 2 0 0 1-1.823 1.176h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 1.175-1.823m3.825-.177h9a2 2 0 0 1 2 2v9"/>
                                                                    <path d="M16 3v4"/>
                                                                    <path d="M8 3v1"/>
                                                                    <path d="M4 11h7m4 0h5"/>
                                                                    <path d="M3 3l18 18"/>
                                                                </svg>
                                                            </div>
                                                            <p class="empty-title">No appointments yet</p>
                                                            <p class="empty-subtitle text-muted">
                                                                Click the button above to schedule an appointment
                                                            </p>
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
    max-width: 1000px;
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
}

.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline-event {
    position: relative;
    padding-left: 2.5rem;
    padding-bottom: 1.5rem;
    border-left: 2px solid #e9ecef;
    margin-left: 1rem;
}

.timeline-event:last-child {
    padding-bottom: 0;
}

.timeline-event-icon {
    position: absolute;
    left: -1.25rem;
    top: 0;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: #206bc4;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
}

.timeline-event-card {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-left: 1rem;
}

.empty-icon {
    width: 5rem;
    height: 5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 50%;
    margin: 0 auto 1rem;
}

.card-title {
    display: flex;
    align-items: center;
    color: #1e293b;
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
