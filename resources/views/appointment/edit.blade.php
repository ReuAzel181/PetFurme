@extends('layouts.tabler')

@section('content')
<div class="page">
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Appointment</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointment.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Owner Name -->
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ $appointment->owner_name }}" required>
                        </div>

                        <!-- User Account -->
                        <div class="mb-3">
                            <label for="user_account" class="form-label">User Account</label>
                            <select name="user_id" id="user_account" class="form-select">
                                <option value="">User with no account</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $appointment->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pet Details -->
                        <div class="mb-3">
                            <label for="pet_name" class="form-label">Pet Name</label>
                            <input type="text" name="pet_name" id="pet_name" class="form-control" value="{{ $appointment->pet_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pet_type" class="form-label">Pet Type</label>
                            <input type="text" name="pet_type" id="pet_type" class="form-control" value="{{ $appointment->pet_type }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pet_age" class="form-label">Pet Age</label>
                            <input type="number" name="pet_age" id="pet_age" class="form-control" value="{{ $appointment->pet_age }}" required>
                        </div>

                        <!-- Reasons for Visit -->
                        <div class="mb-3">
                            <label for="reason_for_visit" class="form-label">Reasons for Visit</label>
                            <div id="selected-reasons" class="mb-2">
                            @if(!empty($appointment->reason_for_visit))
                                @foreach(json_decode($appointment->reason_for_visit, true) as $reason)
                                    <span class="badge bg-primary text-white me-2">{{ $reason }}</span>
                                @endforeach
                            @else
                                <span>N/A</span>
                            @endif
                            </div>
                            <div class="input-group">
                                <select id="reason-options" class="form-select">
                                    <option value="">Select a reason</option>
                                    @foreach($reasons as $reason)
                                        <option value="{{ $reason }}">{{ $reason }}</option>
                                    @endforeach
                                    <option value="Other">Other</option>
                                </select>
                                <button type="button" class="btn btn-secondary" onclick="addReason()">Add</button>
                            </div>
                            <div id="custom-reason-group" class="mt-2" style="display: none;">
                                <label for="custom_reason" class="form-label">Specific Reason</label>
                                <input type="text" id="custom_reason" class="form-control">
                                <button type="button" class="btn btn-secondary mt-2" onclick="addCustomReason()">Add Specific Reason</button>
                            </div>
                            <input type="hidden" name="reason_for_visit" id="reason_for_visit" value="{{ old('reason_for_visit', $appointment->reason_for_visit ?? '[]') }}">
                        </div>


                        <!-- Appointment Date -->
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                        </div>

                        <!-- Appointment Time -->
                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="{{ $appointment->appointment_time }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedReasons = @json($appointment->reasons->pluck('name')->toArray());

    function addReason() {
        const reasonOptions = document.getElementById('reason-options');
        const selectedOption = reasonOptions.value;

        if (selectedOption === 'Other') {
            document.getElementById('custom-reason-group').style.display = 'block';
        } else if (selectedOption && !selectedReasons.includes(selectedOption)) {
            selectedReasons.push(selectedOption);
            renderReasons();
            reasonOptions.value = ''; // Reset dropdown
        }
    }

    function addCustomReason() {
        const customReasonInput = document.getElementById('custom_reason_for_visit');
        const customReason = customReasonInput.value.trim();

        if (customReason && !selectedReasons.includes(customReason)) {
            selectedReasons.push(customReason);
            renderReasons();
            customReasonInput.value = ''; // Clear input
            document.getElementById('custom-reason-group').style.display = 'none';
        }
    }

    function removeReason(reason) {
        selectedReasons = selectedReasons.filter(r => r !== reason);
        renderReasons();
    }

    function renderReasons() {
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        selectedReasonsContainer.innerHTML = '';

        selectedReasons.forEach(reason => {
            const reasonElement = document.createElement('span');
            reasonElement.className = 'badge bg-primary text-white me-2';
            reasonElement.innerHTML = `
                ${reason}
                <span class="ms-2 cursor-pointer" style="cursor:pointer;" onclick="removeReason('${reason}')">&times;</span>
            `;
            selectedReasonsContainer.appendChild(reasonElement);
        });

        // Update the hidden input with selected reasons
        document.getElementById('reason_for_visit').value = JSON.stringify(selectedReasons);
    }

    // Initial rendering of reasons
    renderReasons();
</script>
@endsection
