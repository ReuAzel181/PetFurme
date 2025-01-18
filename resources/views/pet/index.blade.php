@extends('layouts.tabler')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Pet List'),
                        'section' => 'OVERVIEW'
                    ])
                </div>
            </div>
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Add New Pet
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                        <td>{{ $pet->user ? $pet->user->name : 'No registered owner' }}</td>
                        <td>{{ $pet->category }}</td>
                        <td>{{ $pet->gender }}</td>
                        <td>{{ $pet->breed }}</td>
                        <td>
                            @if($pet->age >= 12)
                                {{ floor($pet->age/12) }} {{ Str::plural('year', floor($pet->age/12)) }}
                                @if($pet->age % 12 > 0)
                                    {{ $pet->age % 12 }} {{ Str::plural('month', $pet->age % 12) }}
                                @endif
                            @else
                                {{ $pet->age }} {{ Str::plural('month', $pet->age) }}
                            @endif
                        </td>
                        <td>{{ $pet->weight }}</td>
                        <td>{{ $pet->allergies ?? 'None' }}</td>
                        <td>{{ $pet->notes ?? 'None' }}</td>
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
