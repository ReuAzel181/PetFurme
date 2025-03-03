@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Archives
                </h2>
                <div class="text-muted mt-1">View and manage archived records</div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 11l5 5l5 -5" />
                                <path d="M12 4l0 12" />
                            </svg>
                            Download Backup
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('backup.download', 'users') }}">Users Backup</a></li>
                            <li><a class="dropdown-item" href="{{ route('backup.download', 'pets') }}">Pets Backup</a></li>
                            <li><a class="dropdown-item" href="{{ route('backup.download', 'orders') }}">Orders Backup</a></li>
                            <li><a class="dropdown-item" href="{{ route('backup.download', 'appointments') }}">Appointments Backup</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('backup.download', 'all') }}">Full Backup (ZIP)</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-success ms-2" onclick="triggerAutoBackup()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                        </svg>
                        Auto Backup
                    </button>
                    <a href="{{ route('backup.list') }}" class="btn btn-info ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"/>
                            <path d="M10 12l4 0"/>
                        </svg>
                        View Backups
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Archive Type Toggles -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="archive-type" id="users" value="users" checked>
                    <label class="btn btn-outline-primary users-btn" for="users" style="border-color: #2FB344; color: #2FB344;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                        </svg>
                        Users
                        <span class="badge ms-2" style="background-color: rgba(47, 179, 68, 0.1) !important; color: #2FB344;">
                            {{ $archivedUsers->total() }}
                        </span>
                    </label>
                    
                    <input type="radio" class="btn-check" name="archive-type" id="pets" value="pets">
                    <label class="btn btn-outline-primary pets-btn" for="pets" style="border-color: #0054a6; color: #0054a6;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 5c-1.886 0 -2.828 0 -3.414 .586c-.586 .586 -.586 1.528 -.586 3.414v6c0 1.886 0 2.828 .586 3.414c.586 .586 1.528 .586 3.414 .586h6c1.886 0 2.828 0 3.414 -.586c.586 -.586 .586 -1.528 .586 -3.414v-6c0 -1.886 0 -2.828 -.586 -3.414c-.586 -.586 -1.528 -.586 -3.414 -.586h-6z"/>
                            <path d="M13 9h2c2 0 2 -1 2 -1"/>
                            <path d="M9 9h-2c-2 0 -2 -1 -2 -1"/>
                            <path d="M12 15a3 3 0 0 1 -3 -3"/>
                        </svg>
                        Pets
                        <span class="badge ms-2" style="background-color: rgba(0, 84, 166, 0.1) !important; color: #0054a6;">
                            {{ $archivedPets->total() }}
                        </span>
                    </label>
                    
                    <input type="radio" class="btn-check" name="archive-type" id="orders" value="orders">
                    <label class="btn btn-outline-primary orders-btn" for="orders" style="border-color: #F76707; color: #F76707;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M17 17h-11v-14h-2"/>
                            <path d="M6 5l14 1l-1 7h-13"/>
                        </svg>
                        Orders
                        <span class="badge ms-2" style="background-color: rgba(247, 103, 7, 0.1) !important; color: #F76707;">
                            {{ $archivedOrders->total() }}
                        </span>
                    </label>
                    
                    <input type="radio" class="btn-check" name="archive-type" id="appointments" value="appointments">
                    <label class="btn btn-outline-primary appointments-btn" for="appointments" style="border-color: #4299E1; color: #4299E1;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                            <path d="M16 3l0 4"/>
                            <path d="M8 3l0 4"/>
                            <path d="M4 11l16 0"/>
                            <path d="M8 15h2v2h-2z"/>
                        </svg>
                        Appointments
                        <span class="badge ms-2" style="background-color: rgba(66, 153, 225, 0.1) !important; color: #4299E1;">
                            {{ $archivedAppointments->count() }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Archived Users Table -->
        <div class="card" id="users-archive">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Archive Date</th>
                                <th class="text-center">Deleted By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('default-avatar.png') }}" 
                                             alt="Avatar" class="avatar" style="width: 32px; height: 32px; border-radius: 50%;">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td class="text-center">
                                        {{ $user->deleted_at->format('M d, Y g:i A') }}
                                        <div class="text-muted small">
                                            {{ $user->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($user->deletedBy)
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <span class="avatar avatar-xs rounded-circle bg-blue-lt">
                                                    {{ strtoupper(substr($user->deletedBy->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $user->deletedBy->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewUserModal{{ $user->id }}"
                                                    title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </button>
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    onclick="restoreUser('{{ $user->id }}')" 
                                                    title="Restore User">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-clockwise" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4.05 11a8 8 0 1 1 .5 4m-.5 5v-5h5"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="fas fa-archive text-muted" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <p class="empty-title">No archived users found</p>
                                            <p class="empty-subtitle text-muted">
                                                There are no archived user records in the system at this time.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($archivedUsers->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        {{ $archivedUsers->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- User Details Modal -->
        @foreach($archivedUsers as $user)
            <div class="modal modal-blur fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">User Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <div class="form-control-plaintext">{{ $user->name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="form-control-plaintext">{{ $user->email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <div class="form-control-plaintext">{{ ucfirst($user->role) }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Archived Date</label>
                                <div class="form-control-plaintext">{{ $user->deleted_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Archived Pets Table -->
        <div class="card" id="pets-archive">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th class="text-center">Pet Name</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Breed</th>
                                <th class="text-center">Archive Date</th>
                                <th class="text-center">Deleted By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedPets as $pet)
                                <tr>
                                    <td class="text-center">{{ $pet->name }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            @if($pet->user)
                                                <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                    {{ strtoupper(substr($pet->user->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $pet->user->name }}</span>
                                            @else
                                                <span class="avatar avatar-sm rounded-circle bg-secondary-lt">
                                                    <i class="fas fa-question"></i>
                                                </span>
                                                <span>Unknown Owner</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $pet->category }}</td>
                                    <td class="text-center">{{ $pet->breed }}</td>
                                    <td class="text-center">
                                        {{ $pet->deleted_at->format('M d, Y g:i A') }}
                                        <div class="text-muted small">
                                            {{ $pet->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($pet->deletedBy)
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <span class="avatar avatar-xs rounded-circle bg-blue-lt">
                                                    {{ strtoupper(substr($pet->deletedBy->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $pet->deletedBy->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewPetModal{{ $pet->id }}"
                                                    title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </button>
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    onclick="restorePet('{{ $pet->id }}')" 
                                                    title="Restore Pet">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="fas fa-archive text-muted" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <p class="empty-title">No archived pets found</p>
                                            <p class="empty-subtitle text-muted">
                                                There are no archived pet records in the system at this time.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $archivedPets->links() }}
            </div>
        </div>

        <!-- Archived Orders Table -->
        <div class="card" id="orders-archive" style="display: none;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th class="text-center">Archive Date</th>
                                <th class="text-center">Deleted By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedOrders as $order)
                                <tr>
                                    <td class="fw-bold text-blue">{{ $order->invoice_no }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($order->user)
                                                <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $order->user->name }}</span>
                                            @else
                                                <span class="avatar avatar-sm rounded-circle bg-secondary-lt">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                                <span>Walk-in Customer</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>₱{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->order_status_color }}-lt">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($order->deleted_at)
                                            {{ $order->deleted_at->format('M d, Y g:i A') }}
                                            <div class="text-muted small">
                                                {{ $order->deleted_at->diffForHumans() }}
                                            </div>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            @if($order->deletedBy)
                                                <span class="avatar avatar-xs rounded-circle bg-blue-lt">
                                                    {{ strtoupper(substr($order->deletedBy->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $order->deletedBy->name }}</span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-user-circle me-1"></i>
                                                    @if($order->deleted_by)
                                                        Deleted User (ID: {{ $order->deleted_by }})
                                                    @else
                                                        System
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewOrderModal{{ $order->id }}"
                                                    title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </button>
                                            <button class="btn btn-icon btn-outline-primary btn-sm" 
                                                    onclick="restoreOrder('{{ $order->id }}')" 
                                                    title="Restore Order">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="fas fa-archive text-muted" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <p class="empty-title">No archived orders found</p>
                                            <p class="empty-subtitle text-muted">
                                                There are no archived order records in the system at this time.
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

        <!-- Archived Appointments Table -->
        <div class="card" id="appointments-archive" style="display: none;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Pet Owner</th>
                                <th>Pet Name</th>
                                <th>Appointment Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th>Deleted By</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs me-2 rounded-circle bg-blue-lt">
                                                {{ strtoupper(substr($appointment->user->name ?? $appointment->owner_name, 0, 1)) }}
                                            </span>
                                            <span>{{ $appointment->user->name ?? $appointment->owner_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $appointment->pet_name }}</td>
                                    <td>{{ $appointment->appointment_date->format('M d, Y g:i A') }}</td>
                                    <td>
                                        @if(is_array($appointment->reason_for_visit))
                                            <ul class="list-unstyled mb-0">
                                                @foreach($appointment->reason_for_visit as $reason)
                                                    <li><small>• {{ $reason }}</small></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $appointment->reason_for_visit }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status_color }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $appointment->deleted_at->format('M d, Y g:i A') }}
                                        <div class="text-muted small">
                                            {{ $appointment->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($appointment->deletedBy)
                                            <div class="d-flex align-items-center justify-content-start gap-2">
                                                <span class="avatar avatar-xs rounded-circle bg-blue-lt">
                                                    {{ strtoupper(substr($appointment->deletedBy->name, 0, 1)) }}
                                                </span>
                                                <span>{{ $appointment->deletedBy->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-user-circle me-1"></i>
                                                System
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('appointments.view', $appointment->id) }}" 
                                               class="btn btn-icon btn-outline-primary btn-sm" 
                                               title="View Appointment">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 12a2 2 0 1 0 4 0"></path>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('appointments.restore', $appointment->id) }}"
                                               class="btn btn-icon btn-outline-success btn-sm"
                                               onclick="return confirm('Are you sure you want to restore this appointment?')"
                                               title="Restore Appointment">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-clockwise" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4.05 11a8 8 0 1 1 .5 4m-.5 5v-5h5"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="fas fa-archive text-muted" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <p class="empty-title">No archived appointments found</p>
                                            <p class="empty-subtitle text-muted">
                                                There are no archived appointment records in the system at this time.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if($archivedAppointments->hasPages())
                        <div class="card-footer d-flex align-items-center">
                            {{ $archivedAppointments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
@foreach($archivedOrders as $order)
    @include('orders.partials.archived-order-modal', ['order' => $order])
@endforeach

<!-- Add Pet View Modal -->
@foreach($archivedPets as $pet)
    <div class="modal modal-blur fade" id="viewPetModal{{ $pet->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pet Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pet Name</label>
                        <div class="form-control-plaintext">{{ $pet->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Owner</label>
                        <div class="form-control-plaintext">
                            {{ $pet->user ? $pet->user->name : ($pet->owner_name ?? 'Unknown Owner') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <div class="form-control-plaintext">{{ $pet->category }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Breed</label>
                        <div class="form-control-plaintext">{{ $pet->breed }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archived Date</label>
                        <div class="form-control-plaintext">{{ $pet->deleted_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@push('page-scripts')
<script>
// Add this function at the top of your script
function removeBackdrop() {
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => backdrop.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

document.addEventListener('DOMContentLoaded', function() {
    // Get all archive sections
    const petsArchive = document.getElementById('pets-archive');
    const ordersArchive = document.getElementById('orders-archive');
    const appointmentsArchive = document.getElementById('appointments-archive');
    const usersArchive = document.getElementById('users-archive');

    // Hide all sections except users initially
    petsArchive.style.display = 'none';
    ordersArchive.style.display = 'none';
    appointmentsArchive.style.display = 'none';
    usersArchive.style.display = 'block';  // Show users section by default

    function toggleArchives() {
        if (usersRadio.checked) {
            usersArchive.style.display = 'block';
            petsArchive.style.display = 'none';
            ordersArchive.style.display = 'none';
            appointmentsArchive.style.display = 'none';
        } else if (petsRadio.checked) {
            usersArchive.style.display = 'none';
            petsArchive.style.display = 'block';
            ordersArchive.style.display = 'none';
            appointmentsArchive.style.display = 'none';
        } else if (ordersRadio.checked) {
            usersArchive.style.display = 'none';
            petsArchive.style.display = 'none';
            ordersArchive.style.display = 'block';
            appointmentsArchive.style.display = 'none';
        } else if (appointmentsRadio.checked) {
            usersArchive.style.display = 'none';
            petsArchive.style.display = 'none';
            ordersArchive.style.display = 'none';
            appointmentsArchive.style.display = 'block';
        }
    }

    // Add event listeners for radio buttons
    const usersRadio = document.getElementById('users');
    const petsRadio = document.getElementById('pets');
    const ordersRadio = document.getElementById('orders');
    const appointmentsRadio = document.getElementById('appointments');

    usersRadio.addEventListener('change', toggleArchives);
    petsRadio.addEventListener('change', toggleArchives);
    ordersRadio.addEventListener('change', toggleArchives);
    appointmentsRadio.addEventListener('change', toggleArchives);

    // Call toggleArchives initially to set correct visibility
    toggleArchives();

    // Add click handlers for all eye buttons
    const viewButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove any existing backdrops before showing new modal
            removeBackdrop();
        });
    });

    // Add handlers for modal close buttons
    const closeButtons = document.querySelectorAll('.btn-close, [data-bs-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            removeBackdrop();
        });
    });

    // Handle ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            removeBackdrop();
        }
    });

    // Add restore function for appointments
    window.restoreAppointment = function(appointmentId) {
        if (confirm('Are you sure you want to restore this appointment?')) {
            fetch(`/appointments/${appointmentId}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to restore appointment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while restoring the appointment.');
            });
        }
    }
});

function restorePet(petId) {
    if (confirm('Are you sure you want to restore this pet?')) {
        fetch(`/pets/${petId}/restore`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                removeBackdrop();
                window.location.reload();
            } else {
                alert('Failed to restore pet. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restoring the pet.');
        });
    }
}

function restoreOrder(orderId) {
    if (confirm('Are you sure you want to restore this order?')) {
        fetch(`/orders/${orderId}/restore`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to restore order. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restoring the order: ' + error.message);
        });
    }
}

function restoreUser(userId) {
    if (confirm('Are you sure you want to restore this user?')) {
        fetch(`/users/${userId}/restore`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to restore user. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restoring the user.');
        });
    }
}

function triggerAutoBackup() {
    fetch('{{ route("backup.auto") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Backup created successfully!');
        } else {
            alert('Backup failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the backup.');
    });
}
</script>
@endpush

<style>
    .btn-group .btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* Users button states (Green) */
    .users-btn:hover, .users-btn:focus {
        background-color: rgba(47, 179, 68, 0.1) !important;
        border-color: #2FB344 !important;
        color: #2FB344 !important;
    }
    
    .users-btn.active, input[name="archive-type"]:checked + .users-btn {
        background-color: #2FB344 !important;
        border-color: #2FB344 !important;
        color: white !important;
    }

    /* Pets button states (Blue) */
    .pets-btn:hover, .pets-btn:focus {
        background-color: rgba(0, 84, 166, 0.1) !important;
        border-color: #0054a6 !important;
        color: #0054a6 !important;
    }
    
    .pets-btn.active, input[name="archive-type"]:checked + .pets-btn {
        background-color: #0054a6 !important;
        border-color: #0054a6 !important;
        color: white !important;
    }

    /* Orders button states (Orange) */
    .orders-btn:hover, .orders-btn:focus {
        background-color: rgba(247, 103, 7, 0.1) !important;
        border-color: #F76707 !important;
        color: #F76707 !important;
    }
    
    .orders-btn.active, input[name="archive-type"]:checked + .orders-btn {
        background-color: #F76707 !important;
        border-color: #F76707 !important;
        color: white !important;
    }

    /* Appointments button states (Sky Blue) */
    .appointments-btn:hover, .appointments-btn:focus {
        background-color: rgba(66, 153, 225, 0.1) !important;
        border-color: #4299E1 !important;
        color: #4299E1 !important;
    }
    
    .appointments-btn.active, input[name="archive-type"]:checked + .appointments-btn {
        background-color: #4299E1 !important;
        border-color: #4299E1 !important;
        color: white !important;
    }

    /* Badge styles when button is not active */
    .users-btn .badge {
        background-color: rgba(47, 179, 68, 0.1) !important;
        color: #2FB344 !important;
    }

    .pets-btn .badge {
        background-color: rgba(0, 84, 166, 0.1) !important;
        color: #0054a6 !important;
    }

    .orders-btn .badge {
        background-color: rgba(247, 103, 7, 0.1) !important;
        color: #F76707 !important;
    }

    .appointments-btn .badge {
        background-color: rgba(66, 153, 225, 0.1) !important;
        color: #4299E1 !important;
    }

    /* Badge styles when button is active */
    input[name="archive-type"]:checked + .users-btn .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    input[name="archive-type"]:checked + .pets-btn .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    input[name="archive-type"]:checked + .orders-btn .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    input[name="archive-type"]:checked + .appointments-btn .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    .avatar {
        border: 2px solid white;
        box-shadow: 0 0 0 2px rgba(0,0,0,0.1);
    }

    .btn-outline-primary {
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }

    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }

    .empty {
        padding: 3rem;
    }

    .empty-icon {
        margin-bottom: 1rem;
    }

    .empty-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-subtitle {
        color: #6c757d;
    }

    /* Improve pagination styling */
    .pagination {
        margin: 0;
        padding: 1rem 0;
    }

    .page-link {
        border-radius: 4px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background-color: #0054a6;
        color: white;
        border-color: #0054a6;
    }

    .page-item.active .page-link {
        background-color: #0054a6;
        border-color: #0054a6;
    }

    /* Animation for status changes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table tbody tr {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Improve responsive behavior */
    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 4px !important;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection 