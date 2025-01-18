@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                @include('partials._page_header', [
                    'title' => __('Appointments'),
                    'section' => 'OVERVIEW'
                ])
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary ms-auto">Add Appointment</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Owner Name</th>
                                <th>Pet Name</th>
                                <th>Pet Type</th>
                                <th>Pet Age</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason for Visit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointment as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->owner_name ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_name ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_type ?? 'N/A' }}</td>
                                    <td>{{ $entry->pet_age ?? 'N/A' }}</td>
                                    <td>{{ $entry->appointment_date }}</td>
                                    <td>{{ $entry->appointment_time }}</td>
                                    <td>{{ $entry->reason_for_visit ?? 'N/A' }}</td>
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
    // Removed unnecessary custom logic for "reason for visit"
    // If additional interactive functionality is required, 
    // add it here in a streamlined way.
</script>
@endsection
