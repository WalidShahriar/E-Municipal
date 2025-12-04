@extends('layouts.app')

@section('title', 'Sign Up | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endsection

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Create an account</h2>
        
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="signupForm" method="POST" action="{{ route('signup') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                <div class="error" id="nameError" aria-live="polite">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                <div class="error" id="emailError" aria-live="polite">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone (optional)</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
                <div class="error" id="phoneError" aria-live="polite">
                    @error('phone') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" placeholder="At least 6 characters" required minlength="6">
                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">Show</button>
                </div>
                <div class="error" id="passwordError" aria-live="polite">
                    @error('password') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required minlength="6">
                <div class="error" id="confirmError" aria-live="polite">
                    @error('password_confirmation') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-actions">
                <label class="checkbox"><input type="checkbox" id="terms" name="terms" required> I agree to the <a href="#">terms</a></label>
                <button type="submit" class="btn primary">Create account</button>
            </div>

            <div class="form-footer">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/signup.js') }}"></script>
@endsection
