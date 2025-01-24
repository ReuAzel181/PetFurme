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
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="btn-group">
                            @foreach($roles as $key => $label)
                                <a href="{{ route('user-management.index', ['role' => $key]) }}" 
                                   class="btn btn-outline-secondary {{ request()->query('role', 'all') === $key ? 'active' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('user-management.create') }}" class="btn btn-primary">
                            Add User
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('PetFurme/default-avatar.png') }}" 
                                                 alt="Avatar" class="avatar" style="width: 32px; height: 32px; border-radius: 50%;">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '—' }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}</td>
                                        <td>{{ $user->updated_at ? $user->updated_at->format('Y-m-d') : '—' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-sm">
                                                    Edit
                                                </a>
                                                <form action="{{ route('user-management.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-danger" onclick="return confirm('Are you sure?')">
                                                        Delete
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
@endsection
