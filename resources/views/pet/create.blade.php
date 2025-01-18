@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <h1 class="my-4 text-center">Add New Pet</h1>
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

                    <!-- Pet Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" class="form-control" placeholder="Enter pet type (e.g., Dog, Cat)" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Breed -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="Enter pet breed">
                    </div>

                    <!-- Age -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age (Years)</label>
                        <input type="number" name="age" class="form-control" placeholder="Enter pet age">
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
                        <input type="number" name="weight" class="form-control" placeholder="Enter pet weight">
                    </div>
                </div>

                <div class="row">
                    <!-- Allergies -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" placeholder="List any known allergies"></textarea>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" placeholder="Additional notes or observations"></textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">Select Category</option>
                            <option value="Mammal">Mammal</option>
                            <option value="Reptile">Reptile</option>
                            <option value="Bird">Bird</option>
                            <option value="Fish">Fish</option>
                            <option value="Amphibian">Amphibian</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Photo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
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

<script>
    // Show/Hide User Sections Based on Selection
    document.getElementById('hasAccount').addEventListener('change', function () {
        const hasAccount = this.value;
        document.getElementById('existingUserSection').style.display = hasAccount === 'yes' ? 'block' : 'none';
        document.getElementById('newUserSection').style.display = hasAccount === 'no' ? 'block' : 'none';
    });
</script>

@endsection
