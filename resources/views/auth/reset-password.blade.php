@extends('layouts.auth')

@section('head')
    <style>
        .reset-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            padding: 2rem;
        }

        .reset-form-container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            overflow: hidden;
        }

        /* Copy other styles from forgot-password.blade.php */
    </style>
@endsection

@section('content')
<div class="reset-container">
    <div class="reset-form-container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">
                    Reset Password
                </h2>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">

                    <div class="mb-4">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" 
                            name="password" 
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter new password"
                        >
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Confirm new password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
