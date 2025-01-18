@extends('layouts.tabler')

@section('content')
<div class="page">
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>Add Appointment</h3>
                </div>
                <div class="card-body">
                <form action="{{ route('appointment.store') }}" method="POST">
                    @csrf

                    <!-- User Account Selection -->
                    <div class="mb-3">
                        <label for="user_account" class="form-label">User Account</label>
                        <select name="user_id" id="user_account" class="form-select">
                            <option value="">User with no account</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Owner Name Field -->
                    <div class="mb-3" id="owner_name_group" style="display: block;">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control">
                    </div>

                    <!-- Pet Selection -->
                    <div class="mb-3" id="pet_selection_group" style="display: none;">
                        <label for="pet_id" class="form-label">Pet</label>
                        <select name="pet_id" id="pet_id" class="form-select">
                            <option value="">Select Pet</option>
                        </select>
                        <p id="no_pet_message" class="text-danger" style="display: none;">
                            No pets available for this user. Please provide the pet's name below:
                        </p>
                        <div id="add_pet_name_group" style="display: none;">
                            <label for="new_pet_name" class="form-label">Pet Name</label>
                            <input type="text" name="new_pet_name" id="new_pet_name" class="form-control">
                        </div>
                    </div>

                    <!-- Reasons for Visit -->
                    <div class="mb-3">
                        <label for="reason_for_visit" class="form-label">Reasons for Visit</label>
                        <select name="reason_for_visit[]" id="reason_for_visit" class="form-select" multiple>
                            <option value="Routine Check-up">Routine Check-up</option>
                            <option value="Vaccination">Vaccination</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Grooming">Grooming</option>
                            <option value="Other">Other</option>
                        </select>
                        <p id="custom-reason-group" class="mt-2" style="display: none;">
                            <label for="custom_reason" class="form-label">Custom Reason</label>
                            <input type="text" id="custom_reason" class="form-control">
                            <button type="button" class="btn btn-secondary mt-2" onclick="addCustomReason()">Add Custom Reason</button>
                        </p>
                    </div>

                    <!-- Appointment Date -->
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                    </div>

                    <!-- Appointment Time -->
                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Time</label>
                        <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function handleUserSelection() {
            const userAccount = document.getElementById('user_account').value;
            const petDropdown = document.getElementById('pet_id');
            const noPetMessage = document.getElementById('no_pet_message');
            const petSelectionGroup = document.getElementById('pet_selection_group');
            const addPetNameGroup = document.getElementById('add_pet_name_group');

            console.log("Selected User ID:", userAccount); // Debugging log

            // Reset the pet dropdown
            petDropdown.innerHTML = '<option value="">Select Pet</option>';

            if (!userAccount) {
                console.log("No user selected, hiding pet field.");
                petSelectionGroup.style.display = 'none';
                noPetMessage.style.display = 'none';
                addPetNameGroup.style.display = 'none';
                return;
            }

            fetch(`/api/users/${userAccount}/pets`)
                .then(response => {
                    console.log("API Response Status:", response.status); // Debugging log
                    if (!response.ok) throw new Error('Failed to fetch pets');
                    return response.json();
                })
                .then(data => {
                    console.log("Fetched Pets:", data); // Debugging log
                    if (data.length > 0) {
                        noPetMessage.style.display = 'none';
                        petSelectionGroup.style.display = 'block';
                        addPetNameGroup.style.display = 'none';

                        data.forEach(pet => {
                            const option = document.createElement('option');
                            option.value = pet.id;
                            option.textContent = pet.name; // Display pet name
                            petDropdown.appendChild(option);
                        });
                    } else {
                        noPetMessage.style.display = 'block';
                        petSelectionGroup.style.display = 'block';
                        addPetNameGroup.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error("Error fetching pets:", error); // Debugging log
                    noPetMessage.style.display = 'block';
                    petSelectionGroup.style.display = 'block';
                    addPetNameGroup.style.display = 'block';
                });
        }


        // Event Listener for "Reason for Visit"
        document.getElementById('reason_for_visit').addEventListener('change', function () {
            if (Array.from(this.selectedOptions).some(option => option.value === 'Other')) {
                document.getElementById('custom-reason-group').style.display = 'block';
            } else {
                document.getElementById('custom-reason-group').style.display = 'none';
            }
        });

        // Attach the handleUserSelection function to the dropdown
        document.getElementById('user_account').addEventListener('change', handleUserSelection);
    });
</script>
@endsection
