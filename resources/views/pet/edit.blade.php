@extends('layouts.tabler')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-xl">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title fs-1 fw-bold">{{ __('Edit Pet Details') }}</h3>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data" id="petForm">
                        @csrf
                        @method('PUT')

                        <!-- Pet Owner Selection -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label required fs-3">Select Pet Owner</label>
                                <select name="user_id" class="form-select form-select-lg fs-4" id="ownerSelect">
                                    <option value="">No Account</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $pet->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pet-details">
                            <div class="row">
                                <div class="col-lg-4">
                                    <!-- Photo Upload -->
                                    <div class="position-sticky" style="top: 1rem;">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="text-center mb-3">
                                                <h4 class="fs-4 fw-bold">Pet Photo</h4>
                                                <p class="text-muted fs-5">Upload a clear photo of your pet</p>
                                            </div>
                                            <div class="position-relative">
                                                <label for="photo" class="photo-upload-label cursor-pointer">
                                                    <div class="position-relative">
                                                        <img id="preview" 
                                                             src="{{ $pet->photo_data ? $pet->photo_data : ($pet->photo ? Storage::url($pet->photo) : asset('images/default-pet.png')) }}" 
                                                             class="rounded-circle shadow-sm" 
                                                             style="width: 300px; height: 300px; object-fit: cover; border: 3px solid #e4e6ef;">
                                                        <div class="upload-overlay rounded-circle">
                                                            <span class="upload-text fs-5">
                                                                <i class="fas fa-camera fs-2 mb-2"></i><br>
                                                                Click to Change Photo
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input type="file" name="photo" id="photo" class="d-none" 
                                                       onchange="previewImage(this)" accept="image/*">
                                            </div>
                                            <div class="text-center mt-3">
                                                <span class="text-muted fs-6">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Recommended: Square image, max 2MB
                                                </span>
                                            </div>
                                            @if($pet->photo_data || ($pet->photo && Storage::disk('public')->exists($pet->photo)))
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-danger" onclick="removePhoto()">
                                                        <i class="fas fa-trash me-1"></i> Remove Photo
                                                    </button>
                                                </div>
                                            @endif
                                            <input type="hidden" name="remove_photo" id="removePhoto" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <!-- Basic Information -->
                                    <div class="row g-3">
                                        <!-- First Row -->
                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Pet's Name</label>
                                            <input type="text" name="name" class="form-control form-control-lg fs-4" 
                                                   required value="{{ old('name', $pet->name) }}" placeholder="Enter pet's name">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Category</label>
                                            <select name="category" class="form-select form-select-lg fs-4" required>
                                                <option value="">Select category</option>
                                                <option value="Dog" {{ $pet->category == 'Dog' ? 'selected' : '' }}>Dog</option>
                                                <option value="Cat" {{ $pet->category == 'Cat' ? 'selected' : '' }}>Cat</option>
                                                <option value="Bird" {{ $pet->category == 'Bird' ? 'selected' : '' }}>Bird</option>
                                                <option value="Rabbit" {{ $pet->category == 'Rabbit' ? 'selected' : '' }}>Rabbit</option>
                                                <option value="Other" {{ $pet->category == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Breed</label>
                                            <input type="text" name="breed" class="form-control form-control-lg fs-4" 
                                                   value="{{ old('breed', $pet->breed) }}" placeholder="Enter breed">
                                        </div>

                                        <!-- Second Row -->
                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Gender</label>
                                            <select name="gender" class="form-select form-select-lg fs-4">
                                                <option value="Male" {{ $pet->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $pet->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Age</label>
                                            <div class="input-group input-group-lg">
                                                <input type="number" name="age" class="form-control form-control-lg fs-4" 
                                                       value="{{ old('age', $pet->age >= 12 ? floor($pet->age/12) : $pet->age) }}" 
                                                       placeholder="Enter age">
                                                <select name="age_unit" class="form-select form-select-lg fs-4" style="max-width: 140px;">
                                                    <option value="months" {{ $pet->age < 12 ? 'selected' : '' }}>Months</option>
                                                    <option value="years" {{ $pet->age >= 12 ? 'selected' : '' }}>Years</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label required fs-4">Weight (kg)</label>
                                            <input type="number" step="0.01" name="weight" class="form-control form-control-lg fs-4" 
                                                   value="{{ old('weight', $pet->weight) }}" placeholder="Enter weight in kg">
                                        </div>

                                        <!-- Third Row -->
                                        <div class="col-md-12">
                                            <label class="form-label fs-4">Allergies</label>
                                            <textarea name="allergies" class="form-control form-control-lg fs-4" rows="2"
                                                      placeholder="List any known allergies (optional)">{{ old('allergies', $pet->allergies) }}</textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fs-4">Notes</label>
                                            <textarea name="notes" class="form-control form-control-lg fs-4" rows="3"
                                                      placeholder="Add any additional information about your pet (optional)">{{ old('notes', $pet->notes) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-footer mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 fs-4">
                                            <i class="fas fa-save me-2"></i>
                                            <span>Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border-color: #e4e6ef;
    padding: 0.75rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #6777ef;
    box-shadow: 0 0 0 0.2rem rgba(103, 119, 239, 0.25);
}

.required:after {
    content: " *";
    color: #dc3545;
}

.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid #f0f0f0;
    padding: 1.5rem;
}

.btn-primary {
    background-color: #6777ef;
    border-color: #6777ef;
}

.btn-primary:hover {
    background-color: #5965e0;
    border-color: #5965e0;
}

.cursor-pointer {
    cursor: pointer;
}

.photo-upload-label {
    display: inline-block;
    position: relative;
}

.upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 300px;
    height: 300px;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border: 2px dashed #fff;
}

.photo-upload-label:hover .upload-overlay {
    opacity: 1;
}

.upload-text {
    color: white;
    font-weight: 500;
    text-align: center;
    padding: 1rem;
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('removePhoto').value = '0';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhoto() {
    document.getElementById('preview').src = "{{ asset('images/default-pet.png') }}";
    document.getElementById('removePhoto').value = '1';
    document.getElementById('photo').value = '';
}

document.getElementById('ownerSelect').addEventListener('change', function() {
    const formElements = document.querySelectorAll('input:not([type="hidden"]), select:not(#ownerSelect), textarea');
    formElements.forEach(element => {
        element.disabled = !this.value;
    });
});

// Add form submission handler for success message
document.getElementById('petForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Convert photo to binary data if a file is selected
    const photoInput = document.getElementById('photo');
    if (photoInput.files && photoInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create a hidden input to store the binary data
            const binaryInput = document.createElement('input');
            binaryInput.type = 'hidden';
            binaryInput.name = 'photo_binary';
            binaryInput.value = e.target.result;
            document.getElementById('petForm').appendChild(binaryInput);
            
            // Now submit the form
            submitForm();
        };
        reader.readAsDataURL(photoInput.files[0]);
    } else {
        submitForm();
    }
    
    function submitForm() {
        const form = document.getElementById('petForm');
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Pet information has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('pets.index') }}";
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
});
</script>
@endsection
