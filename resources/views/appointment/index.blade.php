@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
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
        <div class="card-header d-flex align-items-center">
                <a href="{{ route('appointment.create') }}" class="btn btn-primary ms-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 5l0 14"></path>
                    <path d="M5 12l14 0"></path>
                </svg>
                Add Appointment</a>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">


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
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ $appointment->display_name }}</td>
                                    <td>{{ $appointment->pet_name ?? 'N/A' }}</td>
                                    <td>{{ $appointment->pet_type ?? 'N/A' }}</td>
                                    <td>{{ $appointment->pet_age ?? 'N/A' }}</td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>
                                        @php
                                            $reasons = is_string($appointment->reason_for_visit) 
                                                ? json_decode($appointment->reason_for_visit, true) 
                                                : [];
                                        @endphp
                                        @if(is_array($reasons))
                                            {{ implode(', ', $reasons) }}
                                        @else
                                            {{ $appointment->reason_for_visit ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" style="display:inline;">
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
