@extends('layouts.tabler')

@section('content')
<div class="container-fluid">
    <div class="col">
        <div class="page-pretitle text-muted 					text-uppercase">
            overview
        </div>
        <h2 class="page-title">
            Clinic Inventory
        </h2>
    </div>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('pets.create') }}" class="btn btn-primary btn-lg">Add New Pet</a>
    </div>

    @if($pets->isEmpty())
        <div class="alert alert-info text-center">
            No pets found! Click "Add New Pet" to start managing your pets.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Owner</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Weight</th>
                        <th>Allergies</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pets as $pet)
                    <tr>
                        <td>
                            @if($pet->photo)
                                <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" width="100" class="img-thumbnail">
                            @else
                                <span>No Photo</span>
                            @endif
                        </td>
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->type }}</td>
                        <td>{{ $pet->user ? $pet->user->name : 'No registered owner' }}</td>
                        <td>{{ $pet->category }}</td>
                        <td>{{ $pet->gender }}</td>
                        <td>{{ $pet->breed }}</td>
                        <td>{{ $pet->age }}</td>
                        <td>{{ $pet->weight }}</td>
                        <td>{{ $pet->allergies ?? 'None' }}</td> <!-- Added proper handling for allergies -->
                        <td>{{ $pet->notes ?? 'None' }}</td> <!-- Ensures notes are displayed or shows 'None' if null -->
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pet?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
