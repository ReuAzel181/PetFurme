@extends('layouts.mobile-app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg p-4">
                <div class="card-header bg-white">
                    <h3 class="card-title">Add New Pet</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pet-owner.pets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4 text-center">
                            <label class="form-label">Pet Photo</label>
                            <div class="pet-photo-upload rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center w-32 h-32 mx-auto mb-3">
                                <input type="file" name="photo" class="hidden" id="photo-upload" accept="image/*" onchange="previewImage(event)">
                                <label for="photo-upload" class="cursor-pointer flex flex-col items-center justify-center h-full">
                                    <i class="fas fa-camera text-gray-400 text-2xl"></i>
                                    <span class="text-gray-500">Click to Upload Photo</span>
                                </label>
                            </div>
                            <small class="text-gray-500">Recommended: Square image, max 2MB</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pet's Name *</label>
                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Enter pet's name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="type" class="form-select form-control-lg @error('type') is-invalid @enderror" required>
                                    <option value="">Select Type</option>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="bird">Bird</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Breed *</label>
                            <input type="text" name="breed" class="form-control form-control-lg @error('breed') is-invalid @enderror" 
                                   value="{{ old('breed') }}" placeholder="Enter breed" required>
                            @error('breed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Age (months) *</label>
                                <input type="number" name="age" class="form-control form-control-lg @error('age') is-invalid @enderror" 
                                       value="{{ old('age') }}" placeholder="e.g., 24" required>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Weight (kg) *</label>
                                <input type="number" name="weight" class="form-control form-control-lg @error('weight') is-invalid @enderror" 
                                       value="{{ old('weight') }}" placeholder="e.g., 5" required>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Allergies</label>
                            <textarea name="allergies" class="form-control form-control-lg @error('allergies') is-invalid @enderror" 
                                      placeholder="List any allergies (if any)">{{ old('allergies') }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control form-control-lg @error('notes') is-invalid @enderror" 
                                      placeholder="Additional notes or information">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-footer text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-full">Register Pet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded-full', 'w-32', 'h-32', 'object-cover', 'border-2', 'border-primary');
            document.querySelector('.pet-photo-upload').innerHTML = ''; // Clear previous content
            document.querySelector('.pet-photo-upload').appendChild(img); // Add the new image
        }
        reader.readAsDataURL(file);
    }
</script>
@endsection 