@extends('layouts.app')

@section('title', 'Login | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Sign in to your account</h2>
        
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

        <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                <div class="error" id="emailError" aria-live="polite">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" placeholder="••••••••" required minlength="6">
                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">Show</button>
                </div>
                <div class="error" id="passwordError" aria-live="polite">
                    @error('password') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-actions">
                <label class="checkbox"><input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
                <button type="submit" class="btn primary">Sign in</button>
            </div>

            <div class="form-footer">
                <p>Don't have an account? <a href="{{ route('signup') }}">Sign up</a></p>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
