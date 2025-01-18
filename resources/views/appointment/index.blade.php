@extends('layouts.tabler')

@section('content')
<div class="page">
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3>Appointments</h3>
                <a href="{{ route('appointment.create') }}" class="btn btn-primary ms-auto">Add Appointment</a>
            </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Pet Name</th>
                                <th>Pet Type</th>
                                <th>Pet Age</th>
                                <th>Reason for Visit</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointment as $entry)
                                <tr>
                                    <td>{{ $entry->owner_name ?? $entry->user_name ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_name ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_type ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_age ?? 'N/A' }}</td>
                                    <td>
                                        @if($entry->reason_for_visit === null)
                                            <p>Reason for visit is null</p>
                                        @elseif($entry->reason_for_visit === '')
                                            <p>Reason for visit is an empty string</p>
                                        @else
                                            <p>Reason for visit: {{ $entry->reason_for_visit }}</p>
                                        @endif

                                    </td>
                                    <td>{{ $entry->appointment_date }}</td>
                                    <td>{{ $entry->appointment_time }}</td>
                                    <td>
                                        <a href="{{ route('appointment.edit', $entry->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('appointment.destroy', $entry->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    let selectedReasons = JSON.parse(document.getElementById('reason_for_visit').value || '[]');

    function addReason() {
        const reasonOptions = document.getElementById('reason-options');
        const selectedOption = reasonOptions.value;

        if (selectedOption === 'Other') {
            document.getElementById('custom-reason-group').style.display = 'block';
        } else if (selectedOption && !selectedReasons.includes(selectedOption)) {
            selectedReasons.push(selectedOption);
            renderReasons();
            reasonOptions.value = '';
        }
    }

    function addCustomReason() {
        const customReasonInput = document.getElementById('custom_reason');
        const customReason = customReasonInput.value.trim();

        if (customReason && !selectedReasons.includes(customReason)) {
            selectedReasons.push(customReason);
            renderReasons();
            customReasonInput.value = '';
            document.getElementById('custom-reason-group').style.display = 'none';
        }
    }

    function renderReasons() {
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        selectedReasonsContainer.innerHTML = '';

        selectedReasons.forEach(reason => {
            const reasonElement = document.createElement('span');
            reasonElement.className = 'badge bg-primary text-white me-2';
            reasonElement.innerHTML = `${reason} <span class="ms-2 cursor-pointer" style="cursor:pointer;" onclick="removeReason('${reason}')">&times;</span>`;
            selectedReasonsContainer.appendChild(reasonElement);
        });

        document.getElementById('reason_for_visit').value = JSON.stringify(selectedReasons);
    }

    function removeReason(reason) {
        selectedReasons = selectedReasons.filter(r => r !== reason);
        renderReasons();
    }

    renderReasons();
</script>
@endsection
