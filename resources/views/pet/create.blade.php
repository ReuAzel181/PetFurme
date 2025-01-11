@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <h1 class="my-4 text-center">Add New Pet</h1>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="petFormTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="additional-info-tab" data-bs-toggle="tab" href="#additional-info" role="tab" aria-controls="additional-info" aria-selected="false">Additional Info</a>
                </li>
            </ul>
            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data" class="tab-content mt-3">
                @csrf

                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                    <div class="mb-3">
                        <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter pet name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" class="form-control" placeholder="Enter pet type (e.g., Dog, Cat)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" name="owner_name" class="form-control" placeholder="Enter owner's name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select">
                            <option value="">Select a category</option>
                            <option value="Mammal">Mammal</option>
                            <option value="Reptile">Reptile</option>
                            <option value="Bird">Bird</option>
                            <option value="Fish">Fish</option>
                            <option value="Amphibian">Amphibian</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" name="custom_category" class="form-control mt-2" placeholder="Type custom category if not listed">
                    </div>
                </div>

                <!-- Additional Info Tab -->
                <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="Enter pet breed">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" placeholder="Enter pet age (in years)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" class="form-control" placeholder="Enter pet weight">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" placeholder="List any known allergies"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" placeholder="Additional notes or observations"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Upload a photo of the pet (optional).</small>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
