@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    Sub Admins
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    {{ __('Create Sub Admin') }}
                </a>
            </div>
        </div>

        @include('partials._breadcrumbs')
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Display Sub Admins List -->
        @if ($users->isEmpty())
            <p>No sub admins found.</p>
        @else
            <!-- Your table or list displaying users -->
        @endif
    </div>
</div>
@endsection
