@extends('layouts.tabler') <!-- Or your preferred layout -->

@section('content')
<div class="container">
    <div class="col">
        @include('partials._page_header', [
            'title' => __('User Management'),
            'section' => 'OVERVIEW'
        ])
    </div>
    <p>Manage users by category or view all users.</p>

    <!-- Filter Buttons -->
    <div class="btn-group mb-4">
        @foreach($roles as $key => $label)
            <a href="{{ route('user-management.index', ['role' => $key]) }}" 
               class="btn btn-primary {{ request()->query('role', 'all') === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Add User Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('user-management.create') }}" class="btn btn-success">Add User</a>
    </div>

    <!-- User Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Pet Name</th>
                <th>Pet Type</th>
                <th>Store Name</th>
                <th>Store Address</th>
                <th>Store Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th> <!-- New Actions Column -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td>{{ $user->pet_name ?? 'N/A' }}</td>
                    <td>{{ $user->pet_type ?? 'N/A' }}</td>
                    <td>{{ $user->store_name ?? 'N/A' }}</td>
                    <td>{{ $user->store_address ?? 'N/A' }}</td>
                    <td>{{ $user->store_email ?? 'N/A' }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $user->updated_at ? $user->updated_at->format('Y-m-d') : 'N/A' }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('user-management.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
