@extends('layouts.tabler')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-xl">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title fs-1 fw-bold">{{ __('New Pet Registration') }}</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data" id="petForm">
                        @csrf

                        <!-- Pet Owner Selection -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label required fs-3">Select Pet Owner</label>
                                <select name="user_id" class="form-select form-select-lg fs-4" required id="ownerSelect">
                                    <option value="">Choose a pet owner</option>
                                    @foreach(\App\Models\User::where('role', 'pet_owner')->get() as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }} - {{ $owner->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Add this hidden input for type -->
                        <input type="hidden" name="type" value="pet">

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
                                                        <img id="preview" src="{{ asset('images/default-pet-avatar.png') }}" 
                                                             class="rounded-circle shadow-sm" 
                                                             style="width: 300px; height: 300px; object-fit: cover; border: 3px solid #e4e6ef;">
                                                        <div class="upload-overlay rounded-circle">
                                                            <span class="upload-text fs-5">
                                                                <i class="fas fa-camera fs-2 mb-2"></i><br>
                                                                Click to Upload Photo
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input type="file" name="photo" id="photo" class="d-none" 
                                                       onchange="previewImage(this)" accept="image/*" disabled>
                                            </div>
                                            <div class="text-center mt-3">
                                                <span class="text-muted fs-6">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Recommended: Square image, max 2MB
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="row g-4">
                                        <!-- Basic Information -->
                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Pet's Name</label>
                                            <input type="text" name="name" class="form-control form-control-lg fs-4" required disabled
                                                   placeholder="Enter pet's name">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Category</label>
                                            <select name="category" class="form-select form-select-lg fs-4" required disabled>
                                                <option value="">Select pet category</option>
                                                <option value="Dog">Dog</option>
                                                <option value="Cat">Cat</option>
                                                <option value="Bird">Bird</option>
                                                <option value="Rabbit">Rabbit</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Breed</label>
                                            <input type="text" name="breed" class="form-control form-control-lg fs-4" required disabled
                                                   placeholder="Enter breed">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Gender</label>
                                            <select name="gender" class="form-select form-select-lg fs-4" required disabled>
                                                <option value="">Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Age (months)</label>
                                            <input type="number" name="age" class="form-control form-control-lg fs-4" required disabled
                                                   placeholder="Enter age in months">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label required fs-4">Weight (kg)</label>
                                            <input type="number" step="0.01" name="weight" class="form-control form-control-lg fs-4" required disabled
                                                   placeholder="Enter weight in kg">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fs-4">Allergies</label>
                                            <textarea name="allergies" class="form-control form-control-lg fs-4" rows="2" disabled
                                                placeholder="List any known allergies (optional)"></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fs-4">Notes</label>
                                            <textarea name="notes" class="form-control form-control-lg fs-4" rows="3" disabled
                                                placeholder="Add any additional information about your pet (optional)"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-footer mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 fs-4" disabled>
                                            <i class="fas fa-save me-2"></i>
                                            <span>Register Pet</span>
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

.form-control:disabled, .form-select:disabled {
    background-color: #f8f9fa;
    cursor: not-allowed;
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

.photo-upload-label:not(:has(img[src*="default-pet-avatar"])) .upload-overlay {
    background-color: rgba(0, 0, 0, 0.4);
}

.upload-text {
    color: white;
    font-weight: 500;
    text-align: center;
    padding: 1rem;
    font-size: 1.25rem;
}

.upload-text i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.photo-upload-label:hover .upload-overlay {
    opacity: 1;
}

.row.g-4 {
    --bs-gutter-y: 1.5rem;
}

.photo-upload-label img {
    width: 300px !important;
    height: 300px !important;
}

.btn-primary.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.25rem;
}

</style>

<script>
// Define the Toast configuration once
const Toast = Swal.mixin({
    toast: true,
    position: 'center', // Changed to center
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

document.getElementById('ownerSelect').addEventListener('change', function() {
    const formElements = document.querySelectorAll('input:not([type="hidden"]), select, textarea, button');
    
    formElements.forEach(element => {
        if (this.value) {
            element.removeAttribute('disabled');
        } else {
            element.setAttribute('disabled', 'disabled');
        }
    });
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            input.closest('.photo-upload-label').querySelector('.upload-text').innerHTML = 
                '<i class="fas fa-camera fs-2 mb-2"></i><br>Change Photo';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Form submission handling
document.getElementById('petForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    
    const formData = new FormData(this);
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';

    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            await Toast.fire({
                icon: 'success',
                title: 'Pet registered successfully'
            });
            window.location.href = data.redirect || '/pets';
        } else {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
            
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = data.errors[field][0];
                        input.parentNode.appendChild(feedback);
                    }
                });
            }

            await Toast.fire({
                icon: 'error',
                title: data.message || 'Failed to register pet'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
        
        await Toast.fire({
            icon: 'error',
            title: 'An error occurred'
        });
    }
});
</script>
@endsection
