@extends('layouts.tabler')

@section('content')
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
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="btn-group">
                            @foreach($roles as $key => $label)
                                <a href="{{ route('user-management.index', ['role' => $key]) }}" 
                                   class="btn btn-primary {{ request()->query('role', 'all') === $key ? 'active' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('user-management.create') }}" class="btn btn-success">Add User</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt="No Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                            @else
                                                <img src="{{ asset('default-avatar.png') }}" alt="No Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
