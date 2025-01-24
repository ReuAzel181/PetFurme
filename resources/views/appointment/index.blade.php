@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => $showArchived ? __('Archived Appointments') : __('Appointments'),
                        'section' => 'OVERVIEW'
                    ])
                </div>
            </div>
        </div>
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('appointment.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Add Appointment
            </a>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th width="20%">Owner Details</th>
                                    <th width="20%">Pet Details</th>
                                    <th width="15%">Schedule</th>
                                    <th width="25%">Reason for Visit</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td class="text-muted">{{ $appointment->id }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">{{ $appointment->display_name }}</div>
                                                @if($appointment->is_walk_in)
                                                    <span class="badge bg-yellow-lt mt-1" title="Walk-in appointment">
                                                        <i class="fas fa-walking me-1"></i>Walk-in
                                                    </span>
                                                @else
                                                    <span class="badge bg-azure-lt mt-1" title="Registered user">
                                                        <i class="fas fa-user-check me-1"></i>Registered
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">{{ $appointment->pet_name }}</div>
                                                <div class="text-muted small">
                                                    <span class="badge bg-blue-lt">{{ $appointment->pet_type }}</span>
                                                    <span class="ms-2 badge bg-green-lt">{{ $appointment->age_display }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="text-dark">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date_display)->format('M d, Y') }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @forelse($appointment->reason_for_visit as $reason)
                                                    <span class="badge bg-primary-lt">{{ $reason }}</span>
                                                @empty
                                                    <span class="text-muted">No reasons specified</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-link fs-4">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger fs-4">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
</div>
@endsection

@section('scripts')
<script>
    // Removed unnecessary custom logic for "reason for visit"
    // If additional interactive functionality is required, 
    // add it here in a streamlined way.
</script>
@endsection

@push('page-styles')
<style>
    .table-vcenter td {
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .btn-icon {
        padding: 0.5rem;
        width: 34px;
        height: 34px;
    }
    
    .table td {
        padding: 1rem;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem;
    }
    
    .btn-group {
        gap: 0.5rem;
    }
    
    .badge.bg-primary-lt {
        color: var(--tblr-primary);
        background-color: var(--tblr-primary-lt);
    }
    
    .badge.bg-azure-lt {
        color: #0284c7;
        background-color: #e0f2fe;
    }
    
    .badge.bg-green-lt {
        color: #16a34a;
        background-color: #dcfce7;
    }
    
    .badge.bg-yellow-lt {
        color: #ca8a04;
        background-color: #fef9c3;
    }
</style>
@endpush
