@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Schedule New Appointment
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
                <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Appointment Details</h3>
                    </div>
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
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="/img/default-avatar.png" 
                                                             class="avatar avatar-lg" 
                                                             id="owner_avatar"
                                                             alt="Owner Avatar"
                                                             style="width: 64px; height: 64px;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label required">Pet Owner</label>
                                                        <select name="owner_id" id="owner_id" class="form-select" {{ isset($owner) ? 'disabled' : '' }}>
                                                            <option value="">Select Owner</option>
                                                            <option value="no_account">No Account (Walk-in)</option>
                                                            @foreach($owners as $ownerOption)
                                                                <option value="{{ $ownerOption->id }}" 
                                                                    data-avatar="{{ $ownerOption->avatar_url ?? '/img/default-avatar.png' }}"
                                                                    {{ (old('owner_id') == $ownerOption->id || (isset($owner) && $owner->id == $ownerOption->id)) ? 'selected' : '' }}>
                                                                    {{ $ownerOption->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('owner_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic Second Column (Pet Selection OR Owner Name) -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="/img/default-pet.png" 
                                                             class="avatar avatar-lg" 
                                                             id="dynamic_avatar"
                                                             alt="Avatar"
                                                             style="width: 64px; height: 64px;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <!-- Pet Selection (for registered users) -->
                                                        <div id="pet_select_container">
                                                            <label class="form-label required">Select Pet</label>
                                                            <select name="pet_id" id="pet_id" class="form-select" {{ isset($pet) ? 'disabled' : '' }}>
                                                                <option value="">Select Pet</option>
                                                                @if(isset($ownerPets))
                                                                    @foreach($ownerPets as $petOption)
                                                                        <option value="{{ $petOption->id }}" 
                                                                            data-photo="{{ $petOption->photo_url ?? '/img/default-pet.png' }}"
                                                                            {{ (old('pet_id') == $petOption->id || (isset($pet) && $pet->id == $petOption->id)) ? 'selected' : '' }}
                                                                            data-name="{{ $petOption->name }}"
                                                                            data-category="{{ $petOption->category }}"
                                                                            data-breed="{{ $petOption->breed }}"
                                                                            data-age="{{ $petOption->age }}"
                                                                            data-weight="{{ $petOption->weight }}"
                                                                            data-gender="{{ strtolower($petOption->gender) }}">
                                                                            {{ $petOption->name }} ({{ $petOption->category }})
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('pet_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Owner Name Input (for walk-ins) -->
                                                        <div id="owner_name_container" style="display: none;">
                                                            <label class="form-label required">Owner Name</label>
                                                            <input type="text" id="owner_name" name="owner_name" 
                                                                   class="form-control @error('owner_name') is-invalid @enderror" 
                                                                   value="{{ old('owner_name') }}">
                                                            @error('owner_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Walk-in Pet Details -->
                            <div id="walkin_pet_group" class="col-12" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label required">Pet Name</label>
                                                <input type="text" id="walkin_pet_name" name="walkin_pet_name" class="form-control @error('walkin_pet_name') is-invalid @enderror">
                                                @error('walkin_pet_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label required">Pet Type</label>
                                                <select id="walkin_pet_type" name="walkin_pet_type" class="form-select @error('walkin_pet_type') is-invalid @enderror">
                                                    <option value="">Select Pet Type</option>
                                                    <option value="Canine">Canine</option>
                                                    <option value="Feline">Feline</option>
                                                    <option value="Avian">Avian</option>
                                                    <option value="Lapine">Lapine</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @error('walkin_pet_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label required">Gender</label>
                                                <select id="walkin_pet_gender" name="walkin_pet_gender" class="form-select @error('walkin_pet_gender') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                                @error('walkin_pet_gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">Pet Age</label>
                                                <div class="input-group">
                                                    <input type="number" id="walkin_pet_age" name="walkin_pet_age" class="form-control @error('walkin_pet_age') is-invalid @enderror" min="0">
                                                    <select id="walkin_age_unit" name="walkin_age_unit" class="form-select" style="max-width: 100px;">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                                @error('walkin_pet_age')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">Weight (kg)</label>
                                                <input type="number" id="walkin_pet_weight" name="walkin_pet_weight" class="form-control @error('walkin_pet_weight') is-invalid @enderror" step="0.01" min="0">
                                                @error('walkin_pet_weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registered Pet Details Card -->
                            <div id="registered_pet_details" class="col-12" style="min-height: 300px; margin-bottom: 1.5rem;">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Pet Name</label>
                                                <input type="text" id="pet_name" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Category</label>
                                                <input type="text" id="pet_category" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Breed</label>
                                                <input type="text" id="pet_breed" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Pet Age</label>
                                                <div class="input-group">
                                                    <input type="number" id="pet_age" class="form-control" readonly>
                                                    <select id="age_unit" class="form-select" style="max-width: 100px;" disabled>
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Weight (kg)</label>
                                                <input type="number" id="pet_weight" class="form-control" step="0.01" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Gender</label>
                                                <input type="text" id="pet_gender" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Date/Time Row -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Date</label>
                                        <input type="date" id="appointment_date" name="appointment_date" 
                                               class="form-control @error('appointment_date') is-invalid @enderror" 
                                               required value="{{ old('appointment_date') }}">
                                        @error('appointment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label required">Time</label>
                                        <select id="appointment_time" name="appointment_time" 
                                                class="form-select @error('appointment_time') is-invalid @enderror" 
                                                required>
                                            <option value="">Select Time</option>
                                            <optgroup label="Morning">
                                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30'] as $time)
                                                    <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Afternoon">
                                                @foreach(['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'] as $time)
                                                    <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        @error('appointment_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Reason for Visit</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @foreach([
                                        'Vaccination' => [
                                            'icon' => 'vaccine',
                                            'sub' => ['Anti-rabies', 'DHPP', 'FVRCP', 'Deworming']
                                        ],
                                        'Check-up' => [
                                            'icon' => 'stethoscope',
                                            'sub' => ['Routine', 'Follow-up', 'Emergency']
                                        ],
                                        'Grooming' => [
                                            'icon' => 'cut',
                                            'sub' => ['Full Service', 'Nail Trim', 'Dental']
                                        ],
                                        'Surgery' => [
                                            'icon' => 'scalpel',
                                            'sub' => ['Spay/Neuter', 'Minor', 'Major']
                                        ],
                                        'Laboratory' => [
                                            'icon' => 'test-pipe',
                                            'sub' => ['Blood Test', 'Urinalysis', 'X-ray']
                                        ]
                                    ] as $category => $details)
                                        <button type="button" 
                                            class="btn reason-btn" 
                                            data-reason="{{ $category }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-{{ $details['icon'] }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                @if($details['icon'] === 'vaccine')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M17 3l4 4"></path>
                                                    <path d="M19 5l-4.5 4.5"></path>
                                                    <path d="M11.5 6.5l6 6"></path>
                                                    <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                                    <path d="M7.5 12.5l1.5 1.5"></path>
                                                    <path d="M10.5 9.5l1.5 1.5"></path>
                                                    <path d="M3 21l3 -3"></path>
                                                @elseif($details['icon'] === 'stethoscope')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"></path>
                                                    <path d="M8 15a6 6 0 1 0 12 0v-3"></path>
                                                    <path d="M11 3v2"></path>
                                                    <path d="M6 3v2"></path>
                                                    <circle cx="20" cy="10" r="2"></circle>
                                                @elseif($details['icon'] === 'cut')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <circle cx="6" cy="7" r="3"></circle>
                                                    <circle cx="6" cy="17" r="3"></circle>
                                                    <line x1="8.7" y1="8.7" x2="19" y2="19"></line>
                                                    <line x1="8.7" y1="15.3" x2="19" y2="5"></line>
                                                @elseif($details['icon'] === 'scalpel')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M19 5l-12.5 12.5a4.95 4.95 0 0 1 -7 -7l12.5 -12.5a1 1 0 0 1 1.414 0l5.586 5.586a1 1 0 0 1 0 1.414z"></path>
                                                    <path d="M18 6l-11.5 11.5"></path>
                                                @elseif($details['icon'] === 'test-pipe')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 8.04l-12.122 12.124a2.857 2.857 0 1 1 -4.041 -4.04l12.122 -12.124"></path>
                                                    <path d="M7 13h8"></path>
                                                    <path d="M19 15l1.5 1.6a2 2 0 1 1 -3 0l1.5 -1.6z"></path>
                                                    <path d="M15 3l6 6"></path>
                                                @endif
                                            </svg>
                                            {{ $category }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Add the checkup history table here -->
                                <div id="checkup-history-table" class="mt-4" style="display: none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="card-title">Check-up History</h3>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Previous Checkup Date</th>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <span>Category</span>
                                                                    <select class="form-select form-select-sm" style="width: auto;" id="checkupTypeSelect">
                                                                        <option value="Hematology">Hematology</option>
                                                                        <option value="Microbiology">Microbiology</option>
                                                                        <option value="Microscopy">Microscopy</option>
                                                                        <option value="Blood Chemistry">Blood Chemistry</option>
                                                                        <option value="Ultrasound">Ultrasound</option>
                                                                        <option value="Immunology">Immunology</option>
                                                                        <option value="Culture & Sensitivity">Culture & Sensitivity</option>
                                                                        <option value="Radiology">Radiology</option>
                                                                        <option value="Parasitology">Parasitology</option>
                                                                        <option value="Virology">Virology</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th>Existing Symptoms</th>
                                                            <th>Current Medication & Dosage</th>
                                                            <th>New Meds & Dosage</th>
                                                            <th>Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="checkupHistoryBody">
                                                        <tr class="text-center no-data-row">
                                                            <td colspan="6">
                                                                <div class="empty">
                                                                    <div class="empty-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                            <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="empty-title">No check-up history found</p>
                                                                    <p class="empty-subtitle text-muted">
                                                                        This pet has no previous check-up records.
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="selected-reasons-box">
                                    <div id="selected-reasons" class="d-flex flex-wrap gap-2"></div>
                                    <div id="empty-reason-text" class="text-muted">No reasons selected</div>
                                </div>
                                <input type="hidden" name="reason_for_visit" id="reason_for_visit" value="{{ old('reason_for_visit') }}" required>
                                @error('reason_for_visit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Medical History Modal -->
                            <div class="modal modal-blur fade" id="medical-history-section" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="fas fa-stethoscope me-2"></i>Medical Record</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Patient Information Card -->
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">Patient Information</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Owner Information</label>
                                                            <div id="owner-details" class="form-control-plaintext"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Pet Information</label>
                                                            <div id="pet-details" class="form-control-plaintext"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Medical History Table -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Medical History</h3>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Service</th>
                                                                    <th>Diagnosis</th>
                                                                    <th>Treatment</th>
                                                                    <th>Notes</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="medicalHistoryBody">
                                                                <tr class="text-center no-data-row">
                                                                    <td colspan="5">
                                                                        <div class="empty">
                                                                            <div class="empty-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                    <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                                                                </svg>
                                                                            </div>
                                                                            <p class="empty-title">No medical history found</p>
                                                                            <p class="empty-subtitle text-muted">
                                                                                This pet has no previous medical records.
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Additional Notes</label>
                                <textarea name="notes" class="form-control" rows="3" 
                                      placeholder="Any additional information about the visit...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Add the modal content here -->
                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h3 class="card-title mb-0"><i class="fas fa-stethoscope me-2"></i>Medical Record</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Patient Information Card -->
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h3 class="card-title">Patient Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Owner Information</label>
                                                        <div id="owner-details" class="form-control-plaintext"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Pet Information</label>
                                                        <div id="pet-details" class="form-control-plaintext"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Section Navigation -->
                                        <div class="btn-group w-100 mb-3">
                                            <button type="button" class="btn btn-outline-primary active" onclick="showSection('vital-signs')">
                                                <i class="fas fa-heartbeat me-2"></i>Vital Signs
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="showSection('diagnosis')">
                                                <i class="fas fa-stethoscope me-2"></i>Diagnosis
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="showSection('billing')">
                                                <i class="fas fa-file-invoice-dollar me-2"></i>Billing
                                            </button>
                                        </div>

                                        <!-- Form Sections -->
                                        <div class="form-sections border rounded p-3">
                                            <!-- Vital Signs Section -->
                                            <div id="vital-signs-section" class="form-section">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Vital Signs</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Temperature (°C)</label>
                                                                <input type="number" class="form-control" name="temperature" step="0.1">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Weight (kg)</label>
                                                                <input type="number" class="form-control" name="weight" step="0.01">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Heart Rate (bpm)</label>
                                                                <input type="number" class="form-control" name="heart_rate">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Respiratory Rate (/min)</label>
                                                                <input type="number" class="form-control" name="respiratory_rate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Diagnosis Section -->
                                            <div id="diagnosis-section" class="form-section" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Diagnosis Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="diagnosis-group">
                                                            <div class="mb-3">
                                                                <label class="form-label required">Existing Symptoms</label>
                                                                <textarea class="form-control" name="existing_symptoms" rows="2" required></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Examination Findings</label>
                                                                <textarea class="form-control" name="examination_findings" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="diagnosis-group">
                                                            <div class="mb-3">
                                                                <label class="form-label required">Diagnosis/Results</label>
                                                                <textarea class="form-control" name="results" rows="2" required></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Treatment Plan</label>
                                                                <textarea class="form-control" name="treatment_notes" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-md-4">
                                                                <label class="form-label">Follow-up Date</label>
                                                                <input type="date" class="form-control" name="followup_date">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Follow-up Type</label>
                                                                <select class="form-select" name="followup_type">
                                                                    <option value="">Select type</option>
                                                                    <option value="checkup">Check-up</option>
                                                                    <option value="vaccination">Vaccination</option>
                                                                    <option value="treatment">Treatment</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Billing Section -->
                                            <div id="billing-section" class="form-section" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Billing Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Services -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Services</label>
                                                            <select class="form-select mb-2" name="service">
                                                                <option value="">Select Service</option>
                                                                <option value="consultation">Consultation</option>
                                                                <option value="vaccination">Vaccination</option>
                                                                <option value="treatment">Treatment</option>
                                                            </select>
                                                            <div class="input-group mb-2">
                                                                <span class="input-group-text">₱</span>
                                                                <input type="number" class="form-control" name="service_amount" step="0.01">
                                                            </div>
                                                        </div>

                                                        <!-- Medications -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Medications</label>
                                                            <input type="text" class="form-control mb-2" name="medication" placeholder="Medication name">
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <div class="input-group">
                                                                        <input type="number" class="form-control" name="quantity" placeholder="Qty">
                                                                        <span class="input-group-text">units</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">₱</span>
                                                                        <input type="number" class="form-control" name="medication_amount" step="0.01">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Summary -->
                                                        <div class="card bg-light mt-4">
                                                            <div class="card-body">
                                                                <div class="row g-2">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <span>Subtotal:</span>
                                                                            <span id="subtotal" class="fw-bold">₱0.00</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <span>Discount:</span>
                                                                            <div class="input-group" style="width: 150px">
                                                                                <input type="number" class="form-control" id="discountAmount" min="0" step="0.01" onchange="updateTotals()">
                                                                                <select class="form-select" id="discountType" style="width: 60px" onchange="updateTotals()">
                                                                                    <option value="percent">%</option>
                                                                                    <option value="fixed">₱</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <span class="fw-bold">Total Amount:</span>
                                                                            <span id="total" class="fw-bold text-primary">₱0.00</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <hr class="my-2">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Payment Method</label>
                                                                        <select class="form-select" name="payment_method" id="paymentMethod">
                                                                            <option value="cash">Cash</option>
                                                                            <option value="card">Card</option>
                                                                            <option value="gcash">GCash</option>
                                                                            <option value="maya">Maya</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Payment Status</label>
                                                                        <select class="form-select" name="payment_status" id="paymentStatus" onchange="toggleAmountPaid()">
                                                                            <option value="paid">Fully Paid</option>
                                                                            <option value="partial">Partial Payment</option>
                                                                            <option value="pending">Pending Payment</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12" id="amountPaidSection">
                                                                        <label class="form-label">Amount Tendered</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">₱</span>
                                                                            <input type="number" class="form-control" name="amount_paid" id="amountPaid" step="0.01" onchange="calculateChange()">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12" id="changeSection">
                                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                                            <span>Change:</span>
                                                                            <span id="changeAmount" class="fw-bold text-success">₱0.00</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12" id="remainingSection" style="display: none;">
                                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                                            <span>Remaining Balance:</span>
                                                                            <span id="remainingAmount" class="fw-bold text-danger">₱0.00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('appointment.index') }}" class="btn btn-outline-secondary me-1">Cancel</a>
                        <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this JavaScript function right after the section navigation buttons -->
<script>
function showSection(sectionName) {
    // Hide all sections first
    document.querySelectorAll('.form-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show the selected section
    document.getElementById(sectionName + '-section').style.display = 'block';
    
    // Add active class to the clicked button
    document.querySelector(`button[onclick="showSection('${sectionName}')"]`).classList.add('active');
}
</script>

@endsection

@push('page-scripts')
<script>
// Move these functions outside the DOMContentLoaded event listener
function toggleMedicalHistory() {
    const modal = new bootstrap.Modal(document.getElementById('medical-history-section'));
    const petId = document.getElementById('pet_id').value;
    const petSelect = document.getElementById('pet_id');
    const userSelect = document.getElementById('owner_id');
    
    if (!petId || userSelect.value === 'no_account') {
        Swal.fire({
            icon: 'warning',
            title: 'No Pet Selected',
            text: 'Please select a registered pet to view medical history.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // Update owner and pet details
    const selectedPet = petSelect.options[petSelect.selectedIndex];
    const petName = selectedPet.text;
    const petType = selectedPet.dataset.type;
    const ownerName = userSelect.options[userSelect.selectedIndex].text;
    
    // Update pet and owner details
    document.getElementById('owner-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${ownerName}</span>
            <span class="badge ${userSelect.value === 'no_account' ? 'bg-yellow-lt' : 'bg-azure-lt'} mt-1">
                <i class="${userSelect.value === 'no_account' ? 'fas fa-walking' : 'fas fa-user-check'} me-1"></i>
                ${userSelect.value === 'no_account' ? 'Walk-in' : 'Registered'}
            </span>
        </div>
    `;
    
    document.getElementById('pet-details').innerHTML = `
        <div class="d-flex flex-column">
            <span class="fw-bold">${petName}</span>
            <div class="mt-1">
                <span class="badge bg-blue-lt">${petType}</span>
            </div>
        </div>
    `;
    
    // Load medical history
    loadMedicalHistory(petId);
    
    modal.show();
}

function loadMedicalHistory(petId) {
    // Show loading state
    const tbody = document.getElementById('medicalHistoryBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    `;

    fetch(`/api/pets/${petId}/medical-history`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr class="text-center">
                        <td colspan="5">
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">No medical history found</p>
                                <p class="empty-subtitle text-muted">
                                    This pet has no previous medical records.
                                </p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = data.map(record => `
                <tr>
                    <td>${new Date(record.date).toLocaleDateString()}</td>
                    <td>${record.service || '-'}</td>
                    <td>${record.diagnosis || '-'}</td>
                    <td>${record.treatment || '-'}</td>
                    <td>${record.notes || '-'}</td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading medical history:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Failed to load medical history. Please try again.
                    </td>
                </tr>`;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');
    const selectedReasons = new Set();
    const reasonButtons = document.querySelectorAll('.reason-btn');
    const otherReasonBtn = document.getElementById('other-reason-btn');
    const otherReasonGroup = document.getElementById('other_reason_group');
    const otherReasonInput = document.getElementById('other_reason');
    const addOtherReasonBtn = document.getElementById('add-other-reason');
    const selectedReasonsContainer = document.getElementById('selected-reasons');
    const reasonForVisitInput = document.getElementById('reason_for_visit');
    const ownerNameGroup = document.getElementById('owner_name_group');
    const ownerNameInput = document.getElementById('owner_name');
    const petSelectionGroup = document.getElementById('pet_selection_group');
    const appointmentDate = document.getElementById('appointment_date');
    const appointmentTime = document.getElementById('appointment_time');
    const checkupTable = document.getElementById('checkup-history-table');
    const checkupTypeSelect = document.getElementById('checkupTypeSelect');
    const categoryHeader = document.getElementById('categoryHeader');

    // Check if there's an existing appointment and pre-select appropriate fields
    const existingUserId = '{{ old("owner_id", $appointment->owner_id ?? "") }}';
    const existingOwnerName = '{{ old("owner_name", $appointment->owner_name ?? "") }}';

    if (existingOwnerName && !existingUserId) {
        userSelect.value = 'no_account';
        ownerNameGroup.style.display = 'block';
        petSelectionGroup.style.display = 'none';
        ownerNameInput.value = existingOwnerName;
    } else if (existingUserId) {
        userSelect.value = existingUserId;
        // Trigger change event to load pets
        userSelect.dispatchEvent(new Event('change'));
    }

    // Function to clear pet details
    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_category').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
        document.getElementById('pet_gender').value = '';
    }

    // Handle Pet Owner Selection with Walk-in Support
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        const ownerNameGroup = document.getElementById('owner_name_group');
        const petSelectionGroup = document.getElementById('pet_selection_group');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        if (userId === 'no_account') {
            // Show walk-in fields
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'none';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            
            // Make walk-in fields required
            document.getElementById('owner_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            document.getElementById('walkin_pet_weight').setAttribute('required', 'required');
            document.getElementById('walkin_pet_gender').setAttribute('required', 'required');
            
            // Remove requirement from pet selection
            document.getElementById('pet_id').removeAttribute('required');
            
            // Clear any selected pet data
            clearPetDetails();
        } else {
            // Show registered user fields
            ownerNameGroup.style.display = 'none';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'none';
            registeredPetDetails.style.display = 'flex';
            
            // Make pet selection required
            document.getElementById('pet_id').setAttribute('required', 'required');
            
            // Remove requirements from walk-in fields
            document.getElementById('owner_name').removeAttribute('required');
            document.getElementById('walkin_pet_name').removeAttribute('required');
            document.getElementById('walkin_pet_type').removeAttribute('required');
            document.getElementById('walkin_pet_age').removeAttribute('required');
            document.getElementById('walkin_pet_weight').removeAttribute('required');
            document.getElementById('walkin_pet_gender').removeAttribute('required');
            
            // Load pets if a user is selected
            if (userId) {
                loadPetsForOwner(userId);
            } else {
                clearPetSelect();
            }
        }
    });

    // Add these helper functions
    function loadPetsForOwner(userId) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();

        fetch(`/api/users/${userId}/pets`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Raw pets data:', data); // Debug log
                updatePetSelect(data.pets);
            })
            .catch(error => {
                console.error('Error:', error);
                petSelect.innerHTML = '<option value="">Error loading pets</option>';
            });
    }

    // Find and update the updatePetSelect function
    function updatePetSelect(pets) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        
        if (Array.isArray(pets) && pets.length > 0) {
            console.log('Received pets data:', pets);
            
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.text = `${pet.name} (${pet.category})`;
                
                // Make sure to set all data attributes from the pet object
                option.dataset.name = pet.name || '';
                option.dataset.category = pet.category || '';
                option.dataset.type = pet.type || pet.category || ''; // Fallback to category if type is null
                option.dataset.breed = pet.breed || '';
                option.dataset.age = pet.age ? pet.age.toString() : '';
                option.dataset.weight = pet.weight ? pet.weight.toString() : '';
                // Capitalize first letter of gender
                option.dataset.gender = pet.gender ? 
                    pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : '';
                
                // Debug log for each option
                console.log('Setting data attributes for:', pet.name, option.dataset);
                
                petSelect.appendChild(option);
            });
        } else {
            petSelect.innerHTML = '<option value="">No pets found</option>';
        }
    }

    function clearPetSelect() {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        clearPetDetails();
    }

    // Update the pet selection event listener
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!this.value) {
            clearPetDetails();
            return;
        }
        
        // Debug log
        console.log('Selected pet option:', selectedOption);
        console.log('Selected pet dataset:', selectedOption.dataset);
        
        // Test endpoint call
        fetch(`/test/pet/${this.value}`)
            .then(response => response.json())
            .then(data => {
                console.log('Pet test data:', data);
                
                // Update fields with direct data
                document.getElementById('pet_name').value = data.pet.name || '';
                document.getElementById('pet_category').value = data.pet.category || '';
                document.getElementById('pet_breed').value = data.pet.breed || '';
                document.getElementById('pet_age').value = data.pet.age || '';
                document.getElementById('pet_weight').value = data.pet.weight || '';
                // Capitalize first letter of gender
                document.getElementById('pet_gender').value = data.pet.gender ? 
                    data.pet.gender.charAt(0).toUpperCase() + data.pet.gender.slice(1).toLowerCase() : '';
            })
            .catch(error => console.error('Error fetching pet test data:', error));
    });

    // Function to update the hidden input with selected reasons
    function updateReasonInput() {
        reasonForVisitInput.value = Array.from(selectedReasons).join(',');
    }

    // Function to create a reason badge
    function createReasonBadge(reason) {
        const badge = document.createElement('div');
        badge.className = 'badge d-flex align-items-center gap-2';
        badge.innerHTML = `
            ${reason}
            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
        `;

        badge.querySelector('.btn-close').addEventListener('click', function() {
            selectedReasons.delete(reason);
            badge.remove();
            
            // Update button state
            const button = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
            if (button) {
                button.classList.remove('active');
            }
            
            updateReasonInput();
        });

        return badge;
    }

    // Handle reason button clicks
    reasonButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const reason = this.dataset.reason;
            const checkupTable = document.getElementById('checkup-history-table');
            
            // Toggle active state for the clicked button
            this.classList.toggle('active');
            
            // Show/hide checkup history only for Check-up button
            if (reason === 'Check-up') {
                if (this.classList.contains('active')) {
                    checkupTable.style.display = 'block';
                    if (petSelect.value) {
                        loadCheckupHistory(petSelect.value, checkupTypeSelect.value);
                    }
                } else {
                    checkupTable.style.display = 'none';
                }
            }
            
            // Update selected reasons
            if (this.classList.contains('active')) {
                selectedReasons.add(reason);
            } else {
                selectedReasons.delete(reason);
            }
            
            // Update the hidden input
            updateReasonInput();
            
            // Update display of selected reasons
            updateSelectedReasonsDisplay();
        });
    });

    // Add this function to update the display of selected reasons
    function updateSelectedReasonsDisplay() {
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        const emptyReasonText = document.getElementById('empty-reason-text');
        
        selectedReasonsContainer.innerHTML = '';
        
        if (selectedReasons.size > 0) {
            emptyReasonText.style.display = 'none';
            selectedReasons.forEach(reason => {
                const badge = createReasonBadge(reason);
                selectedReasonsContainer.appendChild(badge);
            });
        } else {
            emptyReasonText.style.display = 'block';
        }
    }

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
                badge.dataset.reason = customReason;
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

    // Handle Walk-in Pet Age Unit Change
    const walkinPetAgeInput = document.getElementById('walkin_pet_age');
    const walkinAgeUnitSelect = document.getElementById('walkin_age_unit');
    
    walkinAgeUnitSelect.addEventListener('change', function() {
        if (this.value === 'years') {
            walkinPetAgeInput.setAttribute('max', '30');
        } else {
            walkinPetAgeInput.setAttribute('max', '360');
        }
    });

    // Form submission handling
    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields'
            });
            return;
        }

        // Show loading state
        Swal.fire({
            title: 'Scheduling Appointment',
            text: 'Please wait...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit the form directly
        this.submit();
    });

    // Set min date to today
    appointmentDate.min = new Date().toISOString().split('T')[0];

    // Function to check if a date is a weekend
    function isWeekend(date) {
        const day = date.getDay();
        return day === 0 || day === 6;
    }

    // Function to disable weekends
    function disableWeekends(e) {
        const selectedDate = new Date(this.value);
        if (isWeekend(selectedDate)) {
            this.value = '';
            // Optional: show a subtle message instead of an alert
            const dateField = this.parentElement;
            let message = dateField.querySelector('.weekend-message');
            if (!message) {
                message = document.createElement('small');
                message.className = 'text-danger weekend-message';
                message.style.display = 'block';
                message.style.marginTop = '0.25rem';
                message.textContent = 'Weekends are not available';
                dateField.appendChild(message);
                setTimeout(() => message.remove(), 3000); // Remove after 3 seconds
            }
        }
    }

    // Add event listeners
    appointmentDate.addEventListener('input', disableWeekends);
    appointmentDate.addEventListener('click', function(e) {
        // Prevent opening calendar if it's a weekend
        const date = new Date(this.value);
        if (this.value && isWeekend(date)) {
            e.preventDefault();
        }
    });

    // Time validation
    appointmentTime.addEventListener('change', function() {
        const selectedDate = appointmentDate.value;
        const selectedTime = this.value;
        
        if (selectedDate === new Date().toISOString().split('T')[0]) {
            const now = new Date();
            const selected = new Date(selectedDate + 'T' + selectedTime);
            
            if (selected <= now) {
                alert('Please select a future time');
                this.value = '';
            }
        }
    });

    // Reset time when date changes
    appointmentDate.addEventListener('change', function() {
        appointmentTime.value = '';
    });

    // Add this after setting min date
    appointmentDate.addEventListener('focus', async function() {
        try {
            const response = await fetch(`/api/appointments/dates`);
            if (!response.ok) throw new Error('Failed to fetch appointments');
            const data = await response.json();
            
            // Create a style element for the date highlights
            let style = document.getElementById('date-highlights');
            if (!style) {
                style = document.createElement('style');
                style.id = 'date-highlights';
                document.head.appendChild(style);
            }

            // Generate CSS rules for date highlighting
            let css = '';
            data.dates.forEach(date => {
                css += `
                    input[type="date"][value="${date}"],
                    input[type="date"]::-webkit-calendar-picker-indicator[value="${date}"] {
                        background-color: rgba(var(--primary-rgb), 0.1);
                    }
                `;
            });
            style.textContent = css;

            // Store booked dates for validation
            this.dataset.bookedDates = JSON.stringify(data.dates);
        } catch (error) {
            console.error('Error fetching appointment dates:', error);
        }
    });

    appointmentDate.addEventListener('change', function() {
        const selectedDate = this.value;
        const bookedDates = JSON.parse(this.dataset.bookedDates || '[]');
        
        if (bookedDates.includes(selectedDate)) {
            // Add a warning message instead of preventing selection
            const dateField = this.parentElement;
            let message = dateField.querySelector('.date-warning');
            if (!message) {
                message = document.createElement('small');
                message.className = 'text-warning date-warning';
                message.style.display = 'block';
                message.style.marginTop = '0.25rem';
                message.textContent = 'Note: This date already has appointments scheduled';
                dateField.appendChild(message);
                setTimeout(() => message.remove(), 5000); // Remove after 5 seconds
            }
        }
        
        // Reset time when date changes
        appointmentTime.value = '';
    });

    // Load history when checkup type changes
    checkupTypeSelect.addEventListener('change', function() {
        categoryHeader.textContent = this.value;
        if (petSelect.value) {
            loadCheckupHistory(petSelect.value, this.value);
        }
    });

    // Load history when pet changes
    petSelect.addEventListener('change', function() {
        if (this.value && isCheckupSelected()) {
            loadCheckupHistory(this.value, checkupTypeSelect.value);
        }
    });

    function isCheckupSelected() {
        const activeReasonBtn = document.querySelector('.reason-btn[data-reason="Check-up"].active');
        return activeReasonBtn !== null;
    }

    function loadCheckupHistory(petId, category) {
        console.log('Loading history for pet:', petId, 'category:', category);
        fetch(`/api/pet/${petId}/checkup-history/${category}`)
            .then(response => response.json())
            .then(data => {
                console.log('Received data:', data);
                const tbody = document.getElementById('checkupHistoryBody');
                if (data.length === 0) {
                    tbody.innerHTML = `
                        <tr class="text-center no-data-row">
                            <td colspan="6">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                        </svg>
                                    </div>
                                    <p class="empty-title">No ${category} records found</p>
                                    <p class="empty-subtitle text-muted">
                                        This pet has no previous ${category.toLowerCase()} check-up records.
                                    </p>
                                </div>
                            </td>
                        </tr>`;
                } else {
                    tbody.innerHTML = data.map(record => `
                        <tr>
                            <td>${record.checkup_date}</td>
                            <td>${record.results || '-'}</td>
                            <td>${record.existing_symptoms || '-'}</td>
                            <td>${record.current_medication || '-'}</td>
                            <td>${record.new_medication || '-'}</td>
                            <td>${record.notes || '-'}</td>
                        </tr>
                    `).join('');
                }
            })
            .catch(error => {
                console.error('Error loading checkup history:', error);
            });
    }

    // Get the button and modal elements
    const viewMedicalHistoryBtn = document.querySelector('[data-bs-target="#appointmentModal"]');
    const appointmentModal = document.getElementById('appointmentModal');

    // Add click event listener to the button
    viewMedicalHistoryBtn.addEventListener('click', function() {
        const petId = document.getElementById('pet_id').value;
        const userSelect = document.getElementById('owner_id');
        const petSelect = document.getElementById('pet_id');
        
        if (!petId || userSelect.value === 'no_account') {
            Swal.fire({
                icon: 'warning',
                title: 'No Pet Selected',
                text: 'Please select a registered pet to view medical history.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Update owner and pet details in the modal
        const selectedPet = petSelect.options[petSelect.selectedIndex];
        const petName = selectedPet.text;
        const petType = selectedPet.dataset.type;
        const ownerName = userSelect.options[userSelect.selectedIndex].text;
        
        // Update pet and owner details in the modal
        document.getElementById('owner-details').innerHTML = `
            <div class="d-flex flex-column">
                <span class="fw-bold">${ownerName}</span>
                <span class="badge ${userSelect.value === 'no_account' ? 'bg-yellow-lt' : 'bg-azure-lt'} mt-1">
                    <i class="${userSelect.value === 'no_account' ? 'fas fa-walking' : 'fas fa-user-check'} me-1"></i>
                    ${userSelect.value === 'no_account' ? 'Walk-in' : 'Registered'}
                </span>
            </div>
        `;
        
        document.getElementById('pet-details').innerHTML = `
            <div class="d-flex flex-column">
                <span class="fw-bold">${petName}</span>
                <div class="mt-1">
                    <span class="badge bg-blue-lt">${petType}</span>
                </div>
            </div>
        `;
        
        // Load medical history into the modal
        loadMedicalHistoryForModal(petId);
    });

    function loadMedicalHistoryForModal(petId) {
        // Show loading state
        const tbody = document.getElementById('medicalHistoryBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch(`/api/pets/${petId}/medical-history`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data || data.length === 0) {
                    tbody.innerHTML = `
                        <tr class="text-center">
                            <td colspan="5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">No medical history found</p>
                                <p class="empty-subtitle text-muted">
                                    This pet has no previous medical records.
                                </p>
                            </div>
                        </td>
                    </tr>`;
                    return;
                }

                tbody.innerHTML = data.map(record => `
                    <tr>
                        <td>${new Date(record.date).toLocaleDateString()}</td>
                        <td>${record.service || '-'}</td>
                        <td>${record.diagnosis || '-'}</td>
                        <td>${record.treatment || '-'}</td>
                        <td>${record.notes || '-'}</td>
                    </tr>
                `).join('');
            })
            .catch(error => {
                console.error('Error loading medical history:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Failed to load medical history. Please try again.
                        </td>
                    </tr>`;
            });
    }

    // Add this to trigger the pet details update on page load
    if (petSelect) {
        // Trigger change event to update pet details
        petSelect.dispatchEvent(new Event('change'));
    }
});

// Find the pet selection event listener and update it
document.getElementById('pet_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (!this.value) {
        clearPetDetails();
        return;
    }
    
    // Update pet details fields
    document.getElementById('pet_name').value = selectedOption.text.split(' (')[0] || '';
    document.getElementById('pet_type').value = selectedOption.dataset.type || '';
    document.getElementById('pet_age').value = selectedOption.dataset.age || '';
    document.getElementById('pet_weight').value = selectedOption.dataset.weight || '';
    document.getElementById('pet_gender').value = selectedOption.dataset.gender || '';
});

// Add this at the end of your DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...

    // Trigger the change event on pet select if a pet is pre-selected
    const petSelect = document.getElementById('pet_id');
    if (petSelect && petSelect.value) {
        petSelect.dispatchEvent(new Event('change'));
    }
});

// Update owner avatar when owner is selected
const ownerSelect = document.getElementById('owner_id');
const ownerAvatar = document.getElementById('owner_avatar');

ownerSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.dataset.avatar) {
        ownerAvatar.src = selectedOption.dataset.avatar;
    } else {
        ownerAvatar.src = '/img/default-avatar.png';
    }
});

// Update pet photo when pet is selected
const petSelect = document.getElementById('pet_id');
const petAvatar = document.getElementById('pet_avatar');

petSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.dataset.photo) {
        petAvatar.src = selectedOption.dataset.photo;
    } else {
        petAvatar.src = '/img/default-pet.png';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('owner_id');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameDisplay = document.getElementById('owner_name_display');
    const ownerNameValue = document.getElementById('owner_name_value');
    const ownerNameInput = document.getElementById('owner_name');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    userSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        // Toggle visibility of pet selection and owner name display
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameDisplay.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        // Update owner name display when input changes
        if (isWalkIn) {
            ownerNameInput.addEventListener('input', function() {
                ownerNameValue.textContent = this.value || 'Not specified';
            });
        }
    });

    // Initialize owner name display if walk-in is selected on page load
    if (userSelect.value === 'no_account') {
        petSelectContainer.style.display = 'none';
        ownerNameDisplay.style.display = 'block';
        registeredPetDetails.style.display = 'none';
        ownerNameValue.textContent = ownerNameInput.value || 'Not specified';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const ownerAvatar = document.getElementById('owner_avatar');
    const dynamicAvatar = document.getElementById('dynamic_avatar');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameContainer = document.getElementById('owner_name_container');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    ownerSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        // Toggle visibility
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameContainer.style.display = isWalkIn ? 'block' : 'none';
        walkinPetGroup.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        // Update avatars
        if (isWalkIn) {
            dynamicAvatar.src = '/img/default-avatar.png';
            dynamicAvatar.alt = 'Owner Avatar';
        } else {
            dynamicAvatar.src = '/img/default-pet.png';
            dynamicAvatar.alt = 'Pet Avatar';
            
            // Update owner avatar if a registered owner is selected
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.avatar) {
                ownerAvatar.src = selectedOption.dataset.avatar;
            }
        }
        
        // Toggle required fields
        const ownerNameInput = document.getElementById('owner_name');
        const petSelect = document.getElementById('pet_id');
        
        if (isWalkIn) {
            ownerNameInput.setAttribute('required', 'required');
            petSelect.removeAttribute('required');
        } else {
            ownerNameInput.removeAttribute('required');
            petSelect.setAttribute('required', 'required');
        }
    });

    // Initialize form state on page load
    if (ownerSelect.value === 'no_account') {
        ownerSelect.dispatchEvent(new Event('change'));
    }

    // Handle pet selection changes
    const petSelect = document.getElementById('pet_id');
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.photo) {
            dynamicAvatar.src = selectedOption.dataset.photo;
        } else {
            dynamicAvatar.src = '/img/default-pet.png';
        }
    });
});
</script>

<!-- Add this script section after your existing scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const ownerAvatar = document.getElementById('owner_avatar');
    const petSelect = document.getElementById('pet_id');
    const petAvatar = document.getElementById('pet_avatar');
    const ownerNameGroup = document.getElementById('owner_name_group');
    const petSelectionGroup = document.getElementById('pet_selection_group');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    // Function to handle owner selection
    ownerSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value === 'no_account') {
            // Handle walk-in customer
            ownerAvatar.src = '/img/default-avatar.png';
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            petSelect.innerHTML = '<option value="">Select Pet</option>';
        } else if (selectedOption.value) {
            try {
                // Fetch owner details
                const response = await fetch(`/api/owners/${selectedOption.value}`);
                if (!response.ok) throw new Error('Failed to fetch owner data');
                const ownerData = await response.json();
                
                // Update owner avatar
                ownerAvatar.src = ownerData.avatar_url || '/img/default-avatar.png';
                
                // Fetch and update pets dropdown
                const petsResponse = await fetch(`/api/owners/${selectedOption.value}/pets`);
                if (!petsResponse.ok) throw new Error('Failed to fetch pets data');
                const petsData = await petsResponse.json();
                
                // Update pets dropdown
                updatePetsDropdown(petsData);
                
                // Show/hide appropriate sections
                ownerNameGroup.style.display = 'none';
                petSelectionGroup.style.display = 'block';
                walkinPetGroup.style.display = 'none';
                registeredPetDetails.style.display = 'block';
                
            } catch (error) {
                console.error('Error:', error);
                // Show error notification
                showNotification('error', 'Failed to fetch owner data');
            }
        } else {
            // Reset everything
            resetForm();
        }
    });

    // Function to handle pet selection
    petSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            try {
                // Fetch pet details
                const response = await fetch(`/api/pets/${selectedOption.value}`);
                if (!response.ok) throw new Error('Failed to fetch pet data');
                const petData = await response.json();
                
                // Update pet avatar and details
                petAvatar.src = petData.photo_url || '/img/default-pet.png';
                updatePetDetails(petData);
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Failed to fetch pet data');
            }
        } else {
            resetPetDetails();
        }
    });

    // Helper Functions
    function updatePetsDropdown(pets) {
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        pets.forEach(pet => {
            const option = document.createElement('option');
            option.value = pet.id;
            option.textContent = `${pet.name} (${pet.category})`;
            option.dataset.photo = pet.photo_url || '/img/default-pet.png';
            option.dataset.name = pet.name;
            option.dataset.category = pet.category;
            option.dataset.breed = pet.breed;
            option.dataset.age = pet.age;
            option.dataset.weight = pet.weight;
            option.dataset.gender = pet.gender.toLowerCase();
            petSelect.appendChild(option);
        });
    }

    function updatePetDetails(pet) {
        document.getElementById('pet_name').value = pet.name;
        document.getElementById('pet_category').value = pet.category;
        document.getElementById('pet_breed').value = pet.breed;
        document.getElementById('pet_age').value = pet.age;
        document.getElementById('pet_weight').value = pet.weight;
        document.getElementById('pet_gender').value = pet.gender;
        document.getElementById('age_unit').value = pet.age_unit || 'years';
    }

    function resetPetDetails() {
        petAvatar.src = '/img/default-pet.png';
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_category').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_weight').value = '';
        document.getElementById('pet_gender').value = '';
        document.getElementById('age_unit').value = 'years';
    }

    function resetForm() {
        ownerAvatar.src = '/img/default-avatar.png';
        ownerNameGroup.style.display = 'none';
        petSelectionGroup.style.display = 'block';
        walkinPetGroup.style.display = 'none';
        registeredPetDetails.style.display = 'none';
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        resetPetDetails();
    }

    function showNotification(type, message) {
        // You can implement this using your preferred notification library
        // For example, using SweetAlert2:
        Swal.fire({
            icon: type,
            title: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
});
</script>
@endpush

@push('page-styles')
<style>
:root {
    --primary-color: #4361ee;
    --primary-light: #eef2ff;
    --primary-dark: #3a4db4;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    border-radius: 12px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.6rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.btn-soft {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background-color: var(--primary-light);
    color: var(--primary-color);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-soft .icon {
    stroke-width: 1.5;
    transition: all 0.2s ease;
}

.btn-soft:hover .icon,
.btn-soft.active .icon {
    stroke: white;
}

.btn-soft:hover {
    background-color: var(--primary-color);
    color: white;
}

.btn-soft.active {
    background-color: var(--primary-color);
    color: white;
}

.badge {
    background-color: var(--primary-light);
    color: var(--primary-color);
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
}

.required:after {
    content: ' *';
    color: #dc3545;
}

.form-label {
    font-weight: 500;
    color: #444;
    margin-bottom: 0.5rem;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] {
    --primary-light: rgba(67, 97, 238, 0.15);
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    border-color: rgba(255,255,255,0.1);
    background-color: rgba(0,0,0,0.2);
}

[data-bs-theme="dark"] .form-label {
    color: rgba(255,255,255,0.9);
}

[data-bs-theme="dark"] .btn-soft {
    background-color: rgba(67, 97, 238, 0.15);
    color: #8ba4f9;
}

[data-bs-theme="dark"] .btn-soft:hover,
[data-bs-theme="dark"] .btn-soft.active {
    background-color: var(--primary-color);
    color: white;
}

[data-bs-theme="dark"] .btn-soft .icon {
    stroke: #8ba4f9;
}

[data-bs-theme="dark"] .btn-soft:hover .icon,
[data-bs-theme="dark"] .btn-soft.active .icon {
    stroke: white;
}

.bg-primary-soft {
    background-color: var(--primary-light);
    color: var(--primary-color);
}

.btn-close {
    padding: 0.25rem;
    margin-left: 0.25rem;
}

.selected-reasons-box {
    border: 1px solid var(--primary-light);
    border-radius: 8px;
    padding: 1rem;
    min-height: 60px;
    margin-top: 0.5rem;
    background-color: rgba(var(--primary-rgb), 0.02);
    position: relative;
}

.selected-reasons-box:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

#empty-reason-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    transition: opacity 0.2s ease;
}

#selected-reasons:not(:empty) + #empty-reason-text {
    opacity: 0;
}

.badge {
    background-color: var(--primary-color);
    color: white;
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge .btn-close {
    padding: 0.25rem;
    margin-left: 0.25rem;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.badge .btn-close:hover {
    opacity: 1;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .selected-reasons-box {
    background-color: rgba(67, 97, 238, 0.05);
    border-color: rgba(67, 97, 238, 0.2);
}

[data-bs-theme="dark"] #empty-reason-text {
    color: rgba(255, 255, 255, 0.5);
}

:root {
    --primary-rgb: 67, 97, 238;
}

/* Add these new styles */
input[type="date"] {
    position: relative;
    cursor: pointer;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    position: absolute;
    right: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    color: transparent;
    cursor: pointer;
}

.date-warning {
    font-size: 0.875rem;
}

/* Dark mode adjustments */
[data-bs-theme="dark"] input[type="date"][data-booked="true"] {
    background-color: rgba(67, 97, 238, 0.15);
}

.form-section {
    min-height: 450px;
    overflow-y: auto;
}

.diagnosis-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 3.5rem);
}

.modal-content {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.form-control-plaintext {
    padding: 0.5rem;
    background-color: var(--tblr-bg-surface);
    border-radius: 4px;
    min-height: 40px;
}

.form-sections {
    background-color: var(--tblr-bg-surface);
    border-color: var(--tblr-border-color) !important;
}

.form-section {
    transition: all 0.3s ease;
}

.btn-group .btn {
    flex: 1;
}

.card-header.bg-primary {
    background-color: var(--primary-color) !important;
}

.card-header.bg-primary .card-title {
    color: white;
}

.form-sections {
    min-height: 300px;
    position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .diagnosis-group {
        grid-template-columns: 1fr;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 4px !important;
        margin-bottom: 0.25rem;
    }
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.input-group-text {
    padding: 0.25rem;
}

.card {
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

.form-label {
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.input-group {
    position: relative;
}

.input-group .form-control:not(:first-child) {
    padding-left: 3rem;
}

.input-group .avatar {
    margin-right: 0.5rem;
}

.avatar-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-lg {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card {
    border: 1px solid rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .avatar-lg {
    border-color: rgba(255,255,255,0.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

[data-bs-theme="dark"] .card {
    border-color: rgba(255,255,255,0.1);
}

#registered_pet_details {
    transition: all 0.3s ease;
}

#registered_pet_details .card {
    height: 300px; /* Fixed height */
    display: flex;
    flex-direction: column;
    margin-bottom: 0;
}

#registered_pet_details .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

#registered_pet_details .row {
    flex: 1;
}

/* Add these styles for the pet selection/owner name switch */
#pet_select_container,
#owner_name_group {
    transition: opacity 0.3s ease;
}

.form-control[readonly] {
    background-color: var(--tblr-bg-surface);
    opacity: 0.8;
}
</style>
@endpush
