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
        overflow-x: auto;
        margin: 0;
        border-radius: 4px;
        max-width: none;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
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
    
    .table {
        width: 100%;
        margin-bottom: 0;
        border: 1px solid rgba(98, 105, 118, 0.16);
        min-width: auto;
    }
    
    .table thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid rgba(98, 105, 118, 0.16);
        padding: 1rem 0.75rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(98, 105, 118, 0.08);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 0;
    }
    
    .table tbody tr:hover {
        background-color: rgba(98, 105, 118, 0.02);
    }
    
    .table th.w-1,
    .table td.w-1 {
        width: 1%;
        padding-right: 1rem;
    }
    
    .table td:nth-child(2) {
        width: 60px;
        min-width: auto;
    }
    
    .table td:nth-child(3) {
        width: 50px;
        min-width: auto;
    }
    
    .table td:nth-child(4) {
        width: 120px;
        min-width: auto;
    }
    
    .table td:nth-child(5) {
        width: 180px;
        min-width: auto;
    }
    
    .table td:nth-child(6) {
        width: 120px;
        min-width: auto;
    }
    
    .table td:nth-child(7) {
        width: 100px;
        min-width: auto;
    }
    
    .table td:nth-child(8) {
        width: 80px;
        min-width: auto;
    }
    
    .table td:nth-child(9) {
        width: 100px;
        min-width: auto;
    }
    
    .table td:nth-child(10) {
        width: 140px;
        min-width: auto;
    }
    
    .table td:nth-child(11), 
    .table td:nth-child(12) {
        width: 100px;
        min-width: auto;
    }
    
    .table td:nth-child(13) {
        width: 90px;
        min-width: auto;
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    .card-header {
        border-bottom: none;
        background-color: transparent;
        padding: 1.5rem 1.5rem 1rem;
    }
    
    .role-badge {
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.25em 0.75em;
        border-radius: 50rem;
    }
    
    .container-xl {
        max-width: 100%;
        padding: 0 1.5rem;
    }
    
    @media (max-width: 1200px) {
        .table {
            min-width: auto;
        }
        
        .container-xl {
            padding: 0 1rem;
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

    /* Add tooltip for truncated content */
    .table td[title] {
        cursor: help;
    }

    /* Add these styles to your existing CSS */
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25em 0.75em;
    }

    .avatar-xs {
        width: 24px;
        height: 24px;
    }

    .table td .text-wrap {
        word-break: break-word;
    }

    /* Tooltip styles */
    [title] {
        position: relative;
        cursor: help;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    .table-responsive {
        margin: 0;
        border-radius: 4px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Ensure consistent icon sizes */
    .icon {
        width: 16px;
        height: 16px;
    }

    /* Status badge adjustments */
    .badge.bg-secondary-lt {
        background-color: rgba(99, 99, 99, 0.1) !important;
        color: #636363 !important;
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
            @if(request()->query('role') === 'pet_owner')
                <!-- Remove the entire card with verification filter -->
            @endif

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
                        
                        <div class="d-flex gap-2 align-items-center">
                            @if(request()->query('role') === 'pet_owner')
                                <div class="btn-group me-2">
                                    <button type="button" class="btn btn-outline-secondary active" data-credentials="all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                        All Users
                                    </button>
                                    <button type="button" class="btn btn-outline-success" data-credentials="complete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg>
                                        Complete
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" data-credentials="incomplete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                            <path d="M12 8v4"></path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                        Incomplete
                                    </button>
                                </div>
                            @endif
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
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="w-1">
                                        <input type="checkbox" id="select-all">
                                    </th>
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
                                        User Details
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
                                            <path d="M19 12c-.667 5.333 -2.333 8-5 8h-4c-2.667 0 -4.333 -2.667 -5 -8"></path>
                                            <path d="M11 16c0 .667 .333 1 1 1s1 -.333 1 -1h-2z"></path>
                                            <path d="M12 18v2"></path>
                                            <path d="M10 11v.01"></path>
                                            <path d="M14 11v.01"></path>
                                            <path d="M5 4l6 .97l6-.97l2 4l-4 2l-8 0l-4-2z"></path>
                                        </svg>
                                        Pets
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M9 14l2 2l4 -4"></path>
                                        </svg>
                                        Credentials
                                    </th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                            <path d="M15 19l2 2l4 -4"></path>
                                        </svg>
                                        Verification
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
                                        <td onclick="showUserDetails({{ $user->id }})">
                                            <img src="@if($user->photo)data:image/jpeg;base64,{{ base64_encode($user->photo) }}@else{{ $user->photo_url ?? asset('images/default-avatar.png') }}@endif" 
                                                 alt="{{ $user->name }}'s photo"
                                                 class="avatar avatar-sm">
                                        </td>
                                        <td onclick="showUserDetails({{ $user->id }})">
                                            <div class="d-flex flex-column">
                                                <div class="font-weight-medium">{{ $user->name }}</div>
                                                <div class="text-muted small">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                                            <path d="M3 7l9 6l9 -6"></path>
                                                        </svg>
                                                        {{ $user->email }}
                                                    </div>
                                                    @if($user->phone)
                                                        <div class="d-flex align-items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                                            </svg>
                                                            {{ $user->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
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
                                        <td onclick="showUserDetails({{ $user->id }})">
                                            @if($user->complete_credentials)
                                                <span class="badge bg-success text-white">Complete</span>
                                            @else
                                                <span class="badge bg-warning text-white">Incomplete</span>
                                            @endif
                                        </td>
                                        <td onclick="event.stopPropagation()">
                                            @if($user->verified_by)
                                                <form action="{{ route('user-management.verify', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex align-items-center gap-2" role="button" 
                                                         onclick="if(confirm('Are you sure you want to remove verification from this user?')) { this.closest('form').submit(); }">
                                                        <span class="badge bg-azure-lt d-flex align-items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            Verified
                                                        </span>
                                                        <span class="text-azure small d-flex align-items-center gap-1" title="Verified by">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                                <path d="M15 19l2 2l4 -4"></path>
                                                            </svg>
                                                            {{ App\Models\User::find($user->verified_by)->name ?? 'Unknown' }}
                                                        </span>
                                                    </div>
                                                </form>
                                            @else
                                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sub_admin')
                                                    <form action="{{ route('user-management.verify', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-azure btn-pill btn-sm d-flex align-items-center gap-2 px-3" 
                                                                onclick="return confirm('Are you sure you want to verify this user?')"
                                                                style="background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                                <path d="M15 19l2 2l4 -4"></path>
                                                            </svg>
                                                            Verify User
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-yellow d-flex align-items-center gap-1" style="width: fit-content;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                            <path d="M12 7v5l3 3"></path>
                                                        </svg>
                                                        Pending Verification
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td onclick="showUserDetails({{ $user->id }})">{{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}</td>
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
                                                            <path d="M5 7l1 12a2 2 0 0 1 2 2h8a2 2 0 0 1 2 -2l1 -12"></path>
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
    <!-- Existing user modal -->
    <div class="modal modal-lg fade" id="userModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width: 1200px; width: 95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="modal-content" style="min-height: 85vh; max-height: 85vh;">
                <div class="modal-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="@if($user->photo)data:image/jpeg;base64,{{ base64_encode($user->photo) }}@else{{ $user->photo_url ?? asset('images/default-avatar.png') }}@endif" 
                                 alt="{{ $user->name }}'s photo"
                                 class="avatar avatar-sm">
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
                
                <div class="modal-body p-0" style="overflow-y: auto;">
                    <div class="row g-0" style="height: calc(85vh - 130px);">
                        <!-- Left sidebar -->
                        <div class="col-md-3 border-end" style="max-width: 250px; height: 100%; overflow-y: auto;">
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

                        <!-- Main content -->
                        <div class="col-md-9" style="height: 100%; overflow-y: auto;">
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
                                                <path d="M19 12c-.667 5.333-2.333 8-5 8h-4c-2.667 0 -4.333 -2.667 -5 -8"></path>
                                                <path d="M11 16c0 .667.333 1 1 1s1 -.333 1 -1h-2z"></path>
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
                                                                            <span class="avatar avatar-xl avatar-rounded border-white border-3 me-3" 
                                                                                  style="background-image: url({{ $pet->photo_data 
                                                                                      ? $pet->photo_data 
                                                                                      : ($pet->photo ? Storage::url($pet->photo) : asset('images/default-pet.png')) }})"
                                                                                  data-debug="{{ $pet->photo_data ? 'Has photo_data' : ($pet->photo ? 'Has photo path' : 'Using default') }}">
                                                                            </span>
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
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
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
                                                            <th style="width: 20%">Date & Time</th>
                                                            <th style="width: 20%">Service</th>
                                                            <th style="width: 15%">Pet</th>
                                                            <th style="width: 25%">Notes</th>
                                                            <th style="width: 20%" class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user->appointments->take(5) as $appointment)
                                                            @php
                                                                $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                                                                $isPast = $appointmentDate->isPast();
                                                                $status = $appointment->status;
                                                                
                                                                // Enhanced status logic
                                                                if ($isPast) {
                                                                    if ($status === 'pending') {
                                                                        $status = 'expired';
                                                                    } elseif ($status === 'confirmed') {
                                                                        $status = 'completed';
                                                                    }
                                                                }
                                                                
                                                                // Define status colors, icons, and descriptions
                                                                $statusConfig = [
                                                                    'pending' => [
                                                                        'color' => 'warning',
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M12 7v5l3 3"></path></svg>',
                                                                        'description' => 'Awaiting confirmation'
                                                                    ],
                                                                    'confirmed' => [
                                                                        'color' => 'info',
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"></path></svg>',
                                                                        'description' => 'Scheduled for ' . $appointmentDate->format('M d, Y')
                                                                    ],
                                                                    'completed' => [
                                                                        'color' => 'success',
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check-double" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M11.5 21a9.5 9.5 0 1 0 0 -19a9.5 9.5 0 0 0 0 19z"></path><path d="M9 12l2 2l4 -4"></path></svg>',
                                                                        'description' => 'Completed on ' . $appointmentDate->format('M d, Y')
                                                                    ],
                                                                    'cancelled' => [
                                                                        'color' => 'danger',
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>',
                                                                        'description' => 'Cancelled'
                                                                    ],
                                                                    'expired' => [
                                                                        'color' => 'secondary',
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v1"></path><path d="M12 12v.01"></path><path d="M12 12l-3 -3"></path><path d="M19.121 19.121a9 9 0 1 1 -12.725 -12.725"></path><path d="M3 3l18 18"></path></svg>',
                                                                        'description' => 'Expired on ' . $appointmentDate->format('M d, Y')
                                                                    ]
                                                                ];
                                                            @endphp
                                                            <tr>
                                                                <!-- Date & Time Column -->
                                                                <td>
                                                                    <div class="d-flex flex-column">
                                                                        <div class="text-dark">
                                                                            {{ $appointment->appointment_date ? Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'No date' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $appointment->appointment_time ? Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : '' }}
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <!-- Service Column -->
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        @php
                                                                            $serviceTypeColor = match($appointment->service_type) {
                                                                                'Checkup' => 'blue',
                                                                                'Vaccination' => 'green',
                                                                                'Surgery' => 'red',
                                                                                'Grooming' => 'purple',
                                                                                default => 'azure'
                                                                            };
                                                                        @endphp
                                                                        <span class="avatar avatar-xs bg-{{ $serviceTypeColor }}-lt">
                                                                            @switch($appointment->service_type)
                                                                                @case('Checkup')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                                                                        <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                                                                        <path d="M11 3v2" />
                                                                                        <path d="M6 3v2" />
                                                                                        <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Vaccination')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vaccine" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M17 3l4 4" />
                                                                                        <path d="M19 5l-4.5 4.5" />
                                                                                        <path d="M11.5 6.5l6 6" />
                                                                                        <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5" />
                                                                                        <path d="M7.5 12.5l1.5 1.5" />
                                                                                        <path d="M10.5 9.5l1.5 1.5" />
                                                                                        <path d="M3 21l3 -3" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Surgery')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-emergency-bed" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M16 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                        <path d="M8 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                                        <path d="M4 8l2.1 2.8a3 3 0 0 0 2.4 1.2h11.5" />
                                                                                        <path d="M10 6h4" />
                                                                                        <path d="M12 4v4" />
                                                                                    </svg>
                                                                                    @break
                                                                                @case('Grooming')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cut" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M7 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                                        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                                        <path d="M9.15 14.85l8.85 -8.85" />
                                                                                        <path d="M6 4l8.85 8.85" />
                                                                                    </svg>
                                                                                    @break
                                                                                @default
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z" />
                                                                                    </svg>
                                                                            @endswitch
                                                                        </span>
                                                                        <div class="text-truncate" style="max-width: 150px;">
                                                                            <div class="font-weight-medium">{{ $appointment->service_type }}</div>
                                                                            @if($appointment->reason_for_visit)
                                                                                <div class="text-muted small text-truncate" title="{{ is_array($appointment->reason_for_visit) ? implode(', ', $appointment->reason_for_visit) : $appointment->reason_for_visit }}">
                                                                                    @if(is_array($appointment->reason_for_visit))
                                                                                        {{ implode(', ', array_slice($appointment->reason_for_visit, 0, 2)) }}
                                                                                        @if(count($appointment->reason_for_visit) > 2)...@endif
                                                                                    @else
                                                                                        {{ \Str::limit($appointment->reason_for_visit, 30) }}
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <!-- Pet Column -->
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <span class="avatar avatar-xs" 
                                                                              style="background-image: url({{ $appointment->pet && $appointment->pet->photo_data 
                                                                                  ? $appointment->pet->photo_data 
                                                                                  : ($appointment->pet && $appointment->pet->photo ? Storage::url($appointment->pet->photo) : asset('images/default-pet.png')) }})">
                                                                        </span>
                                                                        <div class="text-truncate" style="max-width: 100px;">
                                                                            <div class="font-weight-medium text-truncate" title="{{ $appointment->pet_name ?? 'No pet name' }}">
                                                                                {{ $appointment->pet_name ?? 'No pet name' }}
                                                                            </div>
                                                                            <div class="text-muted small text-truncate">{{ $appointment->pet_type ?? 'No type' }}</div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <!-- Notes Column -->
                                                                <td>
                                                                    <div class="text-wrap text-muted small" style="max-height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" title="{{ $appointment->notes ?: '—' }}">
                                                                        {{ $appointment->notes ?: '—' }}
                                                                    </div>
                                                                </td>

                                                                <!-- Status Column -->
                                                                <td class="text-center">
                                                                    <div class="d-flex flex-column align-items-center gap-1">
                                                                        <span class="badge bg-{{ $statusConfig[$status]['color'] }}-lt d-inline-flex align-items-center gap-1 px-2 py-1">
                                                                            {!! $statusConfig[$status]['icon'] !!}
                                                                            {{ ucfirst($status) }}
                                                                        </span>
                                                                        <div class="text-muted small" style="font-size: 11px; line-height: 1.2;">
                                                                            {{ $statusConfig[$status]['description'] }}
                                                                        </div>
                                                                    </div>
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
                                        <!-- Update the Create Order button -->
                                        <div class="d-flex justify-content-end mb-4">
                                            <button type="button" 
                                                    class="btn btn-primary d-flex align-items-center gap-2" 
                                                    id="createOrderBtn{{ $user->id }}"
                                                    onclick="toggleOrderForm({{ $user->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                                <span>Create Order</span>
                                            </button>
                                        </div>

                                        <!-- Order form -->
                                        <div id="orderForm{{ $user->id }}" class="mb-4" style="display: none;">
                                            <div class="card shadow-sm">
                                                <div class="card-body p-4">
                                                    <form id="createOrderForm{{ $user->id }}">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        
                                                        <!-- Order Details Section (Hidden) -->
                                                        <div class="d-none">
                                                            <input type="hidden" name="invoice_no" value="#INV-{{ uniqid() }}">
                                                            <input type="hidden" name="order_date" value="{{ now()->format('Y-m-d H:i:s') }}">
                                                        </div>

                                                        <!-- Products Section -->
                                                        <div class="mb-0">
                                                            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                                                                <span class="avatar bg-blue-lt me-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                                        <path d="M17 17h-11v-14h-2"></path>
                                                                        <path d="M6 5l14 1l-1 7h-13"></path>
                                                                    </svg>
                                                                </span>
                                                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                                                    <h3 class="mb-0">Products</h3>
                                                                    <button type="button" class="btn btn-primary btn-sm px-3" onclick="addProductRow({{ $user->id }})">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M12 5l0 14"></path>
                                                                            <path d="M5 12l14 0"></path>
                                                                        </svg>
                                                                        Add Product
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-vcenter mb-0" id="productsTable{{ $user->id }}">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th>Product</th>
                                                                            <th style="width: 15%">Quantity</th>
                                                                            <th style="width: 20%">Price</th>
                                                                            <th style="width: 20%">Total</th>
                                                                            <th style="width: 80px" class="text-center">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Product rows will be added here -->
                                                                    </tbody>
                                                                    <tfoot class="bg-light">
                                                                        <tr>
                                                                            <td colspan="3" class="text-end pe-3"><strong>Grand Total:</strong></td>
                                                                            <td><strong id="grandTotal{{ $user->id }}" class="text-primary">₱0.00</strong></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Details -->
                                                        <div class="border-top">
                                                            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                                                                <span class="avatar bg-green-lt me-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                                                                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                                                                    </svg>
                                                                </span>
                                                                <h3 class="mb-0">Payment Details</h3>
                                                            </div>
                                                            <div class="p-3">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Payment Method</label>
                                                                        <select class="form-select" name="payment_method" required>
                                                                            <option value="">Select payment method</option>
                                                                            <option value="cash">Cash</option>
                                                                            <option value="gcash">GCash</option>
                                                                            <option value="card">Credit/Debit Card</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Payment Status</label>
                                                                        <select class="form-select" name="payment_status" required>
                                                                            <option value="pending">Pending</option>
                                                                            <option value="paid">Paid</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Notes -->
                                                        <div class="border-top">
                                                            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                                                                <span class="avatar bg-yellow-lt me-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M15 3v4a1 1 0 0 0 1 1h4"></path>
                                                                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z"></path>
                                                                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"></path>
                                                                    </svg>
                                                                </span>
                                                                <h3 class="mb-0">Notes</h3>
                                                            </div>
                                                            <div class="p-3">
                                                                <textarea class="form-control" name="notes" rows="3" placeholder="Add any additional notes here..."></textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Form Buttons -->
                                                        <div class="d-flex justify-content-end gap-2 p-3 border-top bg-light">
                                                            <button type="button" class="btn btn-link" onclick="toggleOrderForm({{ $user->id }})">Cancel</button>
                                                            <button type="button" class="btn btn-primary px-4" onclick="submitOrder({{ $user->id }})">
                                                                Create Order
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Existing orders table -->
                                        @if($user->orders->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%">Order ID</th>
                                                            <th style="width: 25%">Date</th>
                                                            <th style="width: 15%">Items</th>
                                                            <th style="width: 15%" class="text-end">Amount</th>
                                                            <th style="width: 20%" class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user->orders->take(5) as $order)
                                                            <tr>
                                                                <!-- Order ID -->
                                                                <td class="text-secondary">
                                                                    <div class="text-wrap">
                                                                        #{{ $order->invoice_no ?? 'N/A' }}
                                                                    </div>
                                                                </td>

                                                                <!-- Date -->
                                                                <td>
                                                                    <div class="d-flex flex-column">
                                                                        <div class="text-dark">
                                                                            {{ $order->created_at ? $order->created_at->format('M d, Y') : 'No date' }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $order->created_at ? $order->created_at->format('h:i A') : '' }}
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <!-- Items -->
                                                                <td>
                                                                    <span class="badge bg-blue-lt">
                                                                        {{ $order->total_products ?? 0 }} {{ Str::plural('item', $order->total_products ?? 0) }}
                                                                    </span>
                                                                </td>

                                                                <!-- Amount -->
                                                                <td class="text-end">
                                                                    <span class="font-weight-medium">
                                                                        ₱{{ number_format($order->total ?? 0, 2) }}
                                                                    </span>
                                                                </td>

                                                                <!-- Status -->
                                                                <td class="text-center">
                                                                    @php
                                                                        $statusColors = [
                                                                            'pending' => 'warning',
                                                                            'processing' => 'info',
                                                                            'completed' => 'success',
                                                                            'cancelled' => 'danger'
                                                                        ];
                                                                        $statusColor = $statusColors[$order->order_status] ?? 'secondary';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusColor }}-lt">
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
                                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
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
        const credentialsFilterGroup = document.querySelector('[data-credentials]').closest('.btn-group');
        
        // Function to toggle credentials filter visibility
        function toggleCredentialsFilter(role) {
            if (role === 'pet_owner') {
                credentialsFilterGroup.style.display = 'flex';
            } else {
                credentialsFilterGroup.style.display = 'none';
            }
        }
        
        // Initialize credentials filter visibility based on current role
        toggleCredentialsFilter('{{ request()->query('role', 'all') }}');
        
        roleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                roleButtons.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const role = this.dataset.role;
                
                // Toggle credentials filter visibility
                toggleCredentialsFilter(role);
                
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

    // Update the credentials filter code
    document.addEventListener('DOMContentLoaded', function() {
        const credentialsButtons = document.querySelectorAll('[data-credentials]');
        
        function updateTableVisibility() {
            const activeCredentialsFilter = document.querySelector('[data-credentials].active').dataset.credentials;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const credentialsBadge = row.querySelector('td:nth-child(6) .badge')?.textContent.trim().toLowerCase();
                let showRow = true;
                
                if (activeCredentialsFilter === 'complete') {
                    showRow = credentialsBadge === 'complete';
                } else if (activeCredentialsFilter === 'incomplete') {
                    showRow = credentialsBadge === 'incomplete';
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        credentialsButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                credentialsButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.remove('btn-success', 'btn-warning', 'btn-secondary');
                    if (btn.dataset.credentials === 'complete') {
                        btn.classList.add('btn-outline-success');
                    } else if (btn.dataset.credentials === 'incomplete') {
                        btn.classList.add('btn-outline-warning');
                    } else {
                        btn.classList.add('btn-outline-secondary');
                    }
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                this.classList.remove('btn-outline-success', 'btn-outline-warning', 'btn-outline-secondary');
                
                // Update button style based on type
                if (this.dataset.credentials === 'complete') {
                    this.classList.add('btn-success');
                } else if (this.dataset.credentials === 'incomplete') {
                    this.classList.add('btn-warning');
                } else {
                    this.classList.add('btn-secondary');
                }
                
                updateTableVisibility();
            });
        });

        // Initialize visibility based on default active button
        updateTableVisibility();
    });

    function toggleOrderForm(userId) {
        const orderForm = document.getElementById(`orderForm${userId}`);
        const button = document.getElementById(`createOrderBtn${userId}`);
        const icon = button.querySelector('.icon');
        
        if (orderForm.style.display === 'none' || !orderForm.style.display) {
            // Show form
            orderForm.style.display = 'block';
            button.classList.remove('btn-primary');
            button.classList.add('btn-danger');
            button.querySelector('span').textContent = 'Cancel Order';
            // Change to X icon
            icon.innerHTML = `
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            `;
        } else {
            // Hide form
            orderForm.style.display = 'none';
            button.classList.remove('btn-danger');
            button.classList.add('btn-primary');
            button.querySelector('span').textContent = 'Create Order';
            // Change back to plus icon
            icon.innerHTML = `
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            `;
        }
    }

    function addProductRow(userId) {
        const tbody = document.querySelector(`#productsTable${userId} tbody`);
        const row = document.createElement('tr');
        
        // Get products from PHP and convert to JavaScript
        const products = @json($products);
        
        const productOptions = products.map(product => 
            `<option value="${product.id}" data-price="${product.selling_price}">
                ${product.name} - ₱${product.selling_price.toLocaleString()}
            </option>`
        ).join('');

        row.innerHTML = `
            <td>
                <select class="form-select" name="products[]" required onchange="updatePrice(this, ${userId})">
                    <option value="">Select product</option>
                    ${productOptions}
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="quantities[]" value="1" min="1" onchange="updateTotal(this, ${userId})">
            </td>
            <td>
                <input type="text" class="form-control text-end" readonly value="₱0.00">
            </td>
            <td>
                <input type="text" class="form-control text-end" readonly value="₱0.00">
            </td>
            <td class="text-center px-3">
                <button type="button" class="btn btn-icon btn-danger btn-sm" onclick="removeRow(this, ${userId})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function updatePrice(select, userId) {
        const row = select.closest('tr');
        const price = select.options[select.selectedIndex].dataset.price;
        const quantity = row.querySelector('input[name="quantities[]"]').value;
        
        row.querySelector('td:nth-child(3) input').value = `₱${parseFloat(price).toLocaleString()}`;
        row.querySelector('td:nth-child(4) input').value = `₱${(price * quantity).toLocaleString()}`;
        
        calculateGrandTotal(userId);
    }

    function updateTotal(input, userId) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('td:nth-child(3) input').value.replace('₱', '').replace(/,/g, ''));
        const quantity = input.value;
        
        row.querySelector('td:nth-child(4) input').value = `₱${(price * quantity).toLocaleString()}`;
        
        calculateGrandTotal(userId);
    }

    function removeRow(button, userId) {
        button.closest('tr').remove();
        calculateGrandTotal(userId);
    }

    function calculateGrandTotal(userId) {
        const totals = Array.from(document.querySelectorAll(`#productsTable${userId} tbody tr td:nth-child(4) input`))
            .map(input => parseFloat(input.value.replace('₱', '').replace(/,/g, '')) || 0);
        
        const grandTotal = totals.reduce((sum, total) => sum + total, 0);
        document.getElementById(`grandTotal${userId}`).textContent = `₱${grandTotal.toLocaleString()}`;
    }

    function submitOrder(userId) {
        // Add your order submission logic here
        alert('Order created successfully!');
        
        // Close the create order modal
        const createOrderModal = bootstrap.Modal.getInstance(document.getElementById(`createOrderModal${userId}`));
        if (createOrderModal) {
            createOrderModal.hide();
        }
        
        // Remove the modal-stacked class from the user modal
        const userModal = document.getElementById(`userModal${userId}`);
        if (userModal) {
            userModal.classList.remove('modal-stacked');
        }
    }
</script>
@endpush
@endsection
