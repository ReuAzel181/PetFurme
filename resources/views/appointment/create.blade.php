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
                        <div class="mb-3">
                            <label for="user_account" class="form-label">User Account</label>
                            <select name="user_id" id="user_account" class="form-select" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    @if($user->role === 'pet_owner')
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-select" required>
                                <option value="">Select Pet</option>
                                <!-- Pets will be dynamically populated -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reason_for_visit" class="form-label">Reason for Visit</label>
                            <textarea name="reason_for_visit" id="reason_for_visit" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                        </div>
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
