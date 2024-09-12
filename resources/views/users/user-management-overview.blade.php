<!-- resources/views/users/user-management-overview.blade.php -->

@extends('layouts.tabler')

@section('title', 'User Management Overview')

@section('content')
    <div class="container">
        <h1>User Management Overview</h1>
        <p>Welcome to the User Management section. Use the links below to manage users.</p>
        <ul>
            <li><a href="{{ route('user-management.pet-owner') }}">View Pet Owners</a></li>
            <li><a href="{{ route('user-management.sub-admin') }}">View Sub Admins</a></li>
            <!-- Add more links or content as needed -->
        </ul>
    </div>
@endsection
