@extends('layouts.tabler') <!-- Or your preferred layout -->

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Edit User</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Use PUT or PATCH for update -->

                <!-- Username and Name -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                </div>

                <!-- Email and Phone -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="photo" class="form-label">Profile Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <small class="text-muted">Upload a new photo if you'd like to replace the current one.</small>
                        @if($user->photo)
                            <div class="mt-3">
                                <p>Current Photo:</p>
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" class="img-thumbnail" style="width: 150px; height: 150px;">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
