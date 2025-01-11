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
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ $appointment->owner_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_account" class="form-label">User Account</label>
                            <select name="user_id" id="user_account" class="form-select">
                                <option value="">User with no account</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $appointment->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <div class="mb-3">
                            <label for="reason_for_visit" class="form-label">Reason for Visit</label>
                            <textarea name="reason_for_visit" id="reason_for_visit" class="form-control" rows="3" required>{{ $appointment->reason_for_visit }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                        </div>
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
