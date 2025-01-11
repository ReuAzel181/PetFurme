@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <h1 class="my-4 text-center">Edit Pet</h1>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="editPetTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="additional-info-tab" data-bs-toggle="tab" href="#additional-info" role="tab" aria-controls="additional-info" aria-selected="false">Additional Info</a>
                </li>
            </ul>
            <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                @method('PUT')

                <div class="tab-content">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                        <div class="mb-3">
                            <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $pet->name }}" class="form-control" placeholder="Enter pet name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <input type="text" name="type" value="{{ $pet->type }}" class="form-control" placeholder="Enter pet type (e.g., Dog, Cat)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" value="{{ $pet->owner_name }}" class="form-control" placeholder="Enter owner's name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select">
                                <option value="">Select a category</option>
                                <option value="Mammal" {{ $pet->category === 'Mammal' ? 'selected' : '' }}>Mammal</option>
                                <option value="Reptile" {{ $pet->category === 'Reptile' ? 'selected' : '' }}>Reptile</option>
                                <option value="Bird" {{ $pet->category === 'Bird' ? 'selected' : '' }}>Bird</option>
                                <option value="Fish" {{ $pet->category === 'Fish' ? 'selected' : '' }}>Fish</option>
                                <option value="Amphibian" {{ $pet->category === 'Amphibian' ? 'selected' : '' }}>Amphibian</option>
                                <option value="Other" {{ $pet->category === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Info Tab -->
                    <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="Male" {{ $pet->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $pet->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $pet->gender === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Breed</label>
                            <input type="text" name="breed" value="{{ $pet->breed }}" class="form-control" placeholder="Enter pet breed">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" value="{{ $pet->age }}" class="form-control" placeholder="Enter pet age (in years)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" name="weight" value="{{ $pet->weight }}" class="form-control" placeholder="Enter pet weight">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Allergies</label>
                            <textarea name="allergies" class="form-control" placeholder="List any known allergies">{{ $pet->allergies }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" placeholder="Additional notes or observations">{{ $pet->notes }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            @if($pet->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" width="150" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Upload a new photo to replace the existing one (optional).</small>
                        </div>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
