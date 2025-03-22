@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Edit Appointment
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('appointment.index') }}" class="btn btn-secondary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                        </svg>
                        Back to Appointments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('appointment.update', $appointment->id) }}" method="POST" class="card">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Owner and Pet Selection Row -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <!-- Pet Owner Selection -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <!-- Owner Avatar Display -->
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="{{ $appointment->user && $appointment->user->photo_data ? 'data:image/jpeg;base64,' . base64_encode($appointment->user->photo_data) : ($appointment->user && $appointment->user->photo ? asset('storage/' . $appointment->user->photo) : asset('storage/defaults/avatar.png')) }}" 
                                                             class="avatar avatar-lg" 
                                                             id="owner_avatar"
                                                             alt="Owner Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label required">Pet Owner</label>
                                                        <select name="user_id" id="user_id" class="form-select" required>
                                                            <option value="">Select Pet Owner</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" {{ $appointment->user_id == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pet Selection -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <!-- Pet Avatar Display -->
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="{{ $appointment->pet && $appointment->pet->photo_data ? 'data:image/jpeg;base64,' . base64_encode($appointment->pet->photo_data) : ($appointment->pet && $appointment->pet->photo ? asset('storage/' . $appointment->pet->photo) : asset('storage/defaults/paw.png')) }}" 
                                                             class="avatar avatar-lg" 
                                                             id="pet_avatar"
                                                             alt="Pet Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label for="pet_id" class="form-label required">Select Pet</label>
                                                        <select name="pet_id" id="pet_id" class="form-select" required>
                                                            <option value="">Choose a pet</option>
                                                            @if($appointment->pet_id)
                                                                <option value="{{ $appointment->pet_id }}" selected>
                                                                    {{ $appointment->pet_name }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pet Details Row -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pet Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog-bowl" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 15l5.586 -5.585a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-3.587 3.586"></path>
                                                        <path d="M12 13l-3.586 -3.585a2 2 0 1 0 -3.414 -1.415a2 2 0 1 0 1.413 3.414l3.587 3.586"></path>
                                                        <path d="M3 20h18c-.175 -1.423 -.963 -2.674 -2 -3.5"></path>
                                                        <path d="M16 18.5c-1.175 .847 -2.608 1.5 -4 1.5h-4c-1.392 0 -2.825 -.653 -4 -1.5"></path>
                                                    </svg>
                                                    Pet Name
                                                </label>
                                                <input type="text" id="pet_name" class="form-control" value="{{ $appointment->pet_name }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v6h-6z"></path>
                                                        <path d="M14 4h6v6h-6z"></path>
                                                        <path d="M4 14h6v6h-6z"></path>
                                                        <path d="M14 14h6v6h-6z"></path>
                                                    </svg>
                                                    Pet Type
                                                </label>
                                                <input type="text" id="pet_type" class="form-control" value="{{ $appointment->pet_type }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M14.7 13.5c-1.1 -2 -1.441 -5.5 -1.7 -7.5c-.259 -1.909 -1.437 -3.4 -3 -3c-1.954 .5 -3 2.827 -3 3.75c0 .9 1.052 2.75 2 3.75c1.385 1.455 1.7 5.5 1.7 5.5s1.374 -1.084 3 -.5c1.916 .686 3 1.75 3 1.75s.078 -2.5 1.7 -5.5c.433 -.804 2 -2.75 2 -3.75c0 -1 -1 -3.25 -3 -3.75c-1.587 -.4 -2.259 1.4 -3 3c-.741 1.6 -1.7 5.5 -1.7 7.5"></path>
                                                    </svg>
                                                    Pet Breed
                                                </label>
                                                <input type="text" id="pet_breed" class="form-control" value="{{ $appointment->pet_breed }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <circle cx="12" cy="12" r="9"></circle>
                                                        <polyline points="12 7 12 12 15 15"></polyline>
                                                    </svg>
                                                    Pet Age
                                                </label>
                                                <input type="text" id="pet_age" name="pet_age" class="form-control" value="{{ $appointment->pet_age }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scale" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 20l10 0"></path>
                                                        <path d="M6 6l6 -1l6 1"></path>
                                                        <path d="M12 3l0 17"></path>
                                                        <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                        <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                    </svg>
                                                    Pet Weight
                                                </label>
                                                <input type="text" id="pet_weight" name="pet_weight" class="form-control" value="{{ $appointment->pet_weight }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-bigender" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M19 3l-5 5"></path>
                                                        <path d="M15 3h4v4"></path>
                                                        <path d="M11 16v6"></path>
                                                        <path d="M8 19h6"></path>
                                                    </svg>
                                                    Gender
                                                </label>
                                                <input type="text" id="pet_gender" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Date/Time Row -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Appointment Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="appointment_date" class="form-label required">Date</label>
                                                <input type="date" name="appointment_date" id="appointment_date" 
                                                       class="form-control" value="{{ $appointment->appointment_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="appointment_time" class="form-label required">Time</label>
                                                <select name="appointment_time" id="appointment_time" class="form-select" required>
                                                    <option value="">Select Time</option>
                                                    <optgroup label="Morning">
                                                        @foreach(['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM'] as $time)
                                                            <option value="{{ $time }}" {{ $appointment->appointment_time == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="Afternoon">
                                                        @foreach(['01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM'] as $time)
                                                            <option value="{{ $time }}" {{ $appointment->appointment_time == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reasons for Visit -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Reason for Visit</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label required">Select Reasons</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $selectedReasons = $appointment->reason_for_visit;
                                                @endphp
                                                <button type="button" class="btn {{ in_array('Vaccination', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary' }} reason-btn" data-reason="Vaccination">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M17 3l4 4"></path>
                                                        <path d="M19 5l-4.5 4.5"></path>
                                                        <path d="M11.5 6.5l6 6"></path>
                                                        <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                                        <path d="M7.5 12.5l1.5 1.5"></path>
                                                        <path d="M10.5 9.5l1.5 1.5"></path>
                                                        <path d="M3 21l3 -3"></path>
                                                    </svg>
                                                    Vaccination
                                                </button>
                                                <button type="button" class="btn {{ in_array('Check-up', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary' }} reason-btn" data-reason="Check-up">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"></path>
                                                        <path d="M8 15a6 6 0 1 0 12 0v-3"></path>
                                                        <path d="M11 3v2"></path>
                                                        <path d="M6 3v2"></path>
                                                        <circle cx="20" cy="10" r="2"></circle>
                                                    </svg>
                                                    Check-up
                                                </button>
                                                <button type="button" class="btn {{ in_array('Grooming', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary' }} reason-btn" data-reason="Grooming">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cut" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <circle cx="6" cy="7" r="3"></circle>
                                                        <circle cx="6" cy="17" r="3"></circle>
                                                        <line x1="8.7" y1="8.7" x2="19" y2="19"></line>
                                                        <line x1="8.7" y1="15.3" x2="19" y2="5"></line>
                                                    </svg>
                                                    Grooming
                                                </button>
                                                <button type="button" class="btn {{ in_array('Surgery', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary' }} reason-btn" data-reason="Surgery">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scalpel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M19 5l-12.5 12.5a4.95 4.95 0 0 1 -7 -7l12.5 -12.5a1 1 0 0 1 1.414 0l5.586 5.586a1 1 0 0 1 0 1.414z"></path>
                                                        <path d="M18 6l-11.5 11.5"></path>
                                                    </svg>
                                                    Surgery
                                                </button>
                                                <button type="button" class="btn {{ in_array('Laboratory', $selectedReasons) ? 'btn-primary' : 'btn-outline-primary' }} reason-btn" data-reason="Laboratory">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-test-pipe" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M20 8.04l-12.122 12.124a2.857 2.857 0 1 1 -4.041 -4.04l12.122 -12.124"></path>
                                                        <path d="M7 13h8"></path>
                                                        <path d="M19 15l1.5 1.6a2 2 0 1 1 -3 0l1.5 -1.6z"></path>
                                                        <path d="M15 3l6 6"></path>
                                                    </svg>
                                                    Laboratory
                                                </button>
                                            </div>

                                            <input type="hidden" name="reason_for_visit" id="reason_for_visit" value="{{ json_encode($appointment->reason_for_visit) }}" required>

                                            <!-- Selected Reasons Display -->
                                            <div class="mt-3">
                                                <div id="selected-reasons" class="d-flex flex-wrap gap-2">
                                                    @foreach($selectedReasons as $reason)
                                                        <div class="badge bg-primary d-flex align-items-center gap-2 p-2" data-reason="{{ $reason }}">
                                                            {{ $reason }}
                                                            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="empty-reason-text" class="text-muted mt-2" style="{{ count($selectedReasons) > 0 ? 'display: none;' : '' }}">No reasons selected</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Vaccination Details Form (hidden by default) -->
                                        <div id="vaccination-details" class="mt-4" style="{{ in_array('Vaccination', $selectedReasons) ? 'display: block;' : 'display: none;' }}">
                                            <div class="card">
                                                <div class="card-header bg-light d-flex align-items-center">
                                                    <h3 class="card-title mb-0">Vaccination Details</h3>
                                                    <button type="button" class="ms-auto btn-close" aria-label="Close" data-bs-dismiss="card"></button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="vaccine_type" class="form-label required">Vaccine Type</label>
                                                            <select name="vaccine_type" id="vaccine_type" class="form-select">
                                                                <option value="">Select Vaccine</option>
                                                                <option value="Anti-rabies" {{ isset($appointment->vaccine_type) && $appointment->vaccine_type == 'Anti-rabies' ? 'selected' : '' }}>Anti-rabies</option>
                                                                <option value="DHPP" {{ isset($appointment->vaccine_type) && $appointment->vaccine_type == 'DHPP' ? 'selected' : '' }}>DHPP</option>
                                                                <option value="FVRCP" {{ isset($appointment->vaccine_type) && $appointment->vaccine_type == 'FVRCP' ? 'selected' : '' }}>FVRCP</option>
                                                                <option value="Deworming" {{ isset($appointment->vaccine_type) && $appointment->vaccine_type == 'Deworming' ? 'selected' : '' }}>Deworming</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="batch_number" class="form-label required">Batch Number</label>
                                                            <input type="text" id="batch_number" name="batch_number" class="form-control" value="{{ $appointment->batch_number ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="next_due_date" class="form-label required">Next Due Date</label>
                                                            <input type="date" id="next_due_date" name="next_due_date" class="form-control" value="{{ isset($appointment->next_due_date) ? $appointment->next_due_date->format('Y-m-d') : '' }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="administered_by" class="form-label required">Administered By</label>
                                                            <input type="text" id="administered_by" name="administered_by" class="form-control" value="{{ $appointment->administered_by ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="reactions" class="form-label">Reactions/Notes</label>
                                                        <textarea id="reactions" name="reactions" class="form-control" rows="3">{{ $appointment->reactions ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Vaccination History -->
                                        <div id="vaccination-history" class="mt-4" style="{{ in_array('Vaccination', $selectedReasons) ? 'display: block;' : 'display: none;' }}">
                                            <div class="card">
                                                <div class="card-header d-flex align-items-center">
                                                    <h3 class="card-title mb-0">Vaccination History</h3>
                                                    <div class="ms-auto">
                                                        <button type="button" class="btn btn-primary btn-sm">
                                                            View All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>DATE</th>
                                                                    <th>VACCINE TYPE</th>
                                                                    <th>BATCH NUMBER</th>
                                                                    <th>NEXT DUE DATE</th>
                                                                    <th>ADMINISTERED BY</th>
                                                                    <th>REACTIONS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(isset($vaccinationHistory) && count($vaccinationHistory) > 0)
                                                                    @foreach($vaccinationHistory as $history)
                                                                        <tr>
                                                                            <td>{{ $history->date->format('M d, Y') }}</td>
                                                                            <td>{{ $history->vaccine_type }}</td>
                                                                            <td>{{ $history->batch_number }}</td>
                                                                            <td>{{ $history->next_due_date ? $history->next_due_date->format('M d, Y') : 'N/A' }}</td>
                                                                            <td>{{ $history->administered_by }}</td>
                                                                            <td>{{ $history->reactions }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">
                                                                            <div class="py-4">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine text-muted mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                    <path d="M17 3l4 4"></path>
                                                                                    <path d="M19 5l-4.5 4.5"></path>
                                                                                    <path d="M11.5 6.5l6 6"></path>
                                                                                    <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                                                                    <path d="M7.5 12.5l1.5 1.5"></path>
                                                                                    <path d="M10.5 9.5l1.5 1.5"></path>
                                                                                    <path d="M3 21l3 -3"></path>
                                                                                </svg>
                                                                                <p class="text-muted">No records found</p>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Notes -->
                                        <div class="mt-4">
                                            <label for="notes" class="form-label">Additional Notes</label>
                                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Any additional information about the visit...">{{ $appointment->notes ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6"></path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M15 19l2 2l4 -4"></path>
                                </svg>
                                Update Appointment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('user_id');
    const petSelect = document.getElementById('pet_id');
    const selectedReasons = new Set();
    const reasonButtons = document.querySelectorAll('.reason-btn');
    const otherReasonBtn = document.getElementById('other-reason-btn');
    const otherReasonGroup = document.getElementById('other_reason_group');
    const otherReasonInput = document.getElementById('other_reason');
    const addOtherReasonBtn = document.getElementById('add-other-reason');
    const selectedReasonsContainer = document.getElementById('selected-reasons');
    const reasonForVisitInput = document.getElementById('reason_for_visit');
    const emptyReasonText = document.getElementById('empty-reason-text');

    // Default avatar paths
    const defaultAvatarPath = "{{ asset('storage/defaults/avatar.png') }}";
    const defaultPawPath = "{{ asset('storage/defaults/paw.png') }}";

    // Function to clear pet details
    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_type').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
        document.getElementById('pet_gender').value = '';
        document.getElementById('pet_avatar').src = defaultPawPath;
    }

    // Function to update pet details
    function updatePetDetails(pet) {
        document.getElementById('pet_name').value = pet.name || '';
        document.getElementById('pet_type').value = pet.category || '';
        document.getElementById('pet_breed').value = pet.breed || '';
        document.getElementById('pet_age').value = pet.age || '';
        document.getElementById('pet_weight').value = pet.weight || '';
        document.getElementById('pet_gender').value = pet.gender || '';
        
        // Update pet avatar if available
        if (pet.photo_data) {
            document.getElementById('pet_avatar').src = `data:image/jpeg;base64,${pet.photo_data}`;
        } else if (pet.photo) {
            document.getElementById('pet_avatar').src = `{{ asset('storage/') }}/${pet.photo}`;
        } else {
            document.getElementById('pet_avatar').src = defaultPawPath;
        }
    }

    // Handle Pet Owner Selection
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();
        
        // Update owner avatar if available
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.photo) {
            document.getElementById('owner_avatar').src = `{{ asset('storage/') }}/${selectedOption.dataset.photo}`;
        } else {
            document.getElementById('owner_avatar').src = defaultAvatarPath;
        }
        
        if (!userId) {
            petSelect.innerHTML = '<option value="">Choose a pet</option>';
            return;
        }

        // Check if the selected user matches the appointment's user
        if (userId == {{ $appointment->user_id }}) {
            // Set the initial pet details
            const initialPet = {
                id: {{ $appointment->pet_id }},
                name: '{{ $appointment->pet_name }}',
                category: '{{ $appointment->pet_type }}',
                breed: '{{ $appointment->pet_breed }}',
                age: '{{ $appointment->pet_age }}',
                weight: '{{ $appointment->pet_weight }}',
                gender: '{{ $appointment->pet_gender ?? "" }}'
            };
            updatePetDetails(initialPet);
            petSelect.innerHTML = '<option value="{{ $appointment->pet_id }}" selected>{{ $appointment->pet_name }}</option>';
        } else {
            // Fetch pets for the selected user
            fetch(`/api/users/${userId}/pets`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    petSelect.innerHTML = '<option value="">Choose a pet</option>';
                    
                    if (Array.isArray(data.pets) && data.pets.length > 0) {
                        data.pets.forEach(pet => {
                            const option = document.createElement('option');
                            option.value = pet.id;
                            option.text = pet.name;
                            option.dataset.pet = JSON.stringify(pet);
                            petSelect.appendChild(option);
                        });
                    } else {
                        petSelect.innerHTML = '<option value="">No pets found</option>';
                        clearPetDetails();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    petSelect.innerHTML = '<option value="">Error loading pets</option>';
                    clearPetDetails();
                });
        }
    });

    // Handle Pet Selection
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!this.value) {
            clearPetDetails();
            return;
        }
        
        if (selectedOption.dataset.pet) {
            const pet = JSON.parse(selectedOption.dataset.pet);
            updatePetDetails(pet);
        }
    });

    // Function to create a reason badge
    function createReasonBadge(reason) {
        const badge = document.createElement('div');
        badge.className = 'badge bg-primary d-flex align-items-center gap-2 p-2';
        badge.dataset.reason = reason;
        badge.innerHTML = `
            ${reason}
            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
        `;
        
        // Add remove handler
        const closeBtn = badge.querySelector('.btn-close');
        closeBtn.addEventListener('click', function() {
            selectedReasons.delete(reason);
            badge.remove();
            updateReasonInput();
            
            // Toggle button state
            const reasonBtn = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
            if (reasonBtn) {
                reasonBtn.classList.remove('btn-primary');
                reasonBtn.classList.add('btn-outline-primary');
            }
            
            // Show empty text if no reasons selected
            if (selectedReasons.size === 0) {
                emptyReasonText.style.display = 'block';
            }
        });
        
        return badge;
    }

    // Function to update the hidden input with selected reasons
    function updateReasonInput() {
        reasonForVisitInput.value = JSON.stringify(Array.from(selectedReasons));
        
        // Update visibility of empty reason text
        emptyReasonText.style.display = selectedReasons.size === 0 ? 'block' : 'none';
        
        // Update service-specific details
        updateServiceDetails();
    }

    // Initialize existing reasons
    let initialReasons = @json($appointment->reason_for_visit);
    initialReasons.forEach(reason => {
        if (reason && reason.trim()) {
            const trimmedReason = reason.trim();
            selectedReasons.add(trimmedReason);
        }
    });
    updateReasonInput();

    // Handle reason button clicks
    reasonButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reason = this.dataset.reason;
            
            if (selectedReasons.has(reason)) {
                selectedReasons.delete(reason);
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline-primary');
                
                const badge = selectedReasonsContainer.querySelector(`[data-reason="${reason}"]`);
                if (badge) badge.remove();
            } else {
                selectedReasons.add(reason);
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                
                const badge = createReasonBadge(reason);
                selectedReasonsContainer.appendChild(badge);
            }
            
            updateReasonInput();
        });
    });

    // Handle "Other" reason
    otherReasonBtn.addEventListener('click', function() {
        otherReasonGroup.style.display = otherReasonGroup.style.display === 'none' ? 'block' : 'none';
    });

    // Handle adding custom reason
    addOtherReasonBtn.addEventListener('click', function() {
        const customReason = otherReasonInput.value.trim();
        if (customReason) {
            if (!selectedReasons.has(customReason)) {
                selectedReasons.add(customReason);
                const badge = createReasonBadge(customReason);
                selectedReasonsContainer.appendChild(badge);
                updateReasonInput();
            }
            otherReasonInput.value = '';
            otherReasonGroup.style.display = 'none';
        }
    });

    // Allow Enter key to add custom reason
    otherReasonInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addOtherReasonBtn.click();
        }
    });

    // Initialize pet details and selected user
    userSelect.value = {{ $appointment->user_id }};
    userSelect.dispatchEvent(new Event('change'));

    // Service-specific details toggle
    function updateServiceDetails() {
        // Hide all service details first
        document.getElementById('vaccination-details').style.display = 'none';
        document.getElementById('vaccination-history').style.display = 'none';
        
        // Show relevant service details based on selected reasons
        if(selectedReasons.has('Vaccination')) {
            document.getElementById('vaccination-details').style.display = 'block';
            document.getElementById('vaccination-history').style.display = 'block';
            
            // Make vaccination fields required
            document.getElementById('vaccine_type').setAttribute('required', '');
            document.getElementById('batch_number').setAttribute('required', '');
            document.getElementById('next_due_date').setAttribute('required', '');
            document.getElementById('administered_by').setAttribute('required', '');
        } else {
            // Remove required attribute when vaccination is not selected
            document.getElementById('vaccine_type').removeAttribute('required');
            document.getElementById('batch_number').removeAttribute('required');
            document.getElementById('next_due_date').removeAttribute('required');
            document.getElementById('administered_by').removeAttribute('required');
        }
        
        // Add other service-specific toggles here as needed
    }
    
    // Call updateServiceDetails on page load
    updateServiceDetails();
    
    // Close button for service detail cards
    document.querySelectorAll('[data-bs-dismiss="card"]').forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.card');
            if (card) {
                card.parentElement.style.display = 'none';
                
                // Find which service this relates to and deselect it
                if (card.closest('#vaccination-details')) {
                    const vaccinationBtn = document.querySelector('.reason-btn[data-reason="Vaccination"]');
                    if (vaccinationBtn) vaccinationBtn.click();
                }
                // Add similar logic for other service types
            }
        });
    });
});
</script>
@endpush
