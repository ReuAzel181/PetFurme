@extends('layouts.tabler')

@push('page-styles')
<link href="{{ asset('css/appointment.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Schedule New Appointment</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('appointment.index') }}" class="btn btn-secondary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                        </svg>
                        Back to Appointments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST" class="card" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('error_section'))
                        <div class="alert alert-info">
                            Error Section: {{ session('error_section') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="{{ isset($owner) && $owner->photo_data ? 'data:image/jpeg;base64,' . base64_encode($owner->photo_data) : (isset($owner) && $owner->photo ? asset('storage/' . $owner->photo) : asset('storage/defaults/avatar.png')) }}" 
                                                             class="avatar avatar-lg" 
                                                             id="owner_avatar"
                                                             alt="Owner Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label required">Pet Owner</label>
                                                        <select name="owner_id" id="owner_id" class="form-select" required>
                                                            <option value="">Select Owner</option>
                                                            <option value="no_account">No Account (Walk-in)</option>
                                                            @foreach($owners as $ownerOption)
                                                                <option value="{{ $ownerOption->id }}" 
                                                                    data-avatar="{{ $ownerOption->photo_data ? 'data:image/jpeg;base64,' . base64_encode($ownerOption->photo_data) : ($ownerOption->photo ? asset('storage/' . $ownerOption->photo) : asset('storage/defaults/avatar.png')) }}"
                                                                    {{ (old('owner_id') == $ownerOption->id || (isset($owner) && $owner->id == $ownerOption->id)) ? 'selected' : '' }}>
                                                                    {{ $ownerOption->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('owner_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-wrapper me-3">
                                                        <img src="{{ isset($pet) && $pet->photo_data ? 'data:image/jpeg;base64,' . base64_encode($pet->photo_data) : (isset($pet) && $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/defaults/paw.png')) }}" 
                                                             class="avatar avatar-lg" 
                                                             id="dynamic_avatar"
                                                             alt="Pet Avatar"
                                                             style="width: 64px; height: 64px; object-fit: cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div id="pet_select_container" style="{{ isset($owner) && $owner->id == 'no_account' ? 'display: none;' : '' }}">
                                                            <label class="form-label required">Select Pet</label>
                                                            <select name="pet_id" id="pet_id" class="form-select" {{ isset($owner) && $owner->id == 'no_account' ? '' : 'required' }}>
                                                                <option value="">Select Pet</option>
                                                                @if(isset($ownerPets))
                                                                    @foreach($ownerPets as $petOption)
                                                                        <option value="{{ $petOption->id }}" 
                                                                            data-photo="{{ $petOption->photo_data ? 'data:image/jpeg;base64,' . base64_encode($petOption->photo_data) : ($petOption->photo ? asset('storage/' . $petOption->photo) : asset('storage/defaults/paw.png')) }}"
                                                                            {{ (old('pet_id') == $petOption->id || (isset($pet) && $pet->id == $petOption->id)) ? 'selected' : '' }}
                                                                            data-name="{{ $petOption->name }}"
                                                                            data-category="{{ $petOption->category }}"
                                                                            data-breed="{{ $petOption->breed }}"
                                                                            data-age="{{ $petOption->age }}"
                                                                            data-weight="{{ $petOption->weight }}"
                                                                            data-gender="{{ strtolower($petOption->gender) }}">
                                                                            {{ $petOption->name }} ({{ $petOption->category }})
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('pet_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div id="owner_name_container" style="display: none;">
                                                            <label class="form-label required">Owner Name</label>
                                                            <input type="text" id="owner_name" name="owner_name" 
                                                                   class="form-control @error('owner_name') is-invalid @enderror" 
                                                                   value="{{ old('owner_name') }}">
                                                            @error('owner_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="walkin_pet_group" class="col-12" style="{{ isset($owner) && $owner->id == 'no_account' ? '' : 'display: none;' }}">
                                <div class="card h-100">
                                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 10c-1.32 0 -1.983 .421 -2.931 1.924l-.244 .398l-.395 .688a50.89 50.89 0 0 0 -.141 .254c-.24 .434 -.571 .753 -1.139 1.142l-.55 .365c-.94 .627 -1.432 1.118 -1.707 1.955c-.124 .338 -.196 .853 -.193 1.28c0 1.687 1.198 2.994 2.8 2.994l.242 -.006c.119 -.006 .234 -.017 .354 -.034l.248 -.043l.132 -.028l.291 -.073l.162 -.045l.57 -.17l.763 -.243l.455 -.136c.53 -.15 .94 -.222 1.283 -.222c.344 0 .753 .073 1.283 .222l.455 .136l.764 .242l.569 .171l.312 .084c.097 .024 .187 .045 .273 .062l.248 .043c.12 .017 .235 .028 .354 .034l.242 .006c1.602 0 2.8 -1.307 2.8 -3c0 -.427 -.073 -.939 -.207 -1.306c-.236 -.724 -.677 -1.223 -1.48 -1.83l-.257 -.19l-.528 -.38c-.642 -.47 -1.003 -.826 -1.253 -1.278l-.27 -.485l-.252 -.432c-1.011 -1.696 -1.618 -2.099 -3.053 -2.099z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M19.78 7h-.03c-1.219 .02 -2.35 1.066 -2.908 2.504c-.69 1.775 -.348 3.72 1.075 4.333c.256 .109 .527 .163 .801 .163c1.231 0 2.38 -1.053 2.943 -2.504c.686 -1.774 .34 -3.72 -1.076 -4.332a2.05 2.05 0 0 0 -.804 -.164z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M9.025 3c-.112 0 -.185 .002 -.27 .006l-.112 .007l-.118 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.188 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M14.975 3c-.115 0 -.189 .002 -.274 .006l-.113 .007l-.117 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.184 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M4.217 7c-.101 0 -.199 .018 -.289 .055c-1.416 .613 -1.762 2.558 -1.076 4.333c.564 1.45 1.713 2.504 2.943 2.504c.274 0 .545 -.054 .801 -.163c1.423 -.613 1.765 -2.558 1.075 -4.333c-.557 -1.438 -1.69 -2.484 -2.908 -2.504h-.03c-.153 0 -.345 .024 -.516 .108z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                        <h3 class="card-title mb-0">Pet Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M15 8l2 0"></path>
                                                        <path d="M15 12l2 0"></path>
                                                        <path d="M7 16l10 0"></path>
                                                    </svg>
                                                    Pet Name
                                                </label>
                                                <input type="text" id="walkin_pet_name" name="walkin_pet_name" 
                                                       class="form-control @error('walkin_pet_name') is-invalid @enderror">
                                                @error('walkin_pet_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v6h-6z"></path>
                                                        <path d="M14 4h6v6h-6z"></path>
                                                        <path d="M4 14h6v6h-6z"></path>
                                                        <path d="M14 14h6v6h-6z"></path>
                                                    </svg>
                                                        Pet Type
                                                </label>
                                                <select id="walkin_pet_type" name="walkin_pet_type" 
                                                        class="form-select @error('walkin_pet_type') is-invalid @enderror">
                                                    <option value="">Select Pet Type</option>
                                                    <option value="Dog">Dog</option>
                                                    <option value="Cat">Cat</option>
                                                    <option value="Bird">Bird</option>
                                                    <option value="Rabbit">Rabbit</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @error('walkin_pet_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog-bowl" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 15l5.586 -5.585a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-3.587 3.586"></path>
                                                        <path d="M12 13l-3.586 -3.585a2 2 0 1 0 -3.414 -1.415a2 2 0 1 0 1.413 3.414l3.587 3.586"></path>
                                                        <path d="M3 20h18c-.175 -1.671 -.046 -3.345 -2 -5h-14c-1.954 1.655 -1.825 3.329 -2 5z"></path>
                                                    </svg>
                                                    Breed/Species
                                                </label>
                                                <input type="text" id="walkin_pet_breed" name="walkin_pet_breed" 
                                                       class="form-control @error('walkin_pet_breed') is-invalid @enderror">
                                                @error('walkin_pet_breed')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M15 3v4"></path>
                                                        <path d="M7 3v4"></path>
                                                        <path d="M3 11h16"></path>
                                                        <path d="M18 16.496v1.504l1 1"></path>
                                                    </svg>
                                                    Age
                                                </label>
                                                <div class="input-group p-0">
                                                    <input type="number" id="walkin_pet_age" name="walkin_pet_age" 
                                                           class="form-control @error('walkin_pet_age') is-invalid @enderror" min="0">
                                                    <select id="walkin_age_unit" name="walkin_age_unit" class="form-select" style="max-width: 100px;">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                                @error('walkin_pet_age')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scale" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 20l10 0"></path>
                                                        <path d="M6 6l6 -1l6 1"></path>
                                                        <path d="M12 3l0 17"></path>
                                                        <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                        <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                    </svg>
                                                    Weight (kg)
                                                </label>
                                                <input type="number" id="walkin_pet_weight" name="walkin_pet_weight" 
                                                       class="form-control @error('walkin_pet_weight') is-invalid @enderror" 
                                                       step="0.01" min="0">
                                                @error('walkin_pet_weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label required">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-bigender" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M19 3l-5 5"></path>
                                                        <path d="M15 3h4v4"></path>
                                                        <path d="M11 16v6"></path>
                                                        <path d="M8 19h6"></path>
                                                    </svg>
                                                    Gender
                                                </label>
                                                <select id="walkin_pet_gender" name="walkin_pet_gender" 
                                                        class="form-select @error('walkin_pet_gender') is-invalid @enderror">
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                                @error('walkin_pet_gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="registered_pet_details" class="col-12" style="{{ isset($pet) && isset($owner) && $owner->id != 'no_account' ? '' : 'display: none;' }}; min-height: 300px; margin-bottom: 1.5rem;">
                                <div class="card h-100">
                                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 10c-1.32 0 -1.983 .421 -2.931 1.924l-.244 .398l-.395 .688a50.89 50.89 0 0 0 -.141 .254c-.24 .434 -.571 .753 -1.139 1.142l-.55 .365c-.94 .627 -1.432 1.118 -1.707 1.955c-.124 .338 -.196 .853 -.193 1.28c0 1.687 1.198 2.994 2.8 2.994l.242 -.006c.119 -.006 .234 -.017 .354 -.034l.248 -.043l.132 -.028l.291 -.073l.162 -.045l.57 -.17l.763 -.243l.455 -.136c.53 -.15 .94 -.222 1.283 -.222c.344 0 .753 .073 1.283 .222l.455 .136l.764 .242l.569 .171l.312 .084c.097 .024 .187 .045 .273 .062l.248 .043c.12 .017 .235 .028 .354 .034l.242 .006c1.602 0 2.8 -1.307 2.8 -3c0 -.427 -.073 -.939 -.207 -1.306c-.236 -.724 -.677 -1.223 -1.48 -1.83l-.257 -.19l-.528 -.38c-.642 -.47 -1.003 -.826 -1.253 -1.278l-.27 -.485l-.252 -.432c-1.011 -1.696 -1.618 -2.099 -3.053 -2.099z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M19.78 7h-.03c-1.219 .02 -2.35 1.066 -2.908 2.504c-.69 1.775 -.348 3.72 1.075 4.333c.256 .109 .527 .163 .801 .163c1.231 0 2.38 -1.053 2.943 -2.504c.686 -1.774 .34 -3.72 -1.076 -4.332a2.05 2.05 0 0 0 -.804 -.164z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M9.025 3c-.112 0 -.185 .002 -.27 .006l-.112 .007l-.118 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.188 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M14.975 3c-.115 0 -.189 .002 -.274 .006l-.113 .007l-.117 .011c-1.161 .096 -2.119 .789 -2.4 2.111c-.374 1.767 .343 3.428 1.682 3.734l.199 .041l.206 .023c.067 .005 .133 .007 .198 .007c1.212 0 2.313 -.669 2.618 -2.111c.382 -1.805 -.409 -3.652 -1.815 -3.811a3.378 3.378 0 0 0 -.184 -.018z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M4.217 7c-.101 0 -.199 .018 -.289 .055c-1.416 .613 -1.762 2.558 -1.076 4.333c.564 1.45 1.713 2.504 2.943 2.504c.274 0 .545 -.054 .801 -.163c1.423 -.613 1.765 -2.558 1.075 -4.333c-.557 -1.438 -1.69 -2.484 -2.908 -2.504h-.03c-.153 0 -.345 .024 -.516 .108z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                        <h3 class="card-title mb-0">Pet Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M15 8l2 0"></path>
                                                        <path d="M15 12l2 0"></path>
                                                        <path d="M7 16l10 0"></path>
                                                    </svg>
                                                    Pet Name
                                                </label>
                                                <input type="text" id="pet_name" class="form-control" readonly 
                                                       value="{{ isset($pet) ? $pet->name : '' }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v6h-6z"></path>
                                                        <path d="M14 4h6v6h-6z"></path>
                                                        <path d="M4 14h6v6h-6z"></path>
                                                        <path d="M14 14h6v6h-6z"></path>
                                                    </svg>
                                                        Pet Type
                                                </label>
                                                <input type="text" id="pet_category" class="form-control" readonly
                                                               value="{{ isset($pet) ? $pet->category : '' }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dog-bowl" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 15l5.586 -5.585a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-3.587 3.586"></path>
                                                        <path d="M12 13l-3.586 -3.585a2 2 0 1 0 -3.414 -1.415a2 2 0 1 0 1.413 3.414l3.587 3.586"></path>
                                                        <path d="M3 20h18c-.175 -1.671 -.046 -3.345 -2 -5h-14c-1.954 1.655 -1.825 3.329 -2 5z"></path>
                                                    </svg>
                                                    Breed
                                                </label>
                                                <input type="text" id="pet_breed" class="form-control" readonly
                                                               value="{{ isset($pet) ? $pet->breed : '' }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M15 3v4"></path>
                                                        <path d="M7 3v4"></path>
                                                        <path d="M3 11h16"></path>
                                                        <path d="M18 16.496v1.504l1 1"></path>
                                                    </svg>
                                                    Pet Age
                                                </label>
                                                <div class="input-group p-0">
                                                    <input type="number" id="pet_age" class="form-control" readonly
                                                                   value="{{ isset($pet) ? $pet->age : '' }}">
                                                    <select id="age_unit" class="form-select" style="max-width: 100px;" disabled>
                                                        <option value="years" {{ isset($pet) && $pet->age_unit == 'years' ? 'selected' : '' }}>Years</option>
                                                        <option value="months" {{ isset($pet) && $pet->age_unit == 'months' ? 'selected' : '' }}>Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scale" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 20l10 0"></path>
                                                        <path d="M6 6l6 -1l6 1"></path>
                                                        <path d="M12 3l0 17"></path>
                                                        <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                        <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0"></path>
                                                    </svg>
                                                    Weight (kg)
                                                </label>
                                                <input type="number" id="pet_weight" class="form-control" step="0.01" readonly
                                                               value="{{ isset($pet) ? $pet->weight : '' }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-bigender" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M19 3l-5 5"></path>
                                                        <path d="M15 3h4v4"></path>
                                                        <path d="M11 16v6"></path>
                                                        <path d="M8 19h6"></path>
                                                    </svg>
                                                    Gender
                                                </label>
                                                <input type="text" id="pet_gender" class="form-control" readonly
                                                               value="{{ isset($pet) ? ucfirst(strtolower($pet->gender)) : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pet History Card - This will appear when a pet is selected -->
                            <div id="pet_history_card" class="col-12" style="display: none; margin-bottom: 1.5rem;">
                                <div class="card">
                                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 8l0 4l2 2"></path>
                                            <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                                        </svg>
                                        <h3 class="card-title mb-0">Pet History</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="pet_history_loading" class="d-flex justify-content-center align-items-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span class="ms-2">Loading pet history...</span>
                                        </div>
                                        <div id="pet_history_content" style="display: none;">
                                            <div id="no_history_message" class="alert alert-info m-3" style="display: none;">
                                                No previous appointments or findings for this pet.
                                            </div>
                                            <div id="appointment_history_container">
                                                <div class="table-responsive">
                                                    <table class="table table-vcenter card-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Reason</th>
                                                                <th>Status</th>
                                                                <th>Findings</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="appointment_history_list">
                                                            <!-- Appointment history will be populated here -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label required">Date</label>
                                        <input type="text" name="appointment_date" id="appointment_date" class="form-control" 
                                               placeholder="dd/mm/yyyy" required autocomplete="off" 
                                               value="{{ old('appointment_date', isset($appointment) ? $appointment->formatted_date : '') }}">
                                        @error('appointment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label required">Time</label>
                                        <select name="appointment_time" id="appointment_time" class="form-select" required>
                                            <option value="">Select Time</option>
                                            <optgroup label="Morning">
                                                @foreach(['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM'] as $time)
                                                    <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Afternoon">
                                                @foreach(['01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM'] as $time)
                                                    <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        @error('appointment_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" id="today_button" class="btn btn-outline-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M16 3l0 4" />
                                                <path d="M8 3l0 4" />
                                                <path d="M4 11l16 0" />
                                                <path d="M8 15h2v2h-2z" />
                                            </svg>
                                            Today
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Reason for Visit</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @foreach([
                                        'Vaccination' => [
                                            'icon' => 'vaccine',
                                            'sub' => ['Anti-rabies', 'DHPP', 'FVRCP', 'Deworming']
                                        ],
                                        'Check-up' => [
                                            'icon' => 'stethoscope',
                                            'sub' => ['Routine', 'Follow-up', 'Emergency']
                                        ],
                                        'Grooming' => [
                                            'icon' => 'cut',
                                            'sub' => ['Full Service', 'Nail Trim', 'Dental']
                                        ],
                                        'Surgery' => [
                                            'icon' => 'scalpel',
                                            'sub' => ['Spay/Neuter', 'Minor', 'Major']
                                        ],
                                        'Laboratory' => [
                                            'icon' => 'test-pipe',
                                            'sub' => ['Blood Test', 'Urinalysis', 'X-ray']
                                        ]
                                    ] as $category => $details)
                                        <button type="button" 
                                            class="btn reason-btn" 
                                            data-reason="{{ $category }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-{{ $details['icon'] }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                @if($details['icon'] === 'vaccine')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M17 3l4 4"></path>
                                                    <path d="M19 5l-4.5 4.5"></path>
                                                    <path d="M11.5 6.5l6 6"></path>
                                                    <path d="M16.5 11.5l-6.5 6.5h-4v-4l6.5 -6.5"></path>
                                                    <path d="M7.5 12.5l1.5 1.5"></path>
                                                    <path d="M10.5 9.5l1.5 1.5"></path>
                                                    <path d="M3 21l3 -3"></path>
                                                @elseif($details['icon'] === 'stethoscope')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"></path>
                                                    <path d="M8 15a6 6 0 1 0 12 0v-3"></path>
                                                    <path d="M11 3v2"></path>
                                                    <path d="M6 3v2"></path>
                                                    <circle cx="20" cy="10" r="2"></circle>
                                                @elseif($details['icon'] === 'cut')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <circle cx="6" cy="7" r="3"></circle>
                                                    <circle cx="6" cy="17" r="3"></circle>
                                                    <line x1="8.7" y1="8.7" x2="19" y2="19"></line>
                                                    <line x1="8.7" y1="15.3" x2="19" y2="5"></line>
                                                @elseif($details['icon'] === 'scalpel')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M19 5l-12.5 12.5a4.95 4.95 0 0 1 -7 -7l12.5 -12.5a1 1 0 0 1 1.414 0l5.586 5.586a1 1 0 0 1 0 1.414z"></path>
                                                    <path d="M18 6l-11.5 11.5"></path>
                                                @elseif($details['icon'] === 'test-pipe')
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 8.04l-12.122 12.124a2.857 2.857 0 1 1 -4.041 -4.04l12.122 -12.124"></path>
                                                    <path d="M7 13h8"></path>
                                                    <path d="M19 15l1.5 1.6a2 2 0 1 1 -3 0l1.5 -1.6z"></path>
                                                    <path d="M15 3l6 6"></path>
                                                @endif
                                            </svg>
                                            {{ $category }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="selected-reasons-box">
                                    <div id="selected-reasons" class="d-flex flex-wrap gap-2"></div>
                                    <div id="empty-reason-text" class="text-muted">No reasons selected</div>
                                </div>
                                <input type="hidden" name="reason_for_visit" id="reason_for_visit" required>
                                @error('reason_for_visit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information about the visit..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5"></path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M16 19h6"></path>
                                <path d="M19 16v6"></path>
                            </svg>
                            Schedule Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Add this at the beginning of your script
    window.addEventListener('error', function(e) {
        console.error('JavaScript error occurred:', e.message);
        console.error('File:', e.filename);
        console.error('Line:', e.lineno);
        console.error('Column:', e.colno);
    });

    // Define global variables and functions first
    let reasonButtons;
    let selectedReasons = new Set();
    
    // Define clearPetDetails function globally so it's available across all event handlers
    function clearPetDetails() {
        console.log('Clearing pet details');
        
        // Clear form fields
        const fieldsToReset = [
            'pet_name', 'pet_type', 'pet_category', 'pet_breed', 'pet_age', 
            'pet_weight', 'pet_gender'
        ];
        
        fieldsToReset.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) field.value = '';
        });
        
        // Reset pet avatar if it exists
        const avatarField = document.getElementById('dynamic_avatar');
        if (avatarField) {
            avatarField.src = '/storage/defaults/paw.png';
            avatarField.alt = 'Default Pet Avatar';
        }
    }
    
    // Error handling for external scripts
    window.addEventListener('error', function(e) {
        // This remains the same as your existing code
        console.error('External script error:', e.message);
        e.preventDefault();
        e.stopPropagation();
        return true; // Prevents the error from bubbling up
    }, true);

    // Also catch unhandled promise rejections (for fetch promises)
    window.addEventListener('unhandledrejection', function(e) {
        if (e.reason && (String(e.reason).includes('fetch') || String(e.reason).includes('Failed to'))) {
            console.warn('Unhandled promise rejection suppressed:', e.reason);
            e.preventDefault();
            e.stopPropagation();
        }
    }, true);

    // DOM Content Loaded event - initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document loaded, initializing appointment creation page');
        
        // Initialize variables at the beginning of the function
        reasonButtons = document.querySelectorAll('.reason-btn');
        const otherReasonBtn = document.getElementById('other-reason-btn');
        const otherReasonGroup = document.getElementById('other_reason_group');
        const otherReasonInput = document.getElementById('other_reason');
        const addOtherReasonBtn = document.getElementById('add-other-reason');
        const selectedReasonsContainer = document.getElementById('selected-reasons');
        const reasonForVisitInput = document.getElementById('reason_for_visit');
        const emptyReasonText = document.getElementById('empty-reason-text');
        
        // Immediately clean URL on page load
        try {
            const originalUrl = window.location.href;
            const cleanUrl = originalUrl.split('?')[0];
            console.log('Cleaning URL from', originalUrl, 'to', cleanUrl);
            history.replaceState(null, document.title, cleanUrl);
        } catch (e) {
            console.error('Error cleaning URL:', e);
        }
        
        try {
            // Extract parameters before they're removed from URL
            const urlSearchParams = new URLSearchParams(window.location.search);
            const petId = urlSearchParams.get('pet_id');
            const ownerId = urlSearchParams.get('owner_id');
            
            console.log('URL parameters detected:', { petId, ownerId });
            
            if (petId && ownerId) {
                const ownerSelect = document.getElementById('owner_id');
                if (ownerSelect) {
                    console.log('Setting owner ID to', ownerId);
                    ownerSelect.value = ownerId;
                    
                    // Create a promise-based approach to handle the sequential operations
                    const loadPets = new Promise((resolve) => {
                        // Set up one-time event listener for when pets are loaded
                        document.addEventListener('pets-loaded', function handler() {
                            document.removeEventListener('pets-loaded', handler);
                            resolve();
                        }, { once: true });
                        
                        // Trigger the owner change event
                        ownerSelect.dispatchEvent(new Event('change'));
                    });
                    
                    // Once pets are loaded, then set the pet
                    loadPets.then(() => {
                        const petSelect = document.getElementById('pet_id');
                        if (petSelect) {
                            console.log('Setting pet ID to', petId);
                            petSelect.value = petId;
                            petSelect.dispatchEvent(new Event('change'));
                        } else {
                            console.warn('Pet select not found');
                        }
                    });
                } else {
                    console.warn('Owner select not found');
                }
            }
        } catch (e) {
            console.error('Error processing URL parameters:', e);
        }
    });

    // Prevent query parameters from persisting in navigation
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.href.startsWith('javascript:') && !link.href.startsWith('#')) {
            try {
                const url = new URL(link.href);
                if (!url.search) return; // No query params to clean
                
                // Don't modify URLs that need their parameters
                const preserveParamsPatterns = [
                    '/appointments/create', 
                    '/pets/edit/',
                    '/users/edit/'
                ];
                
                const shouldPreserveParams = preserveParamsPatterns.some(pattern => 
                    url.pathname.includes(pattern));
                
                if (!shouldPreserveParams) {
                    link.href = url.origin + url.pathname;
                }
            } catch (e) {
                console.error('Error processing link:', e);
            }
        }
    });

    const userSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');

    const existingUserId = '{{ old("owner_id", $appointment->owner_id ?? "") }}';
    const existingOwnerName = '{{ old("owner_name", $appointment->owner_name ?? "") }}';

    if (existingOwnerName && !existingUserId) {
        userSelect.value = 'no_account';
        ownerNameGroup.style.display = 'block';
        petSelectionGroup.style.display = 'none';
        ownerNameInput.value = existingOwnerName;
    } else if (existingUserId) {
        userSelect.value = existingUserId;
        userSelect.dispatchEvent(new Event('change'));
    }

    userSelect.addEventListener('change', function() {
        const userId = this.value;
        const ownerNameGroup = document.getElementById('owner_name_group');
        const petSelectionGroup = document.getElementById('pet_selection_group');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        if (userId === 'no_account') {
            ownerNameGroup.style.display = 'block';
            petSelectionGroup.style.display = 'none';
            walkinPetGroup.style.display = 'block';
            registeredPetDetails.style.display = 'none';
            
            document.getElementById('owner_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            document.getElementById('walkin_pet_weight').setAttribute('required', 'required');
            document.getElementById('walkin_pet_gender').setAttribute('required', 'required');
            
            document.getElementById('pet_id').removeAttribute('required');
            
            clearPetDetails();
        } else {
            ownerNameGroup.style.display = 'none';
            petSelectionGroup.style.display = 'block';
            walkinPetGroup.style.display = 'none';
            registeredPetDetails.style.display = 'flex';
            
            document.getElementById('pet_id').setAttribute('required', 'required');
            
            document.getElementById('owner_name').removeAttribute('required');
            document.getElementById('walkin_pet_name').removeAttribute('required');
            document.getElementById('walkin_pet_type').removeAttribute('required');
            document.getElementById('walkin_pet_age').removeAttribute('required');
            document.getElementById('walkin_pet_weight').removeAttribute('required');
            document.getElementById('walkin_pet_gender').removeAttribute('required');
            
            if (userId) {
                loadPetsForOwner(userId);
            } else {
                clearPetSelect();
            }
        }
    });

    function loadPetsForOwner(userId) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Loading pets...</option>';
        clearPetDetails();

        fetch(`/api/users/${userId}/pets`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                updatePetSelect(data.pets);
            })
            .catch(error => {
                console.error('Error:', error);
                petSelect.innerHTML = '<option value="">Error loading pets</option>';
            });
    }

    function updatePetSelect(pets) {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        
        if (Array.isArray(pets) && pets.length > 0) {
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.text = `${pet.name} (${pet.category})`;
                
                option.dataset.name = pet.name || '';
                option.dataset.category = pet.category || '';
                option.dataset.type = pet.type || pet.category || '';
                option.dataset.breed = pet.breed || '';
                option.dataset.age = pet.age ? pet.age.toString() : '';
                option.dataset.weight = pet.weight ? pet.weight.toString() : '';
                option.dataset.gender = pet.gender ? 
                    pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : '';
                
                petSelect.appendChild(option);
            });
        } else {
            petSelect.innerHTML = '<option value="">No pets found</option>';
        }
    }

    function clearPetSelect() {
        const petSelect = document.getElementById('pet_id');
        petSelect.innerHTML = '<option value="">Choose a pet</option>';
        clearPetDetails();
    }

    petSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const dynamicAvatar = document.getElementById('dynamic_avatar');
        
        if (!this.value) {
            clearPetDetails();
            if (dynamicAvatar) {
                dynamicAvatar.src = '/storage/defaults/paw.png';
            }
            return;
        }
        
        const petData = {
            name: selectedOption.dataset.name,
            category: selectedOption.dataset.category,
            breed: selectedOption.dataset.breed,
            age: selectedOption.dataset.age,
            weight: selectedOption.dataset.weight,
            gender: selectedOption.dataset.gender,
            photo: selectedOption.dataset.photo
        };
        
        const fields = {
            'pet_name': petData.name,
            'pet_category': petData.category,
            'pet_breed': petData.breed,
            'pet_age': petData.age,
            'pet_weight': petData.weight,
            'pet_gender': petData.gender
        };

        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value || '';
            }
        });

        if (dynamicAvatar) {
            dynamicAvatar.src = petData.photo || '/storage/defaults/paw.png';
        }

        try {
            const response = await fetch(`/api/pets/${this.value}`);
            if (!response.ok) throw new Error('Failed to fetch pet data');
            const apiPetData = await response.json();
            
            updatePetDetails(apiPetData);
            
            if (dynamicAvatar && apiPetData.photo) {
                dynamicAvatar.src = '/storage/' + apiPetData.photo;
            }
        } catch (error) {
            console.error('Error fetching pet data:', error);
        }
    });

    function updatePetDetails(petData) {
        if (!petData) return;
        
        const fields = {
            'pet_name': petData.name,
            'pet_category': petData.category,
            'pet_breed': petData.breed,
            'pet_age': petData.age,
            'pet_weight': petData.weight,
            'pet_gender': petData.gender
        };

        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value || '';
            }
        });
    }

    function updateReasonInput() {
        const reasonsArray = Array.from(selectedReasons);
        reasonForVisitInput.value = reasonsArray.join(', ');
        
        updateSelectedReasonsDisplay();
        
        const emptyReasonText = document.getElementById('empty-reason-text');
        if (reasonsArray.length > 0) {
            emptyReasonText.style.display = 'none';
        } else {
            emptyReasonText.style.display = 'block';
        }
    }

    function createReasonBadge(reason) {
        const badge = document.createElement('div');
        badge.className = 'badge d-flex align-items-center gap-2';
        badge.innerHTML = `
            ${reason}
            <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
        `;

        badge.querySelector('.btn-close').addEventListener('click', function() {
            selectedReasons.delete(reason);
            badge.remove();
            
            const button = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
            if (button) {
                button.classList.remove('active');
            }
            
            updateReasonInput();
        });

        return badge;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Define reasonButtons inside the DOMContentLoaded event to ensure elements are loaded
        const reasonButtons = document.querySelectorAll('.reason-btn');
        console.log('Found reason buttons:', reasonButtons.length);
        
        if (reasonButtons.length === 0) {
            console.error('No reason buttons found. Check class names.');
        }
        
        // Initialize selectedReasons set
        let selectedReasons = new Set();
        
        // Get the hidden input for storing reasons
        const reasonForVisitInput = document.getElementById('reason_for_visit');
        
        reasonButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const reason = this.dataset.reason;
                console.log(`Reason button clicked: ${reason}`);
                
                if (this.classList.contains('active')) {
                    this.classList.remove('active');
                    selectedReasons.delete(reason);
                    console.log(`Removed reason: ${reason}`);
                } else {
                    this.classList.add('active');
                    selectedReasons.add(reason);
                    console.log(`Added reason: ${reason}`);
                }

                updateReasonInput();
            });
        });
        
        function updateReasonInput() {
            const reasonsArray = Array.from(selectedReasons);
            reasonForVisitInput.value = reasonsArray.join(', ');
            
            updateSelectedReasonsDisplay();
            
            const emptyReasonText = document.getElementById('empty-reason-text');
            if (reasonsArray.length > 0) {
                emptyReasonText.style.display = 'none';
            } else {
                emptyReasonText.style.display = 'block';
            }
        }
        
        function updateSelectedReasonsDisplay() {
            const selectedReasonsContainer = document.getElementById('selected-reasons');
            const emptyReasonText = document.getElementById('empty-reason-text');
            
            selectedReasonsContainer.innerHTML = '';
            
            const reasonsArray = Array.from(selectedReasons);
            
            if (reasonsArray.length > 0) {
                emptyReasonText.style.display = 'none';
                
                reasonsArray.forEach(reason => {
                    const badge = createReasonBadge(reason);
                    selectedReasonsContainer.appendChild(badge);
                });
            } else {
                emptyReasonText.style.display = 'block';
            }
        }
        
        function createReasonBadge(reason) {
            const badge = document.createElement('div');
            badge.className = 'badge d-flex align-items-center gap-2';
            badge.innerHTML = `
                ${reason}
                <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
            `;

            badge.querySelector('.btn-close').addEventListener('click', function() {
                selectedReasons.delete(reason);
                badge.remove();
                
                const button = document.querySelector(`.reason-btn[data-reason="${reason}"]`);
                if (button) {
                    button.classList.remove('active');
                }
                
                updateReasonInput();
            });

            return badge;
        }
    });

    otherReasonBtn.addEventListener('click', function() {
        otherReasonGroup.style.display = otherReasonGroup.style.display === 'none' ? 'block' : 'none';
    });

    otherReasonInput.addEventListener('input', function() {
        if (this.value.trim()) {
            selectedReasons.add('Other: ' + this.value.trim());
        } else {
            const otherReasons = Array.from(selectedReasons).filter(r => r.startsWith('Other: '));
            otherReasons.forEach(r => selectedReasons.delete(r));
        }
        updateReasonInput();
    });

    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedDate = document.getElementById('appointment_date').value;
        const selectedTime = document.getElementById('appointment_time').value;
        
        if (!selectedDate || !selectedTime) {
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                text: 'Please select both date and time for the appointment.',
            });
            return;
        }
        
        if (selectedReasons.size === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                text: 'Please select at least one reason for the visit.',
            });
            return;
        }
        
        this.submit();
    });

    function initializeDatePicker() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const datePicker = document.getElementById('appointment_date');
        datePicker.min = tomorrow.toISOString().split('T')[0];
        
        datePicker.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();
            
            const timeSelect = document.getElementById('appointment_time');
            timeSelect.innerHTML = '';
            
            if (dayOfWeek === 0) {
                timeSelect.innerHTML = '<option value="">Clinic is closed on Sundays</option>';
                timeSelect.disabled = true;
                return;
            }
            
            timeSelect.disabled = false;
            
            const timeSlots = generateTimeSlots(dayOfWeek === 6);
            timeSlots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = slot;
                timeSelect.appendChild(option);
            });
        });
    }

    function generateTimeSlots(isSaturday) {
        const slots = [];
        const startHour = 8;
        const endHour = isSaturday ? 12 : 17;
        
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                const formattedHour = hour.toString().padStart(2, '0');
                const formattedMinute = minute.toString().padStart(2, '0');
                slots.push(`${formattedHour}:${formattedMinute}`);
            }
        }
        
        return slots;
    }

    initializeDatePicker();
});

document.getElementById('pet_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (!this.value) {
        clearPetDetails();
        return;
    }
    
    document.getElementById('pet_name').value = selectedOption.text.split(' (')[0] || '';
    document.getElementById('pet_type').value = selectedOption.dataset.type || '';
    document.getElementById('pet_age').value = selectedOption.dataset.age || '';
    document.getElementById('pet_weight').value = selectedOption.dataset.weight || '';
    document.getElementById('pet_gender').value = selectedOption.dataset.gender || '';
});

const ownerSelect = document.getElementById('owner_id');
const ownerAvatar = document.getElementById('owner_avatar');

ownerSelect.addEventListener('change', async function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (selectedOption.value === 'no_account') {
        ownerAvatar.src = '/storage/defaults/avatar.png';
    } else if (selectedOption.value) {
        try {
            const response = await fetch(`/api/owners/${selectedOption.value}`);
            if (!response.ok) throw new Error('Failed to fetch owner data');
            const ownerData = await response.json();
            
            ownerAvatar.src = ownerData.photo ? 
                '/storage/' + ownerData.photo : 
                '/storage/defaults/avatar.png';
        } catch (error) {
            console.error('Error:', error);
            ownerAvatar.src = '/storage/defaults/avatar.png';
        }
    } else {
        ownerAvatar.src = '/storage/defaults/avatar.png';
    }
});

const petSelect = document.getElementById('pet_id');
const petAvatar = document.getElementById('pet_avatar');

petSelect.addEventListener('change', async function() {
    const selectedOption = this.options[this.selectedIndex];
    const dynamicAvatar = document.getElementById('dynamic_avatar'); // Get the avatar element
    
    if (!dynamicAvatar) {
        console.error('Dynamic avatar element not found');
        return;
    }
    
    if (selectedOption && selectedOption.value) {
        try {
            const response = await fetch(`/api/pets/${selectedOption.value}`);
            if (!response.ok) throw new Error('Failed to fetch pet data');
            const petData = await response.json();
            
            dynamicAvatar.src = petData.photo ? 
                '/storage/' + petData.photo : 
                '/storage/defaults/paw.png';
                
            updatePetDetails(petData);
        } catch (error) {
            console.error('Error:', error);
            if (dynamicAvatar) {
                dynamicAvatar.src = '/storage/defaults/paw.png';
            }
        }
    } else {
        if (dynamicAvatar) {
            dynamicAvatar.src = '/storage/defaults/paw.png';
        }
        clearPetDetails();
    }
});

function updatePetsDropdown(pets) {
    const petSelect = document.getElementById('pet_id');
    if (!petSelect) return;

    petSelect.innerHTML = '<option value="">Select Pet</option>';
    pets.forEach(pet => {
        const option = document.createElement('option');
        option.value = pet.id;
        option.textContent = `${pet.name} (${pet.category})`;
        
        option.setAttribute('data-photo', pet.photo ? '/storage/' + pet.photo : '/storage/defaults/paw.png');
        option.setAttribute('data-name', pet.name || '');
        option.setAttribute('data-category', pet.category || '');
        option.setAttribute('data-breed', pet.breed || '');
        option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
        option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
        option.setAttribute('data-gender', pet.gender ? pet.gender.toLowerCase() : '');
        
        petSelect.appendChild(option);
    });
    
    console.log(`Pet dropdown updated with ${pets.length} pets`);
    
    // Add this line to signal that pets are loaded
    document.dispatchEvent(new CustomEvent('pets-loaded'));
}

document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('owner_id');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameDisplay = document.getElementById('owner_name_display');
    const ownerNameValue = document.getElementById('owner_name_value');
    const ownerNameInput = document.getElementById('owner_name');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    userSelect.addEventListener('change', function() {
        const isWalkIn = this.value === 'no_account';
        
        petSelectContainer.style.display = isWalkIn ? 'none' : 'block';
        ownerNameDisplay.style.display = isWalkIn ? 'block' : 'none';
        registeredPetDetails.style.display = isWalkIn ? 'none' : 'block';
        
        if (isWalkIn) {
            ownerNameInput.addEventListener('input', function() {
                ownerNameValue.textContent = this.value || 'Not specified';
            });
        }
    });

    if (userSelect.value === 'no_account') {
        petSelectContainer.style.display = 'none';
        ownerNameDisplay.style.display = 'block';
        registeredPetDetails.style.display = 'none';
        ownerNameValue.textContent = ownerNameInput.value || 'Not specified';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const ownerAvatar = document.getElementById('owner_avatar');
    const dynamicAvatar = document.getElementById('dynamic_avatar');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameContainer = document.getElementById('owner_name_container');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');

    const defaultAvatarPath = '/storage/defaults/avatar.png';
    const defaultPawPath = '/storage/defaults/paw.png';

    // Remove all existing change event listeners (important to avoid duplicates)
    const newOwnerSelect = ownerSelect.cloneNode(true);
    ownerSelect.parentNode.replaceChild(newOwnerSelect, ownerSelect);
    
    // Single, consolidated event listener
    newOwnerSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const isWalkIn = this.value === 'no_account';
        
        // First, immediately update UI without waiting for fetch
        if (isWalkIn) {
            ownerAvatar.src = defaultAvatarPath;
            ownerAvatar.alt = 'Default Owner Avatar';
            
            if (dynamicAvatar) {
                dynamicAvatar.src = defaultPawPath;
                dynamicAvatar.alt = 'Walk-in Pet Avatar';
            }
            
            if (petSelectContainer) petSelectContainer.style.display = 'none';
            if (ownerNameContainer) ownerNameContainer.style.display = 'block';
            if (walkinPetGroup) walkinPetGroup.style.display = 'block';
            if (registeredPetDetails) registeredPetDetails.style.display = 'none';
            
            const ownerNameInput = document.getElementById('owner_name');
            const petSelect = document.getElementById('pet_id');
            
            if (ownerNameInput) ownerNameInput.setAttribute('required', 'required');
            if (petSelect) petSelect.removeAttribute('required');
        } 
        else if (selectedOption && this.value) {
            // Get avatar from data attribute first (for immediate display)
            const avatarFromData = selectedOption.getAttribute('data-avatar');
            if (avatarFromData) {
                ownerAvatar.src = avatarFromData;
                ownerAvatar.alt = selectedOption.text + ' Avatar';
            }
            
            if (petSelectContainer) petSelectContainer.style.display = 'block';
            if (ownerNameContainer) ownerNameContainer.style.display = 'none';
            if (walkinPetGroup) walkinPetGroup.style.display = 'none';
            if (registeredPetDetails) registeredPetDetails.style.display = 'block';
            
            const ownerNameInput = document.getElementById('owner_name');
            const petSelect = document.getElementById('pet_id');
            
            if (ownerNameInput) ownerNameInput.removeAttribute('required');
            if (petSelect) petSelect.setAttribute('required', 'required');
            
            // Then do the API call to get pets
            try {
                console.log('Fetching pets for owner ID:', this.value);
                const response = await fetch(`/api/owners/${this.value}/pets`);
                
                if (!response.ok) {
                    throw new Error('Failed to fetch pets data');
                }
                
                const petsData = await response.json();
                updatePetsDropdown(petsData);
            } catch (error) {
                console.error('Error fetching pets:', error);
                
                if (petSelect) {
                    petSelect.innerHTML = '<option value="">Error loading pets</option>';
                }
            }
        } 
        else {
            // No selection
            ownerAvatar.src = defaultAvatarPath;
            ownerAvatar.alt = 'Default Owner Avatar';
            
            if (dynamicAvatar) {
                dynamicAvatar.src = defaultPawPath;
                dynamicAvatar.alt = 'Default Pet Avatar';
            }
            
            if (petSelectContainer) petSelectContainer.style.display = 'block';
            if (ownerNameContainer) ownerNameContainer.style.display = 'none';
            if (walkinPetGroup) walkinPetGroup.style.display = 'none';
            if (registeredPetDetails) registeredPetDetails.style.display = 'block';
            
            if (petSelect) {
                petSelect.innerHTML = '<option value="">Select Pet</option>';
            }
        }
    });

    // If there's an initial selection, trigger the change event
    if (newOwnerSelect.value) {
        newOwnerSelect.dispatchEvent(new Event('change'));
    }
    
    // Rest of your initialization code...
});

function updatePetDetails(selectedOption) {
    if (!selectedOption) return;
    
    const dataset = selectedOption.dataset;

    const petPhotoElement = document.getElementById('pet-photo');
    const petNameElement = document.getElementById('pet-name');
    const petCategoryElement = document.getElementById('pet-category');
    const petBreedElement = document.getElementById('pet-breed');
    const petAgeElement = document.getElementById('pet-age');
    const petWeightElement = document.getElementById('pet-weight');
    const petGenderElement = document.getElementById('pet-gender');

    if (petPhotoElement) {
        petPhotoElement.src = dataset.photo || '/path/to/default-image.jpg';
        petPhotoElement.alt = `Photo of ${dataset.name}`;
    }

    if (petNameElement) petNameElement.textContent = dataset.name || '';
    if (petCategoryElement) petCategoryElement.textContent = dataset.category || '';
    if (petBreedElement) petBreedElement.textContent = dataset.breed || '';
    if (petAgeElement) petAgeElement.textContent = dataset.age ? `${dataset.age} years` : '';
    if (petWeightElement) petWeightElement.textContent = dataset.weight ? `${dataset.weight} kg` : '';
    if (petGenderElement) petGenderElement.textContent = dataset.gender || '';
}

document.getElementById('pet_id').addEventListener('change', function(e) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    updatePetDetails(selectedOption);
});

document.getElementById('pet_id').addEventListener('change', async function() {
    const petId = this.value;
    const petAvatar = document.getElementById('dynamic_avatar');
    const defaultPawImage = '{{ asset("storage/defaults/paw.png") }}';
    
    const currentSrc = petAvatar.src;
    
    if (!petId) {
        petAvatar.src = defaultPawImage;
        return;
    }
    
    try {
        const cachedResponse = await caches.match(`/api/pets/${petId}`);
        let petData;
        
        if (cachedResponse) {
            petData = await cachedResponse.json();
        } else {
            const response = await fetch(`/api/pets/${petId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            petData = await response.json();
        }
        
        console.log('Updating pet details with:', petData);
        
        if (petData.photo_url) {
            const tempImg = new Image();
            
            tempImg.onload = function() {
                petAvatar.src = petData.photo_url;
            };
            
            tempImg.onerror = function() {
                console.error('Failed to load pet image');
                petAvatar.src = defaultPawImage;
            };
            
            // Start loading the image
            tempImg.src = petData.photo_url;
        } else {
            petAvatar.src = defaultPawImage;
        }
        
        updatePetDetails(petData);
    } catch (error) {
        console.error('Error fetching pet data:', error);
        petAvatar.src = defaultPawImage;
    }
});

function updatePetDetails(petData) {
    const petDetailsElements = {
        'pet-name': petData.name,
        'pet-category': petData.category,
        'pet-breed': petData.breed,
        'pet-age': petData.age,
        'pet-weight': petData.weight,
        'pet-gender': petData.gender
    };
    
    Object.entries(petDetailsElements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value || '-';
        }
    });
}

// Find the function that updates pet details (it might have a name like updatePetDetails)
function updatePetDetails(option) {
    console.log('Updating pet details from option:', option);
    
    if (!option || option.value === '') {
        console.log('No pet selected or invalid option');
        return;
    }
    
    // Log all data attributes before using them
    const dataAttrs = {
        photo: option.getAttribute('data-photo'),
        name: option.getAttribute('data-name'),
        category: option.getAttribute('data-category'),
        breed: option.getAttribute('data-breed'),
        age: option.getAttribute('data-age'),
        weight: option.getAttribute('data-weight'),
        gender: option.getAttribute('data-gender')
    };
    console.log('Pet data attributes:', dataAttrs);
    
    // Added check for each input element before setting value
    const nameField = document.getElementById('pet_name');
    if (nameField) {
        nameField.value = dataAttrs.name || '';
        console.log('Set pet name:', nameField.value);
    } else {
        console.warn('pet_name field not found');
    }
    
    const categoryField = document.getElementById('pet_category');
    if (categoryField) {
        categoryField.value = dataAttrs.category || '';
        console.log('Set pet category:', categoryField.value);
    } else {
        console.warn('pet_category field not found');
    }
    
    const breedField = document.getElementById('pet_breed');
    if (breedField) {
        breedField.value = dataAttrs.breed || '';
        console.log('Set pet breed:', breedField.value);
    } else {
        console.warn('pet_breed field not found');
    }
    
    const ageField = document.getElementById('pet_age');
    if (ageField) {
        ageField.value = dataAttrs.age || '';
        console.log('Set pet age:', ageField.value);
    } else {
        console.warn('pet_age field not found');
    }
    
    const weightField = document.getElementById('pet_weight');
    if (weightField) {
        weightField.value = dataAttrs.weight || '';
        console.log('Set pet weight:', weightField.value);
    } else {
        console.warn('pet_weight field not found');
    }
    
    const genderField = document.getElementById('pet_gender');
    if (genderField) {
        genderField.value = dataAttrs.gender || '';
        console.log('Set pet gender:', genderField.value);
    } else {
        console.warn('pet_gender field not found');
    }
    
    // Get the dynamic avatar element
    const dynamicAvatar = document.getElementById('dynamic_avatar');
    if (dynamicAvatar && dataAttrs.photo) {
        dynamicAvatar.src = dataAttrs.photo;
        console.log('Set pet avatar src:', dynamicAvatar.src);
    } else {
        console.warn('dynamic_avatar element not found or no photo attribute');
    }
}

// Make sure this function is called when a pet is selected
document.getElementById('pet_id').addEventListener('change', function() {
    console.log('Pet select changed to:', this.value);
    if (this.value) {
        const selectedOption = this.options[this.selectedIndex];
        console.log('Selected option:', selectedOption);
        updatePetDetails(selectedOption);
    } else {
        console.log('No pet selected, clearing details');
        // Add your code to clear pet details
    }
});

// Add this new code for appointment type selection
document.addEventListener('DOMContentLoaded', function() {
    // Get all appointment type buttons
    const appointmentButtons = document.querySelectorAll('[data-appointment-type]');
    
    // Add click event listener to each button
    appointmentButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the appointment type
            const appointmentType = this.getAttribute('data-appointment-type');
            console.log('Appointment type selected:', appointmentType);
            
            // Remove 'active' class from all buttons
            appointmentButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-secondary');
            });
            
            // Add 'active' class to the clicked button
            this.classList.add('active');
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary');
            
            // Set the hidden input value
            document.getElementById('appointment_type').value = appointmentType;
            
            // Load the appropriate service form if needed
            loadServiceForm(appointmentType);
        });
    });
});

function loadServiceForm(serviceType) {
    // existing code...
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');
    const petSelectContainer = document.getElementById('pet_select_container');
    const ownerNameContainer = document.getElementById('owner_name_container');
    const walkinPetGroup = document.getElementById('walkin_pet_group');
    const registeredPetDetails = document.getElementById('registered_pet_details');
    const dynamicAvatar = document.getElementById('dynamic_avatar');
    const ownerAvatar = document.getElementById('owner_avatar');
    
    // Initialize form state based on pre-selected values
    updateFormState();
    
    // For pre-filled forms, also update pet details if pet is selected
    if (petSelect.value) {
        const selectedOption = petSelect.options[petSelect.selectedIndex];
        if (selectedOption) {
            updateRegisteredPetDetails(selectedOption);
        }
    }
    
    // Handle owner selection change
    ownerSelect.addEventListener('change', function() {
        updateFormState();
        
        // Update owner avatar
        if (this.value !== 'no_account' && this.value !== '') {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.avatar) {
                ownerAvatar.src = selectedOption.dataset.avatar;
            }
        } else {
            ownerAvatar.src = "{{ asset('storage/defaults/avatar.png') }}";
        }
    });
    
    // Handle pet selection change
    petSelect.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            updateRegisteredPetDetails(selectedOption);
        }
    });
    
    function updateFormState() {
        const isWalkin = ownerSelect.value === 'no_account';
        
        // Show/hide appropriate form sections
        petSelectContainer.style.display = isWalkin ? 'none' : 'block';
        ownerNameContainer.style.display = isWalkin ? 'block' : 'none';
        walkinPetGroup.style.display = isWalkin ? 'block' : 'none';
        registeredPetDetails.style.display = !isWalkin && petSelect.value ? 'block' : 'none';
        
        // Update required attributes
        if (isWalkin) {
            petSelect.removeAttribute('required');
            document.getElementById('owner_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_name').setAttribute('required', 'required');
            document.getElementById('walkin_pet_type').setAttribute('required', 'required');
            document.getElementById('walkin_pet_breed').setAttribute('required', 'required');
            document.getElementById('walkin_pet_age').setAttribute('required', 'required');
            document.getElementById('walkin_pet_weight').setAttribute('required', 'required');
            document.getElementById('walkin_pet_gender').setAttribute('required', 'required');
        } else {
            petSelect.setAttribute('required', 'required');
            document.getElementById('owner_name').removeAttribute('required');
        }
    }
    
    function updateRegisteredPetDetails(selectedOption) {
        if (selectedOption && selectedOption.dataset) {
            // Update pet avatar
            if (dynamicAvatar && selectedOption.dataset.photo) {
                dynamicAvatar.src = selectedOption.dataset.photo;
            }
            
            // Update pet details
            document.getElementById('pet_name').value = selectedOption.dataset.name || '';
            document.getElementById('pet_category').value = selectedOption.dataset.category || '';
            document.getElementById('pet_breed').value = selectedOption.dataset.breed || '';
            document.getElementById('pet_age').value = selectedOption.dataset.age || '';
            document.getElementById('pet_weight').value = selectedOption.dataset.weight || '';
            document.getElementById('pet_gender').value = selectedOption.dataset.gender ? 
                (selectedOption.dataset.gender.charAt(0).toUpperCase() + selectedOption.dataset.gender.slice(1)) : '';
            
            // Show registered pet details
            registeredPetDetails.style.display = 'block';
        }
    }
});
</script>
@endpush

@push('scripts')
<script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        let isValid = true;
        
        const requiredFields = this.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'This field is required';
                field.parentNode.appendChild(feedback);
            }
        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }
    });
</script>
@endpush

@push('scripts')
<script>
    const reasonSelect = document.querySelector('select[name="reason_for_visit"]');
    const vaccinationDetails = document.getElementById('vaccination-details');
    const serviceDetailsContainer = document.getElementById('service-details-container');
    
    serviceDetailsContainer.appendChild(vaccinationDetails);
    
    function toggleVaccinationDetails() {
        const isVaccination = reasonSelect.value === 'Vaccination';
        vaccinationDetails.style.display = isVaccination ? 'block' : 'none';
        
        const requiredFields = vaccinationDetails.querySelectorAll('input[required], select[required]');
        requiredFields.forEach(field => {
            if (isVaccination) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }
</script>
@endpush

@push('scripts')
<script>
    const defaultAvatarPath = "{{ asset('storage/defaults/avatar.png') }}";
    const defaultPawPath = "{{ asset('storage/defaults/paw.png') }}";
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing appointment form...');
        
        const ownerSelect = document.getElementById('owner_id');
        const ownerAvatar = document.getElementById('owner_avatar');
        const petSelect = document.getElementById('pet_id');
        const dynamicAvatar = document.getElementById('dynamic_avatar');
        
        const ownerNameGroup = document.getElementById('owner_name_container');
        const petSelectionGroup = document.getElementById('pet_select_container');
        const walkinPetGroup = document.getElementById('walkin_pet_group');
        const registeredPetDetails = document.getElementById('registered_pet_details');
        
        console.log('Elements check:', {
            ownerSelect, ownerAvatar, petSelect, dynamicAvatar,
            ownerNameGroup, petSelectionGroup, walkinPetGroup, registeredPetDetails,
            defaultAvatarPath, defaultPawPath
        });
        
        if (ownerSelect) {
            ownerSelect.addEventListener('change', async function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value === 'no_account') {
                    console.log('Walk-in selection');
                    ownerAvatar.src = defaultAvatarPath;
                    
                    if (petSelectionGroup) petSelectionGroup.style.display = 'none';
                    if (ownerNameGroup) ownerNameGroup.style.display = 'block';
                    if (walkinPetGroup) walkinPetGroup.style.display = 'block';
                    if (registeredPetDetails) registeredPetDetails.style.display = 'none';
                    
                } else if (selectedOption.value) {
                    console.log('Owner selected:', selectedOption.value, selectedOption.text);
                    try {
                        console.log('Fetching owner data...');
                        const ownerResponse = await fetch(`/api/owners/${selectedOption.value}`);
                        
                        if (!ownerResponse.ok) {
                            console.error('Owner API error:', ownerResponse.status, ownerResponse.statusText);
                            throw new Error('Failed to fetch owner data');
                        }
                        
                        const ownerData = await ownerResponse.json();
                        console.log('Owner data received:', ownerData);
                        
                        if (ownerData.photo_data) {
                            ownerAvatar.src = `data:image/jpeg;base64,${ownerData.photo_data}`;
                        } else if (ownerData.avatar_url) {
                            ownerAvatar.src = ownerData.avatar_url;
                        } else {
                            ownerAvatar.src = defaultAvatarPath;
                        }
                        
                        ownerAvatar.onerror = function() {
                            console.log('Owner image failed to load, using default');
                            this.src = defaultAvatarPath;
                        };
                        
                        console.log('Fetching pets for owner ID:', selectedOption.value);
                        const petsResponse = await fetch(`/api/owners/${selectedOption.value}/pets`);
                        
                        if (!petsResponse.ok) {
                            console.error('Pets API error:', petsResponse.status, petsResponse.statusText);
                            throw new Error('Failed to fetch pets data');
                        }
                        
                        const petsData = await petsResponse.json();
                        console.log('Pets data received:', petsData);
                        
                        updatePetsDropdown(petsData);
                        
                        if (petSelectionGroup) petSelectionGroup.style.display = 'block';
                        if (ownerNameGroup) ownerNameGroup.style.display = 'none';
                        if (walkinPetGroup) walkinPetGroup.style.display = 'none';
                        if (registeredPetDetails) registeredPetDetails.style.display = 'block';
                        
                    } catch (error) {
                        console.error('Error in owner selection process:', error);
                        ownerAvatar.src = defaultAvatarPath;
                        
                        if (typeof showNotification === 'function') {
                            showNotification('error', `Failed to load data: ${error.message}`);
                        } else {
                            alert(`Error: ${error.message}`);
                        }
                    }
                } else {
                    console.log('No owner selected');
                    ownerAvatar.src = defaultAvatarPath;
                    
                    if (petSelect) {
                        petSelect.innerHTML = '<option value="">Select Pet</option>';
                    }
                    if (dynamicAvatar) {
                        dynamicAvatar.src = defaultPawPath;
                    }
                }
            });
        }
        
        if (petSelect) {
            petSelect.addEventListener('change', function() {
                console.log('Pet selection changed');
                const selectedOption = this.options[this.selectedIndex];
                
                if (!dynamicAvatar) {
                    console.error('Dynamic avatar element not found');
                    return;
                }
                
                if (selectedOption && selectedOption.value) {
                    const photoSrc = selectedOption.getAttribute('data-photo');
                    console.log('Selected pet photo:', photoSrc);
                    
                    dynamicAvatar.src = photoSrc || defaultPawPath;
                    
                    dynamicAvatar.onerror = function() {
                        console.log('Pet image failed to load, using default');
                        this.src = defaultPawPath;
                    };
                    
                    const petData = {
                        name: selectedOption.getAttribute('data-name'),
                        category: selectedOption.getAttribute('data-category'),
                        breed: selectedOption.getAttribute('data-breed'),
                        age: selectedOption.getAttribute('data-age'),
                        weight: selectedOption.getAttribute('data-weight'),
                        gender: selectedOption.getAttribute('data-gender')
                    };
                    
                    updatePetDetails(petData);
                    
                } else {
                    console.log('No pet selected, using default image');
                    dynamicAvatar.src = defaultPawPath;
                    clearPetDetails();
                }
            });
        }
    });
    
    function updatePetsDropdown(pets) {
        const petSelect = document.getElementById('pet_id');
        if (!petSelect) {
            console.error('Pet select element not found');
            return;
        }
        
        petSelect.innerHTML = '<option value="">Select Pet</option>';
        
        if (!Array.isArray(pets) || pets.length === 0) {
            console.log('No pets found for this owner');
            return;
        }
        
        console.log(`Adding ${pets.length} pets to dropdown`);
        
        pets.forEach(pet => {
            const option = document.createElement('option');
            option.value = pet.id;
            option.textContent = `${pet.name} (${pet.category || 'Unknown'})`;
            
            if (pet.photo_data) {
                option.setAttribute('data-photo', `data:image/jpeg;base64,${pet.photo_data}`);
            } else if (pet.photo) {
                option.setAttribute('data-photo', `/storage/${pet.photo}`);
            } else {
                option.setAttribute('data-photo', defaultPawPath);
            }
            
            option.setAttribute('data-name', pet.name || '');
            option.setAttribute('data-category', pet.category || '');
            option.setAttribute('data-breed', pet.breed || '');
            option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
            option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
            option.setAttribute('data-gender', pet.gender ? pet.gender.toLowerCase() : '');
            
            petSelect.appendChild(option);
        });
        
        console.log(`Pet dropdown updated with ${pets.length} pets`);
    }
    
    function updatePetDetails(petData) {
        console.log('Updating pet details with:', petData);
        
        const petFields = {
            'pet_name': petData.name || '',
            'pet_category': petData.category || '',
            'pet_breed': petData.breed || '',
            'pet_age': petData.age || '',
            'pet_weight': petData.weight || '',
            'pet_gender': petData.gender ? 
                petData.gender.charAt(0).toUpperCase() + petData.gender.slice(1) : ''
        };
        
        Object.entries(petFields).forEach(([id, value]) => {
            const field = document.getElementById(id);
            if (field) field.value = value;
        });
    }

    function updateDynamicPetFields(petData) {
        if (!petData) return;
        
        const fields = {
            'pet_name': petData.name || '',
            'pet_category': petData.type || petData.category || '',
            'pet_breed': petData.breed || '',
            'pet_gender': petData.gender || '',
            'pet_weight': petData.weight || '',
            'pet_age': petData.age || ''
        };
        
        Object.entries(fields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.value = value;
            }
        });
    }

    function updateDisplayFields(data, fieldMap) {
        if (!data) return;
        
        Object.entries(fieldMap).forEach(([property, elementId]) => {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const value = data[property];
            element.textContent = value || '-';
        });
    }

    function updatePetDetails(pet) {
        console.log('Updating pet details with full data:', pet);
        
        // Check if elements exist before updating
        const nameField = document.getElementById('pet_name');
        const typeField = document.getElementById('pet_type');
        const breedField = document.getElementById('pet_breed');
        const ageField = document.getElementById('pet_age');
        const weightField = document.getElementById('pet_weight');
        const genderField = document.getElementById('pet_gender');
        const avatarField = document.getElementById('dynamic_avatar');
        
        // Log each element to verify it exists
        console.log('Form elements:', {
            nameField,
            typeField,
            breedField,
            ageField,
            weightField,
            genderField,
            avatarField
        });
        
        // Only update if elements exist
        if (nameField) nameField.value = pet.name || '';
        if (typeField) typeField.value = pet.category || '';
        if (breedField) breedField.value = pet.breed || '';
        if (ageField) ageField.value = pet.age || '';
        if (weightField) weightField.value = pet.weight || '';
        if (genderField) genderField.value = pet.gender || '';
        
        // Update pet avatar if available and element exists
        if (avatarField) {
            if (pet.photo_data) {
                console.log('Setting photo from photo_data');
                avatarField.src = `data:image/jpeg;base64,${pet.photo_data}`;
            } else if (pet.photo_url) {
                console.log('Setting photo from photo_url:', pet.photo_url.substring(0, 50) + '...');
                avatarField.src = pet.photo_url;
            } else if (pet.photo) {
                console.log('Setting photo from photo path');
                avatarField.src = `{{ asset('storage/') }}/${pet.photo}`;
            } else {
                console.log('Setting default photo');
                avatarField.src = "{{ asset('storage/defaults/paw.png') }}";
            }
        } else {
            console.error('Avatar element not found!');
        }
        
        // Log data after update
        console.log('Pet details updated successfully');
    }

    // Update the updatePetsDropdown function for better error handling
    function updatePetsDropdown(pets) {
        const petSelect = document.getElementById('pet_id');
        if (!petSelect) {
            console.error('Pet select element not found');
            return;
        }
        
        // Only clear if we have valid data
        if (Array.isArray(pets) && pets.length > 0) {
            console.log(`Adding ${pets.length} pets to dropdown`);
            
            // Create a document fragment for better performance
            const fragment = document.createDocumentFragment();
            
            // Add the default option
            const defaultOption = document.createElement('option');
            defaultOption.value = "";
            defaultOption.textContent = "Select Pet";
            fragment.appendChild(defaultOption);
            
            // Add pet options
            pets.forEach(pet => {
                if (!pet || !pet.id) {
                    console.warn('Invalid pet data:', pet);
                    return; // Skip invalid pets
                }
                
                const option = document.createElement('option');
                option.value = pet.id;
                option.textContent = `${pet.name || 'Unnamed Pet'} (${pet.category || 'Unknown'})`;
                
                // Safety check for each data attribute
                option.setAttribute('data-photo', pet.photo ? '/storage/' + pet.photo : '/storage/defaults/paw.png');
                option.setAttribute('data-name', pet.name || '');
                option.setAttribute('data-category', pet.category || '');
                option.setAttribute('data-breed', pet.breed || '');
                option.setAttribute('data-age', pet.age ? pet.age.toString() : '');
                option.setAttribute('data-weight', pet.weight ? pet.weight.toString() : '');
                option.setAttribute('data-gender', pet.gender ? pet.gender.toLowerCase() : '');
                
                fragment.appendChild(option);
            });
            
            // Replace all options at once
            petSelect.innerHTML = '';
            petSelect.appendChild(fragment);
        } else {
            console.warn('No valid pets data to update dropdown', pets);
            petSelect.innerHTML = '<option value="">No pets available</option>';
        }
    }
</script>
@endpush

@push('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const todayButton = document.getElementById('today_button');
        const dateField = document.getElementById('appointment_date');
        const timeField = document.getElementById('appointment_time');
        
        const notificationContainer = document.createElement('div');
        notificationContainer.id = 'time-selection-indicator';
        notificationContainer.className = 'alert alert-info mt-2 d-none';
        notificationContainer.setAttribute('role', 'alert');
        
        const buttonParent = document.querySelector('.col-md-4.d-flex.align-items-end');
        if (buttonParent) {
            buttonParent.parentNode.insertBefore(notificationContainer, buttonParent.nextSibling);
        }
        
        function showTimeIndicator(message, type = 'info') {
            notificationContainer.textContent = message;
            notificationContainer.className = `alert alert-${type} mt-2`;
            
            setTimeout(() => {
                notificationContainer.className = 'alert alert-info mt-2 d-none';
            }, 8000);
        }
        
        if (todayButton && dateField && timeField) {
            todayButton.addEventListener('click', function() {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0
                const year = now.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;
                
                dateField.value = formattedDate;
                
                const hours = now.getHours();
                const minutes = now.getMinutes();
                console.log('Current time:', hours + ':' + minutes);
                
                if (hours < 9) {
                    for (let i = 0; i < timeField.options.length; i++) {
                        if (timeField.options[i].value === '09:00 AM') {
                            timeField.selectedIndex = i;
                            break;
                        }
                    }
                    const timeUntilOpening = 9 - hours;
                    showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) is outside business hours. Selected the first available appointment at 9:00 AM (${timeUntilOpening} hours from now).`, 'warning');
                } 
                else if (hours >= 17 || (hours === 16 && minutes > 30)) {
                    // Select 9:00 AM for tomorrow
                    for (let i = 0; i < timeField.options.length; i++) {
                        if (timeField.options[i].value === '09:00 AM') {
                            timeField.selectedIndex = i;
                            
                            const tomorrow = new Date(now);
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                            const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                            const tomorrowYear = tomorrow.getFullYear();
                            dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                            
                            showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) is after business hours. Selected the first available appointment tomorrow at 9:00 AM.`, 'warning');
                            break;
                        }
                    }
                }
                else {
                    const currentTotalMinutes = hours * 60 + minutes;
                    
                    let bestOptionIndex = -1;
                    let smallestDifference = Infinity;
                    
                    for (let i = 1; i < timeField.options.length; i++) {
                        const option = timeField.options[i];
                        if (!option.value) continue;
                        
                        const [timePart, ampm] = option.value.split(' ');
                        let [slotHours, slotMinutes] = timePart.split(':').map(Number);
                        
                        if (ampm === 'PM' && slotHours !== 12) slotHours += 12;
                        if (ampm === 'AM' && slotHours === 12) slotHours = 0;
                        
                        const slotTotalMinutes = slotHours * 60 + slotMinutes;
                        
                        if (slotTotalMinutes > currentTotalMinutes + 15) {
                            const difference = slotTotalMinutes - currentTotalMinutes;
                            
                            if (difference < smallestDifference) {
                                smallestDifference = difference;
                                bestOptionIndex = i;
                            }
                        }
                    }
                    
                    if (bestOptionIndex !== -1) {
                        timeField.selectedIndex = bestOptionIndex;
                        const selectedTime = timeField.options[bestOptionIndex].value;
                        
                        const minutesDifference = Math.floor(smallestDifference);
                        const hoursDifference = Math.floor(minutesDifference / 60);
                        const remainingMinutes = minutesDifference % 60;
                        
                        let timeMessage;
                        if (hoursDifference > 0) {
                            timeMessage = `${hoursDifference} hour${hoursDifference > 1 ? 's' : ''}`;
                            if (remainingMinutes > 0) {
                                timeMessage += ` and ${remainingMinutes} minute${remainingMinutes > 1 ? 's' : ''}`;
                            }
                        } else {
                            timeMessage = `${remainingMinutes} minute${remainingMinutes > 1 ? 's' : ''}`;
                        }
                        
                        if (minutesDifference <= 30) {
                            showTimeIndicator(`Selected the closest available appointment at ${selectedTime} (${timeMessage} from now).`, 'success');
                        } else {
                            showTimeIndicator(`Current time (${hours}:${String(minutes).padStart(2, '0')}) - next available appointment is at ${selectedTime} (${timeMessage} from now).`, 'info');
                        }
                    } else {
                        for (let i = 0; i < timeField.options.length; i++) {
                            if (timeField.options[i].value === '09:00 AM') {
                                timeField.selectedIndex = i;
                                
                                const tomorrow = new Date(now);
                                tomorrow.setDate(tomorrow.getDate() + 1);
                                const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                                const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                                const tomorrowYear = tomorrow.getFullYear();
                                dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                                
                                showTimeIndicator(`No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.`, 'warning');
                                break;
                            }
                        }
                    }
                }
                
                dateField.dispatchEvent(new Event('change', { bubbles: true }));
                timeField.dispatchEvent(new Event('change', { bubbles: true }));
                
                console.log('Today button clicked, set date to:', dateField.value, 'and time to:', timeField.value);
            });
        } else {
            console.error('Today button or date/time fields not found:', { 
                todayButton, dateField, timeField 
            });
        }
    });
</script>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateField = document.getElementById('appointment_date');
        if (dateField) {
            dateField.addEventListener('change', function() {
                const dateValue = this.value;
                const datePattern = /^\d{4}-\d{2}-\d{2}$/;
                
                if (!datePattern.test(dateValue)) {
                    try {
                        const dateParts = dateValue.split(/[\/\-\.]/);
                        
                        if (dateParts.length === 3) {
                            let year, month, day;
                            
                            if (dateParts[0].length === 4) {
                                year = dateParts[0];
                                month = dateParts[1].padStart(2, '0');
                                day = dateParts[2].padStart(2, '0');
                            } 
                            else if (dateParts[2].length === 4) {
                                day = dateParts[0].padStart(2, '0');
                                month = dateParts[1].padStart(2, '0');
                                year = dateParts[2];
                            }
                            else {
                                month = dateParts[0].padStart(2, '0');
                                day = dateParts[1].padStart(2, '0');
                                year = dateParts[2].length === 2 ? '20' + dateParts[2] : dateParts[2];
                            }
                            
                            this.value = `${year}-${month}-${day}`;
                        }
                    } catch (e) {
                        console.error('Error formatting date:', e);
                    }
                }
            });
        }
    });
</script>

@push('scripts')
<script>
    // Constants and Configuration
    const defaultPaths = {
        defaultAvatar: '/images/default-avatar.png',
        defaultPetPhoto: '/images/default-pet-photo.png'
    };

    // DOM Elements
    const form = document.getElementById('appointment-form');
    const ownerSelect = document.getElementById('owner_id');
    const petSelect = document.getElementById('pet_id');
    const reasonSelect = document.getElementById('reason_for_visit');
    const dateField = document.getElementById('appointment_date');
    const timeField = document.getElementById('appointment_time');
    const todayButton = document.getElementById('today-button');
    const serviceDetailsContainer = document.getElementById('service-details-container') || createServiceDetailsContainer();

    // Initialization
    document.addEventListener('DOMContentLoaded', function() {
        initializeFormValidation();
        initializeOwnerSelection();
        initializePetSelection();
        initializeDateTimeHandling();
    });

    // Form Validation
    function initializeFormValidation() {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Remove existing error messages
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(message => message.remove());
            
            // Check required fields
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    isValid = false;
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-danger mt-1';
                    errorDiv.textContent = 'This field is required';
                    field.parentNode.appendChild(errorDiv);
                }
            });
            
            if (isValid) {
                form.submit();
            }
        });
    }

    // Owner Selection Handling
    function initializeOwnerSelection() {
        if (ownerSelect) {
            ownerSelect.addEventListener('change', async function() {
                const ownerId = this.value;
                if (ownerId) {
                    try {
                        const response = await fetch(`/api/owners/${ownerId}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            updateOwnerDetails(data.owner);
                            updatePetOptions(data.pets);
                        } else {
                            console.error('Error fetching owner data:', data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });
        }
    }

    // Pet Selection Handling
    function initializePetSelection() {
        if (petSelect) {
            petSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                updatePetDetails(selectedOption);
            });
        }
    }

    // Date and Time Handling
    function initializeDateTimeHandling() {
        if (todayButton && dateField && timeField) {
            todayButton.addEventListener('click', function() {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                const currentHour = now.getHours();
                
                dateField.value = `${day}/${month}/${year}`;
                
                if (currentHour < 9) {
                    timeField.value = '09:00';
                    showTimeIndicator('Selected first available appointment at 9:00 AM');
                } else if (currentHour >= 17) {
                    const tomorrow = new Date(now);
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                    const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                    const tomorrowYear = tomorrow.getFullYear();
                    dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                    timeField.value = '09:00';
                    showTimeIndicator('No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.', 'warning');
                } else {
                    const nextHour = currentHour + 1;
                    if (nextHour < 17) {
                        timeField.value = `${String(nextHour).padStart(2, '0')}:00`;
                        showTimeIndicator(`Selected next available appointment at ${timeField.value}`);
                    } else {
                        const tomorrow = new Date(now);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        const tomorrowDay = String(tomorrow.getDate()).padStart(2, '0');
                        const tomorrowMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
                        const tomorrowYear = tomorrow.getFullYear();
                        dateField.value = `${tomorrowDay}/${tomorrowMonth}/${tomorrowYear}`;
                        timeField.value = '09:00';
                        showTimeIndicator('No more appointments available today. Selected the first available appointment tomorrow at 9:00 AM.', 'warning');
                    }
                }
                
                dateField.dispatchEvent(new Event('change', { bubbles: true }));
                timeField.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }
    }

    // Utility Functions
    function createServiceDetailsContainer() {
        const container = document.createElement('div');
        container.id = 'service-details-container';
        container.className = 'mt-3';
        const reasonSection = document.querySelector('.form-selectgroup').closest('.mb-3');
        reasonSection.parentNode.insertBefore(container, reasonSection.nextSibling);
        return container;
    }

    function showTimeIndicator(message, type = 'info') {
        const container = document.getElementById('time-indicator') || createTimeIndicator();
        container.textContent = message;
        container.className = `alert alert-${type} mt-2`;
        container.style.display = 'block';
        
        setTimeout(() => {
            container.style.display = 'none';
        }, 5000);
    }

    function createTimeIndicator() {
        const container = document.createElement('div');
        container.id = 'time-indicator';
        container.className = 'alert mt-2';
        timeField.parentNode.appendChild(container);
        return container;
    }

    function updateOwnerDetails(owner) {
        const ownerDetailsContainer = document.getElementById('owner-details');
        if (ownerDetailsContainer) {
            const avatarImg = ownerDetailsContainer.querySelector('img');
            if (avatarImg) {
                avatarImg.src = owner.photo_data || defaultPaths.defaultAvatar;
            }
            
            const nameElement = ownerDetailsContainer.querySelector('[data-field="name"]');
            if (nameElement) {
                nameElement.textContent = owner.name;
            }
            
            // Update other owner details as needed
        }
    }

    function updatePetOptions(pets) {
        if (petSelect) {
            petSelect.innerHTML = '<option value="">Select a pet</option>';
            pets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.textContent = pet.name;
                option.dataset.photo = pet.photo_data || defaultPaths.defaultPetPhoto;
                option.dataset.name = pet.name;
                option.dataset.category = pet.category;
                option.dataset.breed = pet.breed;
                option.dataset.age = pet.age;
                option.dataset.weight = pet.weight;
                option.dataset.gender = pet.gender;
                petSelect.appendChild(option);
            });
        }
    }

    function updatePetDetails(selectedOption) {
        console.log('Updating pet details with:', selectedOption.dataset);
        const petDetailsContainer = document.getElementById('pet-details');
        if (petDetailsContainer) {
            const avatarImg = petDetailsContainer.querySelector('img');
            if (avatarImg) {
                avatarImg.src = selectedOption.dataset.photo || defaultPaths.defaultPetPhoto;
            }
            
            const fields = ['name', 'category', 'breed', 'age', 'weight', 'gender'];
            fields.forEach(field => {
                const element = petDetailsContainer.querySelector(`[data-field="${field}"]`);
                if (element) {
                    element.textContent = selectedOption.dataset[field] || '';
                }
            });
        }
    }
</script>
@endpush

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.clear();
    console.log('Starting fresh implementation of reason buttons');
    
    // Select the actual buttons directly from the DOM
    const reasonBtns = Array.from(document.querySelectorAll('button.reason-btn'));
    console.log('Found reason buttons:', reasonBtns.length, reasonBtns);
    
    if (reasonBtns.length === 0) {
        console.error('ERROR: No reason buttons found! Check your HTML structure.');
        return;
    }
    
    // Important elements
    const selectedReasonsDiv = document.getElementById('selected-reasons');
    const emptyReasonText = document.getElementById('empty-reason-text');
    const reasonInput = document.getElementById('reason_for_visit');
    
    if (!selectedReasonsDiv || !emptyReasonText || !reasonInput) {
        console.error('ERROR: Missing required elements!', {
            selectedReasonsDiv,
            emptyReasonText,
            reasonInput
        });
        return;
    }
    
    // Track selected reasons
    const selectedReasons = new Set();
    
    // Create direct click handlers for each button
    reasonBtns.forEach(btn => {
        const reason = btn.getAttribute('data-reason');
        console.log(`Setting up button for: ${reason}`);
        
        // Remove any possible existing event listeners
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        // Add a clean click handler
        newBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log(`Button clicked: ${reason}`);
            
            if (this.classList.contains('active')) {
                // Remove reason
                this.classList.remove('active');
                selectedReasons.delete(reason);
                console.log(`Removed reason: ${reason}`);
            } else {
                // Add reason
                this.classList.add('active');
                selectedReasons.add(reason);
                console.log(`Added reason: ${reason}`);
            }
            
            // Update hidden input
            reasonInput.value = Array.from(selectedReasons).join(', ');
            console.log('Updated input value:', reasonInput.value);
            
            // Update UI
            renderSelectedReasons();
            
            return false;
        };
    });
    
    function renderSelectedReasons() {
        selectedReasonsDiv.innerHTML = '';
        
        if (selectedReasons.size === 0) {
            emptyReasonText.style.display = 'block';
            return;
        }
        
        emptyReasonText.style.display = 'none';
        
        // Create badges for each selected reason
        Array.from(selectedReasons).forEach(reason => {
            const badge = document.createElement('div');
            badge.className = 'badge d-flex align-items-center gap-2';
            badge.innerHTML = `
                ${reason}
                <button type="button" class="btn-close btn-close-white" aria-label="Remove"></button>
            `;
            
            // Add remove button handler
            badge.querySelector('.btn-close').onclick = function() {
                selectedReasons.delete(reason);
                
                // Find and update corresponding button
                const btn = document.querySelector(`button.reason-btn[data-reason="${reason}"]`);
                if (btn) btn.classList.remove('active');
                
                // Update hidden input
                reasonInput.value = Array.from(selectedReasons).join(', ');
                
                // Re-render UI
                renderSelectedReasons();
            };
            
            selectedReasonsDiv.appendChild(badge);
        });
    }
    
    // Debug click events
    document.addEventListener('click', function(e) {
        const target = e.target.closest('button.reason-btn');
        if (target) {
            console.log('Button click detected via event delegation:', target.getAttribute('data-reason'));
        }
    });
    
});
</script>
@endpush

@push('page-scripts')
// ... existing scripts ...

<script>
    // Pet History functionality
    document.addEventListener('DOMContentLoaded', function() {
        const petSelect = document.getElementById('pet_id');
        const historyCard = document.getElementById('pet_history_card');
        const historyLoading = document.getElementById('pet_history_loading');
        const historyContent = document.getElementById('pet_history_content');
        const noHistoryMessage = document.getElementById('no_history_message');
        const appointmentList = document.getElementById('appointment_history_list');
        
        if (petSelect) {
            petSelect.addEventListener('change', function() {
                const petId = this.value;
                
                // Clear previous history
                if (appointmentList) {
                    appointmentList.innerHTML = '';
                }
                
                // Hide the history card if no pet is selected
                if (!petId) {
                    if (historyCard) historyCard.style.display = 'none';
                    if (historyLoading) historyLoading.style.display = 'none'; // Ensure loading is hidden
                    return;
                }
                
                // Fetch pet's history (past appointments and findings)
                fetchPetHistory(petId);
            });
        }
        
        // Function to fetch pet history
        function fetchPetHistory(petId) {
            // Clear previous history
            if (appointmentList) {
                appointmentList.innerHTML = '';
            }
            
            // Show history card
            if (historyCard) historyCard.style.display = 'block';
            
            // Show loading state initially
            if (historyLoading) historyLoading.style.display = 'flex';
            if (historyContent) historyContent.style.display = 'none';
            if (noHistoryMessage) noHistoryMessage.style.display = 'none';
            
            // Set a timeout to force-hide the loading spinner after 5 seconds
            // This ensures it doesn't get stuck in a loading state
            const loadingTimeout = setTimeout(() => {
                console.log('Force-hiding loading spinner after timeout');
                if (historyLoading) historyLoading.style.display = 'none';
                if (historyContent) historyContent.style.display = 'block';
            }, 5000);
            
            // Use the simplified endpoint
            fetch(`/api/pets/${petId}/simple-history`)
                .then(response => {
                    // Check if we got HTML instead of JSON
                    const contentType = response.headers.get('content-type');
                    if (!response.ok || !contentType || !contentType.includes('application/json')) {
                        // Instead of throwing an error, just show "No history" message
                        clearTimeout(loadingTimeout); // Clear the timeout
                        forceHideLoading();
                        showNoHistoryMessage();
                        return null; // Return null to skip the next then block
                    }
                    return response.json();
                })
                .then(data => {
                    // Clear the timeout since we got a response
                    clearTimeout(loadingTimeout);
                    
                    // Always hide loading state here
                    forceHideLoading();
                    
                    if (data) {
                        displayPetHistory(data);
                    }
                })
                .catch(error => {
                    // Clear the timeout
                    clearTimeout(loadingTimeout);
                    
                    // Hide loading state on error too
                    forceHideLoading();
                    
                    console.error('Error fetching pet history:', error);
                    showNoHistoryMessage();
                });
        }
        
        // Function to show "No history" message
        function showNoHistoryMessage() {
            if (historyLoading) historyLoading.style.display = 'none';
            if (historyContent) historyContent.style.display = 'block';
            if (noHistoryMessage) {
                noHistoryMessage.style.display = 'block';
                noHistoryMessage.textContent = 'No previous appointments or findings for this pet.';
            }
        }
        
        // Function to display pet history
        function displayPetHistory(data) {
            // Make absolutely sure loading is hidden and content is shown
            forceHideLoading();
            
            // Handle case with no history or failed response
            if (!data || !data.success || !data.appointments || data.appointments.length === 0) {
                if (noHistoryMessage) {
                    noHistoryMessage.style.display = 'block';
                    noHistoryMessage.textContent = 'No previous appointments or findings for this pet.';
                }
                return;
            }
            
            // Hide no history message
            if (noHistoryMessage) noHistoryMessage.style.display = 'none';
            
            // Sort appointments by date (newest first)
            const sortedAppointments = data.appointments.sort((a, b) => {
                // Use appointment_date for sorting instead of scheduled_at
                const dateA = new Date(a.appointment_date);
                const dateB = new Date(b.appointment_date);
                return dateB - dateA;
            });
            
            // Display appointments with completed status
            const completedAppointments = sortedAppointments.filter(app => app.status === 'completed');
            
            if (completedAppointments.length === 0) {
                if (noHistoryMessage) noHistoryMessage.style.display = 'block';
                if (noHistoryMessage) noHistoryMessage.textContent = 'No completed appointments found for this pet.';
                return;
            }
            
            // Populate the appointment list
            completedAppointments.forEach(appointment => {
                // Find findings for this appointment
                const findings = data.findings ? data.findings.filter(f => f.appointment_id === appointment.id) : [];
                
                // Format the findings data for display
                let findingsHtml = '';
                if (findings.length > 0) {
                    findings.forEach(finding => {
                        // Diagnosis
                        if (finding.diagnosis) {
                            findingsHtml += `<div><strong>Diagnosis:</strong> ${finding.diagnosis}</div>`;
                        }
                        
                        // Recommendations
                        if (finding.recommendations) {
                            findingsHtml += `<div><strong>Recommendations:</strong> ${finding.recommendations}</div>`;
                        }
                        
                        // Treatment plan
                        if (finding.treatment_plan) {
                            findingsHtml += `<div><strong>Treatment:</strong> ${finding.treatment_plan}</div>`;
                        }
                    });
                } else {
                    findingsHtml = '<em>No detailed findings recorded</em>';
                }
                
                // Format appointment date - handle different date formats
                let formattedDate = 'N/A';
                let formattedTime = '';
                
                try {
                    // Try to parse the date from appointment_date
                    if (appointment.appointment_date) {
                        const dateParts = appointment.appointment_date.split('-');
                        if (dateParts.length === 3) {
                            const year = parseInt(dateParts[0]);
                            const month = parseInt(dateParts[1]) - 1; // JS months are 0-indexed
                            const day = parseInt(dateParts[2]);
                            
                            const dateObj = new Date(year, month, day);
                            
                            formattedDate = dateObj.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                        }
                    }
                    
                    // Format time if available
                    if (appointment.appointment_time) {
                        formattedTime = appointment.appointment_time;
                    }
                } catch (e) {
                    console.warn('Error formatting date:', e);
                }
                
                // Format reason for visit
                let reasonText = '';
                try {
                    const reasons = typeof appointment.reason_for_visit === 'string' 
                        ? JSON.parse(appointment.reason_for_visit) 
                        : appointment.reason_for_visit;
                    
                    reasonText = Array.isArray(reasons) ? reasons.join(', ') : reasons;
                } catch (e) {
                    reasonText = appointment.reason_for_visit || 'Not specified';
                }
                
                // Create table row - show findings directly instead of using a button
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${formattedDate}<br><small class="text-muted">${formattedTime}</small></td>
                    <td>${reasonText}</td>
                    <td><span class="badge bg-success text-white">Completed</span></td>
                    <td>
                        <div class="findings-content">
                            ${findingsHtml}
                        </div>
                    </td>
                `;
                
                appointmentList.appendChild(row);
            });
        }
    });

    // Add this helper function to force-hide the loading state
    function forceHideLoading() {
        console.log('Force-hiding loading spinner with aggressive approach');
        
        // Try multiple approaches to ensure the spinner is gone
        
        // 1. Try to get the element by ID
        const loadingElement = document.getElementById('pet_history_loading');
        if (loadingElement) {
            // First try to hide it
            loadingElement.style.display = 'none';
            
            // Then try to remove it completely from the DOM
            try {
                loadingElement.parentNode.removeChild(loadingElement);
                console.log('Successfully removed loading element from DOM');
            } catch (e) {
                console.error('Failed to remove loading element:', e);
            }
        }
        
        // 2. Try using querySelector as a backup
        const loadingElementAlt = document.querySelector('#pet_history_loading');
        if (loadingElementAlt && loadingElementAlt !== loadingElement) {
            loadingElementAlt.style.display = 'none';
            try {
                loadingElementAlt.parentNode.removeChild(loadingElementAlt);
            } catch (e) {
                console.error('Failed to remove loading element (alt):', e);
            }
        }
        
        // 3. Try to find all elements with similar classes
        const spinners = document.querySelectorAll('.spinner-border');
        spinners.forEach(spinner => {
            const parent = spinner.closest('#pet_history_loading');
            if (parent) {
                parent.style.display = 'none';
                try {
                    parent.parentNode.removeChild(parent);
                } catch (e) {
                    console.error('Failed to remove spinner parent:', e);
                }
            }
        });
        
        // 4. Show the content
        const contentElement = document.getElementById('pet_history_content');
        if (contentElement) {
            contentElement.style.display = 'block';
        }
        
        // 5. Add a direct style to the document to hide all loading spinners
        const style = document.createElement('style');
        style.textContent = `
            #pet_history_loading { 
                display: none !important; 
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                overflow: hidden !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Update the pet selection event listener
    if (petSelect) {
        petSelect.addEventListener('change', function() {
            const petId = this.value;
            
            // Get the parent container that holds the history card
            const historyCardContainer = document.getElementById('pet_history_card').parentNode;
            
            // Remove the existing history card completely
            if (historyCard) {
                historyCard.remove();
            }
            
            // Hide the history card if no pet is selected
            if (!petId) {
                return;
            }
            
            // Create a new history card from scratch
            const newHistoryCard = document.createElement('div');
            newHistoryCard.id = 'pet_history_card';
            newHistoryCard.className = 'col-12';
            newHistoryCard.style.marginBottom = '1.5rem';
            
            newHistoryCard.innerHTML = `
                <div class="card">
                    <div class="card-header bg-primary-soft d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 8l0 4l2 2"></path>
                            <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                        </svg>
                        <h3 class="card-title mb-0">Pet History</h3>
                    </div>
                    <div class="card-body p-0">
                        <div id="pet_history_content">
                            <div id="no_history_message" class="alert alert-info m-3" style="display: none;">
                                No previous appointments or findings for this pet.
                            </div>
                            <div id="appointment_history_container">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Findings</th>
                                            </tr>
                                        </thead>
                                        <tbody id="appointment_history_list">
                                            <!-- Appointment history will be populated here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add the new card to the container
            historyCardContainer.appendChild(newHistoryCard);
            
            // Update references to the new elements
            historyCard = document.getElementById('pet_history_card');
            historyContent = document.getElementById('pet_history_content');
            noHistoryMessage = document.getElementById('no_history_message');
            appointmentList = document.getElementById('appointment_history_list');
            
            // Fetch pet's history without showing a loading spinner
            fetchPetHistoryWithoutLoading(petId);
        });
    }

    // Add a new function that fetches history without showing a loading spinner
    function fetchPetHistoryWithoutLoading(petId) {
        // Use the simplified endpoint
        fetch(`/api/pets/${petId}/simple-history`)
            .then(response => {
                // Check if we got HTML instead of JSON
                const contentType = response.headers.get('content-type');
                if (!response.ok || !contentType || !contentType.includes('application/json')) {
                    showNoHistoryMessage();
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    displayPetHistory(data);
                } else {
                    showNoHistoryMessage();
                }
            })
            .catch(error => {
                console.error('Error fetching pet history:', error);
                showNoHistoryMessage();
            });
    }
</script>
@endpush
