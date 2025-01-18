@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    @include('partials._page_header', [
                        'title' => __('Add New Pet'),
                        'section' => 'OVERVIEW'
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Check if the Pet Owner Has an Account -->
                <div class="mb-3">
                    <label class="form-label">Does the Pet Owner Have an Account?</label>
                    <select id="hasAccount" name="has_account" class="form-select" required>
                        <option value="">Select an option</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <!-- Select Existing User -->
                <div class="mb-3" id="existingUserSection" style="display: none;">
                    <label class="form-label">Select User</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">Select an existing user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Enter Owner Name for Unregistered Owners -->
                <div class="mb-3" id="newUserSection" style="display: none;">
                    <label class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control" placeholder="Enter owner's name">
                </div>

                <!-- Pet Info -->
                <div class="row">
                    <!-- Pet Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter pet name" required>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Fish">Fish</option>
                            <option value="Reptile">Reptile</option>
                            <option value="Amphibian">Amphibian</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Breed -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="Enter pet breed">
                    </div>

                    <!-- Age with Unit Selection -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <div class="input-group">
                            <input type="number" name="age" class="form-control" min="0" placeholder="Enter age">
                            <select name="age_unit" class="form-select" style="max-width: 120px;">
                                <option value="months">Months</option>
                                <option value="years">Years</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Gender -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Weight -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" class="form-control" step="0.01" placeholder="Enter pet weight">
                    </div>
                </div>

                <div class="row">
                    <!-- Photo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>

                    <!-- Allergies -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" placeholder="List any known allergies"></textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- Notes -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" placeholder="Additional notes or observations"></textarea>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                            <path d="M14 4l0 4l-6 0l0 -4"></path>
                        </svg>
                        Save
                    </button>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l-12 12"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('hasAccount').addEventListener('change', function () {
        const hasAccount = this.value;
        document.getElementById('existingUserSection').style.display = hasAccount === 'yes' ? 'block' : 'none';
        document.getElementById('newUserSection').style.display = hasAccount === 'no' ? 'block' : 'none';
    });
</script>

@endsection
