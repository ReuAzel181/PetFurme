@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    {{ __('Create User') }}
                </h2>
            </div>
        </div>

        @include('partials._breadcrumbs')
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">

            <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('User Image') }}
                                </h3>

                                <div class="card-body text-center">
                                    <img class="img-account-profile rounded-circle mb-2"
                                         src="{{ asset('assets/img/demo/user-placeholder.svg') }}"
                                         alt=""
                                         id="image-preview"
                                    >
                                    <div class="small font-italic text-muted mb-2">
                                        JPG or PNG no larger than 1 MB
                                    </div>

                                    <input type="file"
                                           id="image"
                                           name="photo"
                                           accept="image/*"
                                           onchange="previewImage();"
                                           class="form-control @error('photo') is-invalid @enderror"
                                    >

                                    @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('User Details') }}
                                </h3>

                                <div class="row row-cards">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">
                                                {{ __('User Type') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                                                <option value="" disabled selected>Select User Type</option>
                                                <option value="pet_owner" {{ old('type') == 'pet_owner' ? 'selected' : '' }}>Pet Owner</option>
                                                <option value="sub_admin" {{ old('type') == 'sub_admin' ? 'selected' : '' }}>Sub Admin</option>
                                            </select>

                                            @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                {{ __('Name') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                            >

                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="phone" class="form-label">
                                                {{ __('Phone Number') }}
                                            </label>
                                            <input type="text"
                                                id="phone"
                                                name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}"
                                            >
                                            @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>


                                        <div class="col-md-12">
                                            <label for="address" class="form-label">
                                                {{ __('Address') }}
                                            </label>

                                            <textarea id="address"
                                                      name="address"
                                                      class="form-control @error('address') is-invalid @enderror"
                                            >{{ old('address') }}</textarea>

                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                {{ __('Email address') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                   id="email"
                                                   name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}"
                                            >

                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">
                                                {{ __('Password') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                            >

                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                {{ __('Password confirmation') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="password"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                            >

                                            @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                        

                                    <!-- Conditional Fields -->
                                    <div id="pet-owner-fields" style="display: none;">

                                            <div class="col-md-6">
                                                <label for="number_of_pets" class="form-label">
                                                    {{ __('Number of Pets') }}
                                                </label>

                                                <input type="number"
                                                    id="number_of_pets"
                                                    name="number_of_pets"
                                                    class="form-control @error('number_of_pets') is-invalid @enderror"
                                                    value="{{ old('number_of_pets') }}"
                                                     min="0"
                                                >

                                                @error('number_of_pets')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div id="pets-container"></div>

                                            <div class="col-md-12">
                                                <label for="pet_type" class="form-label">
                                                    {{ __('Pet Type') }}
                                                </label>
                                                <input type="text"
                                                    id="pet_type"
                                                    name="pet_type"
                                                    class="form-control @error('pet_type') is-invalid @enderror"
                                                    value="{{ old('pet_type') }}"
                                                >
                                                @error('pet_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <label for="pet_name" class="form-label">
                                                    {{ __('Pet Name') }}
                                                </label>
                                                <input type="text"
                                                    id="pet_name"
                                                    name="pet_name"
                                                    class="form-control @error('pet_name') is-invalid @enderror"
                                                    value="{{ old('pet_name') }}"
                                                >
                                                @error('pet_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        

                                        
                                    </div>

                                    <!-- Conditional Fields for Sub Admin (if needed) -->
                                    <div id="sub-admin-fields" style="display: none;">

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Create') }}
                                </button>

                                <a class="btn btn-outline-warning" href="{{ route('users.index') }}">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@pushonce('page-scripts')
<script src="{{ asset('assets/js/img-preview.js') }}"></script>
<script>
    // Show/Hide fields based on user type
    document.getElementById('type').addEventListener('change', function() {
        var type = this.value;
        var petOwnerFields = document.getElementById('pet-owner-fields');
        var subAdminFields = document.getElementById('sub-admin-fields');
        
        if (type === 'pet_owner') {
            petOwnerFields.style.display = 'block';
            subAdminFields.style.display = 'none';
        } else if (type === 'sub_admin') {
            petOwnerFields.style.display = 'none';
            subAdminFields.style.display = 'block';
        } else {
            petOwnerFields.style.display = 'none';
            subAdminFields.style.display = 'none';
        }
    });
        // Handle dynamic fields for pets
        document.getElementById('number_of_pets').addEventListener('input', function() {
        var numberOfPets = parseInt(this.value);
        var petsContainer = document.getElementById('pets-container');

        // Clear the container
        petsContainer.innerHTML = '';

        // Add fields dynamically based on the number of pets
        for (var i = 0; i < numberOfPets; i++) {
            var petFields = `
                <div class="col-md-6">
                    <label for="pet_type_${i}" class="form-label">Pet ${i + 1} Type</label>
                    <input type="text" id="pet_type_${i}" name="pet_types[]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="pet_name_${i}" class="form-label">Pet ${i + 1} Name</label>
                    <input type="text" id="pet_name_${i}" name="pet_names[]" class="form-control">
                </div>
            `;
            petsContainer.insertAdjacentHTML('beforeend', petFields);
        }
    });
    
</script>
@endpushonce
