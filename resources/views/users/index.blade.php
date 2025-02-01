@extends('layouts.tabler')

@section('content')
<style>
    .modal-open .modal {
        background: rgba(0, 0, 0, 0.5);
    }
    
    .role-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }
    
    .modal-dialog-scrollable {
        margin-top: 60px; /* Prevents overlap with header */
    }
    
    .modal-dialog {
        display: flex;
        align-items: center;
        min-height: calc(100% - 60px); /* Accounts for header */
        margin: 30px auto;
    }
    
    .user-profile-modal {
        max-height: 80vh;
        overflow-y: auto;
    }
    
    .user-profile-modal::-webkit-scrollbar {
        width: 6px;
    }
    
    .user-profile-modal::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .user-profile-modal::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .modal-backdrop {
        display: none !important;
    }
    
    .activity-item {
        padding: 0.75rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }
    
    .activity-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .modal-dialog {
        max-width: 900px;
    }
    
    .tab-content {
        min-height: 300px;
    }
    
    .table-responsive {
        margin: 0;
        border-radius: 4px;
    }
    
    .empty {
        padding: 3rem;
        text-align: center;
    }
    
    .empty-icon {
        margin-bottom: 1rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .badge {
        font-weight: 500;
    }
    
    .avatar {
        object-fit: cover;
    }
    
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .col-md-4.border-end {
            border: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            margin-bottom: 1rem;
        }
    }
    
    .modal-dialog {
        margin: 1.75rem auto;
    }
    
    .modal-content {
        max-height: calc(100vh - 3.5rem);
    }
    
    .modal-body {
        overflow-y: auto;
        padding: 0 !important;
    }
    
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
    }
    
    .avatar {
        object-fit: cover;
    }
    
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .table-responsive {
        margin: 0;
        border-radius: 4px;
    }
    
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }
        
        .col-md-3.border-end {
            border: none !important;
            margin-bottom: 1rem;
        }
    }
    
    .card.shadow-sm {
        border: none;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    
    .card.shadow-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    }
    
    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 8px;
    }
    
    .text-muted {
        font-size: 0.875rem;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .text-dark {
        color: #1e293b !important;
    }
    
    .border-end {
        border-color: #e2e8f0 !important;
    }
    
    @media (max-width: 768px) {
        .col-md-3.border-end {
            border: none !important;
            margin-bottom: 1rem;
        }
        
        .card.shadow-sm {
            margin-bottom: 1rem;
        }
    }
    
    .role-btn {
        padding-left: 1rem !important;
        transition: all 0.3s ease;
        border-radius: 4px !important;
        margin: 0 2px;
        position: relative;
        overflow: hidden;
    }
    
    .role-btn:hover {
        transform: translateY(-1px);
    }
    
    .role-btn.active {
        font-weight: 500;
    }
    
    .role-indicator {
        transition: all 0.3s ease;
    }
    
    .role-btn:hover .role-indicator {
        height: 100%;
        opacity: 0.15;
        width: 100%;
    }
    
    .role-btn.active .role-indicator {
        height: 100%;
        opacity: 0.1;
        width: 100%;
    }

    /* New styles for role buttons */
    .role-btn[data-role="admin"] {
        background-color: rgba(214, 57, 57, 0.1);
        border-color: #d63939;
        color: #d63939;
    }
    
    .role-btn[data-role="admin"]:hover {
        background-color: rgba(214, 57, 57, 0.2);
    }
    
    .role-btn[data-role="staff"],
    .role-btn[data-role="sub_admin"] {
        background-color: rgba(253, 126, 20, 0.1);
        border-color: #fd7e14;
        color: #fd7e14;
    }
    
    .role-btn[data-role="staff"]:hover,
    .role-btn[data-role="sub_admin"]:hover {
        background-color: rgba(253, 126, 20, 0.2);
    }
    
    .role-btn[data-role="pet_owner"] {
        background-color: rgba(47, 179, 68, 0.1);
        border-color: #2fb344;
        color: #2fb344;
    }
    
    .role-btn[data-role="pet_owner"]:hover {
        background-color: rgba(47, 179, 68, 0.2);
    }
    
    .role-btn.active[data-role="admin"] {
        background-color: #d63939;
        color: white;
    }
    
    .role-btn.active[data-role="staff"],
    .role-btn.active[data-role="sub_admin"] {
        background-color: #fd7e14;
        color: white;
    }
    
    .role-btn.active[data-role="pet_owner"] {
        background-color: #2fb344;
        color: white;
    }
    
    .card {
        transition: all 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-lg {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        border-radius: 8px;
    }
    
    .btn-primary {
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(var(--primary-rgb), 0.2);
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            padding: 0.5rem;
        }
        
        .card-body {
            padding: 1rem !important;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                @include('partials._page_header', [
                    'title' => __('User Management'),
                    'section' => 'OVERVIEW'
                ])
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="btn-group" id="roleToggle">
                            @foreach($roles as $key => $label)
                                <button type="button"
                                   class="btn role-btn {{ request()->query('role', 'all') === $key ? 'active' : '' }}"
                                   data-role="{{ $key }}">
                                    <span class="ms-1">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" onclick="exportSelected()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"></path>
                                    <path d="M7 11l5 5l5-5"></path>
                                    <path d="M12 4l0 12"></path>
                                </svg>
                                Export Selected
                            </button>
                            <a href="{{ route('user-management.create') }}" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M16 19h6"></path>
                                    <path d="M19 16v6"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                </svg>
                                Add User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Users</h3>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="w-1">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>ID</th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M15 8h.01"></path>
                                            <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                                            <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                                        </svg>
                                        Photo
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                        Name
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                            <path d="M3 7l9 6l9 -6"></path>
                                        </svg>
                                        Email
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                        Phone
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2"></path>
                                            <path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        </svg>
                                        Role
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 5h2"></path>
                                            <path d="M19 12c-.667 5.333 -2.333 8 -5 8h-4c-2.667 0 -4.333 -2.667 -5 -8"></path>
                                            <path d="M11 16c0 .667 .333 1 1 1s1 -.333 1 -1h-2z"></path>
                                            <path d="M12 18v2"></path>
                                            <path d="M10 11v.01"></path>
                                            <path d="M14 11v.01"></path>
                                            <path d="M5 4l6 .97l6-.97l2 4l-4 2l-8 0l-4-2z"></path>
                                        </svg>
                                        Pets
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M10 16h4"></path>
                                            <path d="M12 14v4"></path>
                                        </svg>
                                        Created
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M12 14l1 2"></path>
                                        </svg>
                                        Updated
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                        </svg>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr style="cursor: pointer;">
                                        <td class="w-1" onclick="event.stopPropagation()">
                                            <input type="checkbox" class="form-check-input user-select" value="{{ $user->id }}">
                                        </td>
                                        <td onclick="event.stopPropagation()">{{ $user->id }}</td>
                                        <td onclick="showUserDetails({{ $user->id }})">
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('PetFurme/default-avatar.png') }}" 
                                                 alt="Avatar" class="avatar" style="width: 32px; height: 32px; border-radius: 50%;">
                                        </td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->name }}</td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->email }}</td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->phone ?? '—' }}</td>
                                        <td onclick="showUserDetails({{ $user->id }})">
                                            @php
                                                $roleColors = [
                                                    'admin' => ['bg' => '#d63939', 'text' => '#fff'],
                                                    'staff' => ['bg' => '#fd7e14', 'text' => '#fff'],
                                                    'sub_admin' => ['bg' => '#fd7e14', 'text' => '#fff'],
                                                    'pet_owner' => ['bg' => '#2fb344', 'text' => '#fff']
                                                ];
                                                $roleColor = $roleColors[$user->role] ?? ['bg' => '#666', 'text' => '#fff'];
                                            @endphp
                                            <span class="badge" style="
                                                background-color: {{ $roleColor['bg'] }}; 
                                                color: {{ $roleColor['text'] }}; 
                                                padding: 5px 10px;
                                                font-weight: 500;
                                                display: inline-flex;
                                                align-items: center;
                                                gap: 5px;
                                            ">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h2"></path>
                                                    <path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z"></path>
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                </svg>
                                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                            </span>
                                        </td>
                                        <td onclick="showUserDetails({{ $user->id }})" class="text-center p-3">
                                            @if($user->pets_count > 0)
                                                <span class="badge bg-blue fs-5 d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px; color: white; padding: 2px;">
                                                    {{ $user->pets_count }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary fs-6 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 25px; color: white; padding: 2px;">
                                                    None
                                                </span>
                                            @endif
                                        </td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}</td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->updated_at ? $user->updated_at->format('Y-m-d') : '—' }}</td>
                                        <td onclick="event.stopPropagation()">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-icon btn-warning btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385-8.415z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('user-management.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($users as $user)
    <div class="modal modal-lg fade" id="userModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('PetFurme/default-avatar.png') }}" 
                                 alt="Avatar" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: none; box-shadow: none;">
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-bold">{{ $user->name }}</h5>
                            <div class="text-white-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                    <path d="M3 7l9 6l9 -6"></path>
                                </svg>
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        @php
                            $roleColors = [
                                'admin' => ['bg' => '#d63939', 'lt' => 'red'],
                                'staff' => ['bg' => '#fd7e14', 'lt' => 'orange'],
                                'sub_admin' => ['bg' => '#fd7e14', 'lt' => 'orange'],
                                'pet_owner' => ['bg' => '#2fb344', 'lt' => 'green']
                            ];
                            $roleColor = $roleColors[$user->role] ?? ['bg' => '#666', 'lt' => 'secondary'];
                            
                            $roleLabels = [
                                'admin' => 'ADMIN',
                                'staff' => 'SUB-ADMIN',
                                'sub_admin' => 'SUB-ADMIN',
                                'pet_owner' => 'PET OWNER'
                            ];
                        @endphp
                        <span class="badge fs-6 bg-{{ $roleColor['lt'] }}-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h2"></path>
                                <path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            </svg>
                            {{ $roleLabels[$user->role] ?? ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left Sidebar -->
                        <div class="col-md-3 border-end" style="max-width: 250px;">
                            <div class="p-3">
                                <!-- Contact Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <span class="bg-primary-lt avatar me-3 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                    </span>
                                    <div>
                                        <h4 class="mb-1 text-muted">Contact</h4>
                                        <div class="text-dark fw-medium">{{ $user->phone ?? 'Not provided' }}</div>
                                    </div>
                                </div>

                                <!-- Address Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <span class="bg-green-lt avatar me-3 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 11.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 0v4.5M9 9a3 3 0 1 0 6 0a3 3 0 0 0-6 0"></path>
                                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"></path>
                                        </svg>
                                    </span>
                                    <div>
                                        <h4 class="mb-1 text-muted">Address</h4>
                                        <div class="text-dark fw-medium">{{ $user->address ?? 'Not provided' }}</div>
                                    </div>
                                </div>

                                <!-- Member Since Info -->
                                <div class="d-flex align-items-center">
                                    <span class="bg-yellow-lt avatar me-3 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z"></path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                        </svg>
                                    </span>
                                    <div>
                                        <h4 class="mb-1 text-muted">Member Since</h4>
                                        <div class="text-dark fw-medium">{{ $user->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-md-9">
                            <div class="p-3">
                                <!-- Stats Summary -->
                                <div class="row g-2 mb-4">
                                    @include('partials._user_stats', ['user' => $user])
                                </div>

                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs nav-fill mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pets-{{ $user->id }}" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 5h2"></path>
                                                <path d="M19 12c-.667 5.333-2.333 8-5 8h-4c-2.667 0-4.333-2.667-5-8"></path>
                                                <path d="M11 16c0 .667.333 1 1 1s1-.333 1-1h-2z"></path>
                                                <path d="M12 18v2"></path>
                                                <path d="M10 11v.01"></path>
                                                <path d="M14 11v.01"></path>
                                                <path d="M5 4l6 .97l6-.97l2 4l-4 2l-8 0l-4-2z"></path>
                                            </svg>
                                            Pets
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#appointments-{{ $user->id }}" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M4 5m0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2z"></path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h16"></path>
                                                <path d="M8 15h2"></path>
                                                <path d="M14 15h2"></path>
                                                <path d="M8 19h2"></path>
                                                <path d="M14 19h2"></path>
                                            </svg>
                                            Appointments
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders-{{ $user->id }}" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 5h2l.5 4.5m1.5 4.5h12"></path>
                                                <path d="M17 17h2a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-14a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2"></path>
                                                <path d="M9 17l1 4"></path>
                                                <path d="M14 17l-1 4"></path>
                                            </svg>
                                            Orders
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- Pets Tab -->
                                    <div class="tab-pane fade show active" id="pets-{{ $user->id }}">
                                        @if($user->pets->count() > 0)
                                            <div class="row g-3">
                                                @foreach($user->pets as $pet)
                                                    <div class="col-md-6">
                                                        <div class="card h-100">
                                                            <div class="card-body p-4">
                                                                <div class="d-flex flex-column">
                                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                                        <div class="d-flex gap-3">
                                                                            <img src="{{ $pet->photo ? asset('storage/' . $pet->photo) : asset('images/default-pet.png') }}" 
                                                                                 class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                                                            <div>
                                                                                <h4 class="mb-1">{{ $pet->name }}</h4>
                                                                                <div class="text-muted">{{ $pet->breed }}</div>
                                                                                <div class="d-flex gap-2 mt-2">
                                                                                    <span class="badge bg-blue-lt">{{ $pet->type }}</span>
                                                                                    <span class="badge bg-green-lt">
                                                                                        {{ $pet->age }} {{ Str::plural('month', $pet->age) }} old
                                                                                    </span>
                                                                                    <span class="badge bg-purple-lt">{{ ucfirst($pet->gender) }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <a href="{{ route('appointments.create', ['pet_id' => $pet->id, 'owner_id' => $user->id]) }}" 
                                                                       class="btn btn-primary btn-lg mt-2 w-100">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                                                            <path d="M16 3v4"></path>
                                                                            <path d="M8 3v4"></path>
                                                                            <path d="M4 11h16"></path>
                                                                            <path d="M10 16h4"></path>
                                                                            <path d="M12 14v4"></path>
                                                                        </svg>
                                                                        Schedule Appointment
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sad" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0-18 0"></path>
                                                        <path d="M9 10h.01"></path>
                                                        <path d="M15 10h.01"></path>
                                                        <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                                                    </svg>
                                                </div>
                                                <p class="empty-title">No pets found</p>
                                                <p class="empty-subtitle text-muted">
                                                    This user hasn't registered any pets yet.
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Appointments Tab -->
                                    <div class="tab-pane fade" id="appointments-{{ $user->id }}">
                                        @if($user->appointments->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date & Time</th>
                                                            <th>Service</th>
                                                            <th>Pet</th>
                                                            <th>Notes</th>
                                                            <th class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user->appointments->take(5) as $appointment)
                                                            <tr>
                                                                <td class="text-nowrap">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="bg-blue-lt avatar avatar-sm me-2 d-flex align-items-center justify-content-center">
                                                                            {{ $appointment->appointment_date ? Carbon\Carbon::parse($appointment->appointment_date)->format('d') : '--' }}
                                                                        </span>
                                                                        <div>
                                                                            <div class="font-weight-medium">
                                                                                {{ $appointment->appointment_date ? Carbon\Carbon::parse($appointment->appointment_date)->format('M Y') : 'No date' }}
                                                                            </div>
                                                                            <div class="text-muted small">
                                                                                {{ $appointment->appointment_time ? Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'No time' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-truncate" style="max-width: 150px;">
                                                                        @php
                                                                            $reason = is_string($appointment->reason_for_visit) ? 
                                                                                $appointment->reason_for_visit : 
                                                                                (is_array($appointment->reason_for_visit) ? 
                                                                                    implode(', ', $appointment->reason_for_visit) : 
                                                                                    'No reason specified');
                                                                        @endphp
                                                                        {{ $reason }}
                                                                        @if($appointment->other_reason)
                                                                            <div class="text-muted small">{{ $appointment->other_reason }}</div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-truncate" style="max-width: 100px;">
                                                                        {{ $appointment->pet_name ?? 'No pet name' }}
                                                                        <div class="text-muted small">{{ $appointment->pet_type ?? 'No type' }}</div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-truncate" style="max-width: 200px;">
                                                                        {{ $appointment->notes ?: '—' }}
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    @php
                                                                        $statusColors = [
                                                                            'pending' => 'warning',
                                                                            'confirmed' => 'info',
                                                                            'completed' => 'success',
                                                                            'cancelled' => 'danger'
                                                                        ];
                                                                        $statusColor = $statusColors[$appointment->status] ?? 'secondary';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusColor }}-lt">
                                                                        {{ ucfirst($appointment->status ?? 'Unknown') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-off" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M19 4h-1m-4 0h-6a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2"></path>
                                                        <path d="M16 2v4"></path>
                                                        <path d="M8 2v4"></path>
                                                        <path d="M4 10h16"></path>
                                                        <path d="M3 3l18 18"></path>
                                                    </svg>
                                                </div>
                                                <p class="empty-title">No appointments found</p>
                                                <p class="empty-subtitle text-muted">
                                                    This user hasn't scheduled any appointments yet.
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Orders Tab -->
                                    <div class="tab-pane fade" id="orders-{{ $user->id }}">
                                        @if($user->orders->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order Info</th>
                                                            <th>Items</th>
                                                            <th>Payment Method</th>
                                                            <th class="text-end">Amount</th>
                                                            <th class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user->orders->take(5) as $order)
                                                            <tr>
                                                                <td>
                                                                    <div class="text-truncate" style="max-width: 150px;">
                                                                        <div class="font-weight-medium">#{{ $order->invoice_no ?? 'No invoice' }}</div>
                                                                        <div class="text-muted small">
                                                                            Ref: {{ $order->reference ?? 'No reference' }}<br>
                                                                            {{ $order->created_at ? $order->created_at->format('M d, Y h:i A') : 'No date' }}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                                                        <span class="badge bg-blue-lt">
                                                                            {{ $order->total_products ?? 0 }} items
                                                                        </span>
                                                                        @if($order->note)
                                                                            <div class="text-muted small mt-1">{{ $order->note }}</div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-purple-lt">
                                                                        {{ ucfirst($order->payment_method ?? 'Not specified') }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <div class="text-dark">₱{{ number_format($order->total ?? 0, 2) }}</div>
                                                                    @if($order->is_paid)
                                                                        <div class="text-muted small">
                                                                            <span class="badge bg-success-lt">
                                                                                Paid {{ $order->paid_at ? Carbon\Carbon::parse($order->paid_at)->format('M d, Y') : '' }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                    @if($order->payment_note)
                                                                        <div class="text-muted small">{{ $order->payment_note }}</div>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @php
                                                                        $orderStatusColors = [
                                                                            'pending' => 'warning',
                                                                            'processing' => 'info',
                                                                            'completed' => 'success',
                                                                            'cancelled' => 'danger'
                                                                        ];
                                                                        $orderStatusColor = $orderStatusColors[$order->order_status] ?? 'secondary';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $orderStatusColor }}-lt">
                                                                        {{ ucfirst($order->order_status ?? 'Unknown') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-off" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0"></path>
                                                        <path d="M17 17h-11v-14h-2"></path>
                                                        <path d="M9.239 5.231l10.761 .769l-1 7h-2m-4 0h-7"></path>
                                                        <path d="M3 3l18 18"></path>
                                                    </svg>
                                                </div>
                                                <p class="empty-title">No orders found</p>
                                                <p class="empty-subtitle text-muted">
                                                    This user hasn't placed any orders yet.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="btn-list">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385-8.415z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    // Updated modal handling
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                document.body.style.overflow = 'hidden';
            });
            
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.style.overflow = '';
                document.body.classList.remove('modal-open');
                const backdrops = document.getElementsByClassName('modal-backdrop');
                while(backdrops[0]) {
                    backdrops[0].parentNode.removeChild(backdrops[0]);
                }
            });
        });
    });

    function exportSelected(format) {
        const selectedUsers = Array.from(document.querySelectorAll('.user-select:checked')).map(cb => cb.value);
        
        if (selectedUsers.length === 0) {
            alert('Please select at least one user to export');
            return;
        }

        // Create a form to submit the selected users
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('user-management.export-selected') }}`;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add format
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);

        // Add selected users
        const usersInput = document.createElement('input');
        usersInput.type = 'hidden';
        usersInput.name = 'users';
        usersInput.value = JSON.stringify(selectedUsers);
        form.appendChild(usersInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Add select all functionality
    document.querySelector('#select-all').addEventListener('change', function() {
        document.querySelectorAll('.user-select').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    function showUserDetails(userId) {
        const modal = new bootstrap.Modal(document.getElementById(`userModal${userId}`));
        modal.show();
    }

    // Prevent checkbox clicks from triggering modal
    document.querySelectorAll('.user-select, .btn-icon').forEach(element => {
        element.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });

    // Role filtering with AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const roleButtons = document.querySelectorAll('.role-btn');
        const tableBody = document.querySelector('table tbody');
        
        roleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                roleButtons.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const role = this.dataset.role;
                
                // Show loading state
                tableBody.style.opacity = '0.5';
                
                // Make AJAX request
                fetch(`{{ route('user-management.index') }}?role=${role}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Create a temporary element to parse the HTML
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    
                    // Extract the table body content
                    const newTableBody = temp.querySelector('table tbody');
                    
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }
                    
                    // Update URL without page reload
                    window.history.pushState({}, '', `{{ route('user-management.index') }}?role=${role}`);
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Remove loading state
                    tableBody.style.opacity = '1';
                });
            });
        });
    });
</script>
@endpush
@endsection
