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
                            <div class="col-md-6">
                                    <label class="form-label required">Pet Owner</label>
                                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select Pet Owner</option>
                                        <option value="no_account">No Account (Walk-in)</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div id="owner_name_group" class="col-md-6" style="display: none;">
                                    <label class="form-label required">Owner Name</label>
                                    <input type="text" id="owner_name" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" value="{{ old('owner_name') }}">
                                    @error('owner_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div id="pet_selection_group" class="col-md-6">
                                    <label class="form-label required">Select Pet</label>
                                    <select id="pet_id" name="pet_id" class="form-select @error('pet_id') is-invalid @enderror">
                                        <option value="">Choose a pet</option>
                                    </select>
                                    @error('pet_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            <div id="walkin_pet_group" class="col-12" style="display: none;">
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
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('walkin_pet_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
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
                                </div>
                            </div>

                            <div id="registered_pet_details" class="row g-3">
                                <div class="col-md-4">
                                                    <label class="form-label">Pet Name</label>
                                                    <input type="text" id="pet_name" class="form-control" readonly>
                                                </div>

                                <div class="col-md-4">
                                                    <label class="form-label">Pet Type</label>
                                                    <input type="text" id="pet_type" class="form-control" readonly>
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
                            </div>

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
                                        <button type="button" class="btn btn-soft reason-btn" data-reason="{{ $category }}">
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
                                    <button type="button" class="btn btn-soft" id="other-reason-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Other
                                    </button>
                                            </div>
                                            <div id="other_reason_group" style="display: none;">
                                                <div class="input-group mb-2">
                                                    <input type="text" id="other_reason" class="form-control" placeholder="Enter other reason">
                                                    <button type="button" class="btn btn-primary" id="add-other-reason">Add</button>
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

                            <div class="col-12">
                                            <label class="form-label">Additional Notes</label>
                                            <textarea name="notes" class="form-control" rows="3" 
                                          placeholder="Any additional information about the visit...">{{ old('notes') }}</textarea>
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
    const ownerNameGroup = document.getElementById('owner_name_group');
    const ownerNameInput = document.getElementById('owner_name');
    const petSelectionGroup = document.getElementById('pet_selection_group');
    const appointmentDate = document.getElementById('appointment_date');
    const appointmentTime = document.getElementById('appointment_time');

    // Check if there's an existing appointment and pre-select appropriate fields
    const existingUserId = '{{ old("user_id", $appointment->user_id ?? "") }}';
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
        document.getElementById('pet_type').value = '';
        document.getElementById('pet_age').value = '';
    }

    // Handle Pet Owner Selection with Walk-in Support
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        if (userId === 'no_account') {
            // Show walk-in fields
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'none';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            
            // Make walk-in fields required
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            
            // Remove requirement from pet selection
            petSelect.removeAttribute('required');
        } else {
            // Show registered user fields
            ownerNameGroup.style.display = 'none';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'none';
            registeredPetDetails.style.display = 'flex';
            
            // Make pet selection required
            petSelect.setAttribute('required', 'required');
            
            // Remove requirements from walk-in fields
            document.getElementById('walkin_pet_name').removeAttribute('required');
            document.getElementById('walkin_pet_type').removeAttribute('required');
            document.getElementById('walkin_pet_age').removeAttribute('required');
            
            // Load pets if a user is selected
            if (userId) {
                petSelect.innerHTML = '<option value="">Loading pets...</option>';
                clearPetDetails();

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
                                option.dataset.type = pet.category || '';
                                option.dataset.age = pet.age || '';
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
            } else {
                petSelect.innerHTML = '<option value="">Choose a pet</option>';
            }
        }
    });

    // Handle Pet Selection
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!this.value) {
            clearPetDetails();
            return;
        }
        
        document.getElementById('pet_name').value = selectedOption.text || '';
        document.getElementById('pet_type').value = selectedOption.dataset.type === 'Canine' ? 'Dog' : 
            (selectedOption.dataset.type === 'Feline' ? 'Cat' : selectedOption.dataset.type) || '';
        document.getElementById('pet_age').value = selectedOption.dataset.age || '';
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
    reasonButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reason = this.dataset.reason;
            
            if (selectedReasons.has(reason)) {
                selectedReasons.delete(reason);
                this.classList.remove('active');
                
                const badge = selectedReasonsContainer.querySelector(`[data-reason="${reason}"]`);
                if (badge) badge.remove();
            } else {
                selectedReasons.add(reason);
                this.classList.add('active');
                
                const badge = createReasonBadge(reason);
                badge.dataset.reason = reason;
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
            alert('Please fill in all required fields');
            return;
        }

        // Create FormData object
        const formData = new FormData(this);
        
        // If it's a walk-in appointment, remove pet_id requirement
        if (userSelect.value === 'no_account') {
            formData.delete('pet_id');
        }

        // Submit the form using fetch
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                // Show error messages
                const errors = data.errors || {};
                Object.keys(errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentElement.querySelector('.invalid-feedback') 
                            || document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = errors[field][0];
                        input.parentElement.appendChild(feedback);
                    }
                });
                alert(data.message || 'Please check the form for errors');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the appointment');
        });
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
</style>
@endpush
