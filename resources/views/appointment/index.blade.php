@extends('layouts.tabler')
@section('content')
<div class="page">
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3>Appointments</h3>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary">Add Appointment</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Pet Name</th>
                                <th>Pet Type</th>
                                <th>Pet Age</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointment as $entry)
                            <tr>
                                <td>{{ $entry->owner_name }}</td>
                                <td>{{ $entry->pet_name }}</td>
                                <td>{{ $entry->pet_type }}</td>
                                <td>{{ $entry->pet_age }}</td>
                                <td>{{ $entry->reason_for_visit }}</td>
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
