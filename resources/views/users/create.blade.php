@extends('layouts.tabler') <!-- Or your preferred layout -->

@section('content')
<div class="container">
    <h1 class="mb-4">Add User</h1>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information -->
        <h4 class="mb-3">Personal Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Phone (Optional)</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
        </div>

        <!-- Pet Information -->
        <h4 class="mb-3">Pet Information (Optional)</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="pet_name">Pet Name</label>
                <input type="text" class="form-control" id="pet_name" name="pet_name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="pet_type">Pet Type</label>
                <input type="text" class="form-control" id="pet_type" name="pet_type">
            </div>
        </div>

        <!-- Store Information -->
        <h4 class="mb-3">Store Information (Optional)</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="store_name">Store Name</label>
                <input type="text" class="form-control" id="store_name" name="store_name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="store_address">Store Address</label>
                <input type="text" class="form-control" id="store_address" name="store_address">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="store_email">Store Email</label>
                <input type="email" class="form-control" id="store_email" name="store_email">
            </div>
        </div>

        <!-- Account Information -->
        <h4 class="mb-3">Account Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="sub_admin">Sub Admin</option>
                    <option value="pet_owner">Pet Owner</option>
                </select>
            </div>
        </div>

        <!-- Profile Photo -->
        <h4 class="mb-3">Profile Photo (Optional)</h4>
        <div class="mb-3">
            <label for="photo">Upload Photo</label>
            <input type="file" class="form-control-file" id="photo" name="photo">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>
@endsection
