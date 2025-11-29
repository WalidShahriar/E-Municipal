@extends('layouts.app')

@section('title', 'Login | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Sign in to your account</h2>
        <form id="loginForm" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
                <div class="error" id="emailError" aria-live="polite"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" placeholder="••••••••" required minlength="6">
                    <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">Show</button>
                </div>
                <div class="error" id="passwordError" aria-live="polite"></div>
            </div>

            <div class="form-actions">
                <label class="checkbox"><input type="checkbox" id="remember" name="remember"> Remember me</label>
                <button type="submit" class="btn primary">Sign in</button>
            </div>

            <div class="form-footer">
                <p>Don't have an account? <a href="{{ url('/signup') }}">Sign up</a></p>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
