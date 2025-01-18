@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="container-xl">
                <div class="row">
                    <div class="col">
                        @include('partials._page_header', [
                            'title' => __('Edit Pet Details'),
                            'section' => 'OVERVIEW'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Pet Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $pet->name }}" class="form-control" required>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="Dog" {{ $pet->category == 'Dog' ? 'selected' : '' }}>Dog</option>
                            <option value="Cat" {{ $pet->category == 'Cat' ? 'selected' : '' }}>Cat</option>
                            <option value="Bird" {{ $pet->category == 'Bird' ? 'selected' : '' }}>Bird</option>
                            <option value="Fish" {{ $pet->category == 'Fish' ? 'selected' : '' }}>Fish</option>
                            <option value="Reptile" {{ $pet->category == 'Reptile' ? 'selected' : '' }}>Reptile</option>
                            <option value="Amphibian" {{ $pet->category == 'Amphibian' ? 'selected' : '' }}>Amphibian</option>
                            <option value="Other" {{ $pet->category == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Owner Selection -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assign to User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">No Account</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $pet->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Free-Text Owner Name -->
                    <div class="col-md-6 mb-3" id="ownerNameSection" {{ $pet->user_id ? 'style=display:none;' : '' }}>
                        <label class="form-label">Owner Name (if no account)</label>
                        <input type="text" name="owner_name" value="{{ $pet->owner_name }}" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <!-- Breed -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" value="{{ $pet->breed }}" class="form-control">
                    </div>

                    <!-- Age -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <div class="input-group">
                            <input type="number" name="age" class="form-control" min="0" 
                                value="{{ $pet->age >= 12 ? floor($pet->age/12) : $pet->age }}" placeholder="Enter age">
                            <select name="age_unit" class="form-select" style="max-width: 120px;">
                                <option value="months" {{ $pet->age < 12 ? 'selected' : '' }}>Months</option>
                                <option value="years" {{ $pet->age >= 12 ? 'selected' : '' }}>Years</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Weight -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" value="{{ $pet->weight }}" class="form-control">
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="Male" {{ $pet->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $pet->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $pet->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Allergies -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control">{{ $pet->allergies }}</textarea>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control">{{ $pet->notes }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- Photo Upload -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Photo</label>
                        @if($pet->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $pet->photo) }}" alt="Pet Photo" width="150" class="img-thumbnail">
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to Toggle Owner Name Field -->
<script>
    document.getElementById('user_id').addEventListener('change', function () {
        const ownerNameSection = document.getElementById('ownerNameSection');
        ownerNameSection.style.display = this.value ? 'none' : 'block';
    });
</script>
@endsection
