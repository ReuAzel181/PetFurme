@extends('layouts.tabler')

@section('content')
<div class="page">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Add New Appointment'),
                        'section' => 'APPOINTMENT'
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('appointment.store') }}" method="POST" id="appointmentForm">
                        @csrf

                        <!-- Pet Owner Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pet Owner</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">Select Pet Owner</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pet Selection -->
                        <div class="mb-3" id="pet_selection_group">
                            <label for="pet_id" class="form-label">Select Pet</label>
                            <select name="pet_id" id="pet_id" class="form-select" required>
                                <option value="">Choose a pet</option>
                            </select>
                        </div>

                        <!-- Pet Details -->
                        <div id="pet_details">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pet_name" class="form-label">Pet Name</label>
                                    <input type="text" id="pet_name" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_type" class="form-label">Pet Type</label>
                                    <input type="text" id="pet_type" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="pet_age" class="form-label">Pet Age</label>
                                    <input type="text" id="pet_age" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Timing -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Time</label>
                                <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                            </div>
                        </div>

                        <!-- Reasons for Visit -->
                        <div class="mb-3">
                            <label class="form-label">Reasons for Visit</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-primary reason-btn" data-reason="Routine Check-up">
                                    Routine Check-up
                                </button>
                                <button type="button" class="btn btn-outline-primary reason-btn" data-reason="Vaccination">
                                    Vaccination
                                </button>
                                <button type="button" class="btn btn-outline-primary reason-btn" data-reason="Emergency">
                                    Emergency
                                </button>
                                <button type="button" class="btn btn-outline-primary reason-btn" data-reason="Grooming">
                                    Grooming
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="other-reason-btn">
                                    Other
                                </button>
                            </div>
                            
                            <input type="hidden" name="reason_for_visit" id="reason_for_visit" required>
                            
                            <!-- Selected Reasons Display -->
                            <div class="mt-3">
                                <label class="form-label">Selected Reasons:</label>
                                <div id="selected-reasons" class="d-flex flex-wrap gap-2">
                                    <!-- Reason badges will be added here -->
                                </div>
                            </div>
                        </div>

                        <!-- Other Reason Input -->
                        <div class="mb-3" id="other_reason_group" style="display: none;">
                            <label for="other_reason" class="form-label">Specify Other Reason</label>
                            <div class="input-group">
                                <input type="text" id="other_reason" class="form-control">
                                <button type="button" class="btn btn-primary" id="add-other-reason">Add</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Appointment</button>
                        </div>
                    </form>
                </div>
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

    // Function to clear pet details
    function clearPetDetails() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_type').value = '';
        document.getElementById('pet_age').value = '';
    }

    // Handle Pet Owner Selection
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();
        
        if (!userId) {
            petSelect.innerHTML = '<option value="">Choose a pet</option>';
            return;
        }

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
    });

    // Handle Pet Selection
    petSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!this.value) {
            clearPetDetails();
            return;
        }
        
        document.getElementById('pet_name').value = selectedOption.text || '';
        document.getElementById('pet_type').value = selectedOption.dataset.type || '';
        document.getElementById('pet_age').value = selectedOption.dataset.age || '';
    });

    // Function to update the hidden input with selected reasons
    function updateReasonInput() {
        reasonForVisitInput.value = Array.from(selectedReasons).join(',');
    }

    // Function to create a reason badge
    function createReasonBadge(reason) {
        const badge = document.createElement('div');
        badge.className = 'badge bg-primary d-flex align-items-center gap-2 p-2';
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
                button.classList.remove('btn-primary');
                button.classList.add('btn-outline-primary');
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
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline-primary');
                
                const badge = selectedReasonsContainer.querySelector(`[data-reason="${reason}"]`);
                if (badge) badge.remove();
            } else {
                selectedReasons.add(reason);
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                
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
});
</script>
@endpush
