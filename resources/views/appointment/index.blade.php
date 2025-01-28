@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ $showArchived ? __('Archived Appointments') : __('Appointments') }}
                    </h2>
                    <div class="text-muted mt-1">Manage appointment schedules</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <a href="{{ route('appointment.create') }}" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Add Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Appointments</h3>
                    <div class="card-actions">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">
                                    All Appointments
                                </a>
                                <a class="dropdown-item" href="#">
                                    Pending Confirmation
                                </a>
                                <a class="dropdown-item" href="#">
                                    Confirmed
                                </a>
                                <a class="dropdown-item" href="#">
                                    Completed
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 9l14 0"></path>
                                            <path d="M5 15l14 0"></path>
                                            <path d="M11 4l-4 16"></path>
                                            <path d="M17 4l-4 16"></path>
                                        </svg>
                                        ID
                                    </th>
                                    <th width="13%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                        Owner Details
                                    </th>
                                    <th width="13%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 5h2"></path>
                                            <path d="M19 12c-.667 5.333 -2.333 8 -5 8h-4c-2.667 0 -4.333 -2.667 -5 -8"></path>
                                            <path d="M11 16c0 .667 .333 1 1 1s1 -.333 1 -1h-2z"></path>
                                            <path d="M12 18v2"></path>
                                            <path d="M10 11v.01"></path>
                                            <path d="M14 11v.01"></path>
                                            <path d="M5 4l6 .97l6 -.97l2 4l-4 2l-8 0l-4 -2z"></path>
                                        </svg>
                                        Pet Details
                                    </th>
                                    <th width="13%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M12 14l1 2"></path>
                                        </svg>
                                        Schedule
                                    </th>
                                    <th width="13%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-status-change" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M18 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M6 12l6 0"></path>
                                            <path d="M12 12l6 0"></path>
                                            <path d="M6 6l12 0"></path>
                                        </svg>
                                        Status
                                    </th>
                                    <th width="15%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M9 12l.01 0"></path>
                                            <path d="M13 12l2 0"></path>
                                            <path d="M9 16l.01 0"></path>
                                            <path d="M13 16l2 0"></path>
                                        </svg>
                                        Reason
                                    </th>
                                    <th width="15%">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
                                            <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
                                        </svg>
                                        Created By
                                    </th>
                                    <th width="13%" class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                        </svg>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td class="text-muted">
                                            #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <div class="text-dark fw-bold">{{ $appointment->display_name }}</div>
                                                @if($appointment->is_walk_in)
                                                    <span class="badge bg-yellow-lt" title="Walk-in appointment">
                                                        <i class="fas fa-walking me-1"></i>Walk-in
                                                    </span>
                                                @else
                                                    <span class="badge bg-azure-lt" title="Registered user">
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
                                            @switch($appointment->status)
                                                @case('pending')
                                                    <span class="badge bg-yellow-lt">
                                                        <i class="fas fa-clock me-1"></i>For Confirmation
                                                    </span>
                                                    @break
                                                @case('confirmed')
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="badge bg-blue-lt">
                                                            <i class="fas fa-check-circle me-1"></i>Confirmed
                                                        </span>
                                                        @if($appointment->confirmed_by)
                                                            <small class="text-muted">
                                                                Confirmed by: {{ $appointment->confirmer->name }}
                                                                <br>
                                                                <span class="text-muted-light">{{ $appointment->confirmed_at?->format('M d, Y g:i A') }}</span>
                                                            </small>
                                                        @endif
                                                    </div>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-green-lt">
                                                        <i class="fas fa-check-double me-1"></i>Completed
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-red-lt">
                                                        <i class="fas fa-times-circle me-1"></i>Cancelled
                                                    </span>
                                                    @break
                                                @case('no_show')
                                                    <span class="badge bg-gray-lt">
                                                        <i class="fas fa-user-slash me-1"></i>No Show
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary-lt">
                                                        <i class="fas fa-question-circle me-1"></i>Unknown
                                                    </span>
                                            @endswitch
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
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                @if($appointment->created_by_id)
                                                    <div class="d-flex align-items-center">
                                                        @if($appointment->creator_type === 'staff')
                                                            <span class="badge bg-primary-lt">
                                                                <i class="fas fa-user-shield me-1"></i>Staff
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary-lt">
                                                                <i class="fas fa-user me-1"></i>User
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-dark small">{{ $appointment->creator->name }}</div>
                                                    <div class="text-muted small">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $appointment->created_at->format('M d, Y') }}
                                                        <br>
                                                        {{ $appointment->created_at->format('g:i A') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">Not available</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                @if($appointment->status === 'pending')
                                                    @can('confirm-appointments')
                                                        <form action="{{ route('appointment.confirm', $appointment->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-icon btn-success" title="Confirm Appointment">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M5 12l5 5l10 -10"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                                
                                                @if(in_array($appointment->status, ['pending', 'confirmed']))
                                                    <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-icon btn-warning" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                                </div>
                                                <p class="empty-title">No appointments found</p>
                                                <p class="empty-subtitle text-muted">
                                                    Start by adding a new appointment using the button above.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
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
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-icon svg {
        width: 20px;
        height: 20px;
        stroke-width: 2;
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
    
    .badge.bg-red-lt {
        color: #dc2626;
        background-color: #fee2e2;
    }
    
    .badge.bg-gray-lt {
        color: #4b5563;
        background-color: #f3f4f6;
    }
    
    .badge.bg-blue-lt {
        color: #2563eb;
        background-color: #dbeafe;
    }
    
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .empty {
        text-align: center;
        padding: 2rem;
    }
    
    .empty-icon {
        margin-bottom: 1rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .empty-subtitle {
        font-size: 0.875rem;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .gap-1 {
        gap: 0.25rem;
    }
    
    .d-flex.gap-2 {
        gap: 0.75rem !important;
    }
</style>
@endpush
