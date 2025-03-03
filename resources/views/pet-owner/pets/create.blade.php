@extends('layouts.mobile-app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg p-4">
                <div class="card-header bg-light text-center rounded-top">
                    <h3 class="card-title text-lg font-semibold">Add New Pet</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pet-owner.pets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="mb-4 text-center">
                            <label class="form-label text-sm">Pet Photo</label>
                            <div class="pet-photo-upload rounded border-2 border-dashed border-gray-300 flex items-center justify-center w-32 h-32 mx-auto mb-3">
                                <input type="file" name="photo" class="hidden" id="photo-upload" accept="image/*" onchange="previewImage(event)">
                                <label for="photo-upload" class="cursor-pointer flex flex-col items-center justify-center h-full">
                                    <i class="fas fa-camera text-gray-400 text-lg"></i>
                                    <span class="text-gray-500 text-xs">Click to Upload Photo</span>
                                </label>
                            </div>
                            <small class="text-gray-500 text-xs">Recommended: Square image, max 2MB</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Category *</label>
                            <select name="category" class="form-select form-control-lg @error('category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="bird">Bird</option>
                                <option value="other">Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Gender *</label>
                            <select name="gender" class="form-select form-control-lg @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Pet's Name *</label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Enter pet's name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Breed *</label>
                            <input type="text" name="breed" class="form-control form-control-lg @error('breed') is-invalid @enderror" 
                                   value="{{ old('breed') }}" placeholder="Enter breed" required>
                            @error('breed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Age (months) *</label>
                            <input type="number" name="age" class="form-control form-control-lg @error('age') is-invalid @enderror" 
                                   value="{{ old('age') }}" placeholder="e.g., 24" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Weight (kg) *</label>
                            <input type="number" name="weight" class="form-control form-control-lg @error('weight') is-invalid @enderror" 
                                   value="{{ old('weight') }}" placeholder="e.g., 5" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Allergies</label>
                            <textarea name="allergies" class="form-control form-control-lg @error('allergies') is-invalid @enderror" 
                                      placeholder="List any allergies (if any)">{{ old('allergies') }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm">Notes</label>
                            <textarea name="notes" class="form-control form-control-lg @error('notes') is-invalid @enderror" 
                                      placeholder="Additional notes or information">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-footer text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Register Pet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px; /* Increased padding for better spacing */
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
        padding: 10px; /* Added padding for input fields */
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 10px;
        transition: background-color 0.3s, border-color 0.3s;
        padding: 10px 20px; /* Increased padding for buttons */
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .pet-photo-upload img {
        border-radius: 10px;
    }
    .form-label {
        font-weight: bold; /* Make labels bold for better visibility */
    }
    .mb-4 {
        margin-bottom: 1.5rem; /* Increased margin for better spacing */
    }
</style>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded', 'w-32', 'h-32', 'object-cover', 'border-2', 'border-primary');
            document.querySelector('.pet-photo-upload').innerHTML = ''; // Clear previous content
            document.querySelector('.pet-photo-upload').appendChild(img); // Add the new image
        }
        reader.readAsDataURL(file);
    }
</script>
@endsection 