@extends('layouts.tabler')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col">
                @include('partials._page_header', [
                    'title' => __('Edit User'),
                    'section' => 'USER MANAGEMENT'
                ])
            </div>
        </div>

        <!-- Form Card -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Validation Errors -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label class="form-label required">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="sub_admin" {{ $user->role === 'sub_admin' ? 'selected' : '' }}>Sub Admin</option>
                                    <option value="pet_owner" {{ $user->role === 'pet_owner' ? 'selected' : '' }}>Pet Owner</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Phone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Leave blank to keep current password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Leave blank to keep current password">
                                </div>
                            </div>

                            <!-- Profile Photo -->
                            <div class="mb-4">
                                <label class="form-label">Profile Photo</label>
                                <div class="mb-3">
                                    <div style="width: 96px; height: 96px; overflow: hidden; border-radius: 50%;">
                                        @if($user->photo_data)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($user->photo_data) }}"
                                                 alt="Current Profile Photo"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @elseif($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}"
                                                 alt="Current Profile Photo"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('storage/defaults/no-avatar.jpg') }}"
                                                 alt="Default Profile Photo"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                </div>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                       id="photo" name="photo" accept="image/*" onchange="validateFileSize(this)">
                                <small class="form-text text-muted">Leave blank to keep current photo</small>
                                <small class="text-muted d-block">Maximum file size: 2MB</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-footer">
                                <div class="ms-auto">
                                    <button type="submit" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        Update User
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .required:after {
        content: ' *';
        color: red;
    }
    .form-footer {
        display: flex;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid #e6e7e9;
    }
</style>

@section('scripts')
<script>
function validateFileSize(input) {
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (input.files[0] && input.files[0].size > maxSize) {
        alert('File size must be less than 2MB');
        input.value = '';
    }
}
</script>
@endsection
@endsection
