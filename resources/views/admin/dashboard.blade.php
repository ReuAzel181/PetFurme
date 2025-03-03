@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Dashboard
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <!-- Stats -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Pets</div>
                        </div>
                        <div class="h1 mb-3">{{ $stats['total_pets'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Pet Owners</div>
                        </div>
                        <div class="h1 mb-3">{{ $stats['total_users'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Appointments</div>
                        </div>
                        <div class="h1 mb-3">{{ $stats['total_appointments'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Pending Appointments</div>
                        </div>
                        <div class="h1 mb-3">{{ $stats['pending_appointments'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Appointments</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Pet Owner</th>
                                    <th>Pet</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->owner_name }}</td>
                                    <td>{{ $appointment->pet_name }}</td>
                                    <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : 'success' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
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
</div>
@endsection 