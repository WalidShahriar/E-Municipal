@extends('layouts.app')

@section('title', 'Profile | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header h2 {
            margin-bottom: 10px;
        }
        .profile-info {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #e6f0f8;
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 8px;
        }
        .profile-info strong {
            color: #c4cfd7;
            font-weight: 600;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .profile-info p > span:not(.role-badge) {
            color: #e6f0f8;
            flex: 1;
            min-width: 0;
        }
        /* Allow email to break only at @ or . if needed, otherwise keep on one line */
        .profile-info p:nth-child(2) > span {
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .role-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .role-badge.admin {
            background: #ff6b6b;
            color: white;
        }
        .role-badge.user {
            background: #4ecdc4;
            color: white;
        }
    </style>
@endsection

@section('content')

<div class="auth-container">
    <div class="auth-card profile-card">
        <div class="profile-header">
            <h2>My Profile</h2>
            <p>Manage your account information</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-info">
            <p><strong>Name:</strong> <span>{{ $user->name }}</span></p>
            <p><strong>Email:</strong> <span>{{ $user->email }}</span></p>
            <p><strong>Phone:</strong> <span>{{ $user->phone ?? 'Not provided' }}</span></p>
            <p><strong>Role:</strong> 
                <span class="role-badge {{ $user->isAdmin() ? 'admin' : 'user' }}">
                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                </span>
            </p>
            <p><strong>Member since:</strong> <span>{{ $user->created_at->format('F Y') }}</span></p>
        </div>

        <h3 style="margin-bottom: 20px; margin-top: 30px; color: #fff;">Update Profile</h3>
        <form method="POST" action="{{ route('profile.update') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Your full name" required>
                <div class="error" id="nameError" aria-live="polite">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="you@example.com" required>
                <div class="error" id="emailError" aria-live="polite">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone (optional)</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="01XXXXXXXXX">
                <div class="error" id="phoneError" aria-live="polite">
                    @error('phone') {{ $message }} @enderror
                </div>
            </div>

            <h4 style="margin-top: 30px; margin-bottom: 15px; color: #fff;">Change Password (optional)</h4>
            <p style="font-size: 14px; color: var(--muted); margin-bottom: 20px;">Leave blank if you don't want to change your password</p>

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                <div class="error" id="currentPasswordError" aria-live="polite">
                    @error('current_password') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" placeholder="At least 6 characters" minlength="6">
                    <button type="button" class="toggle-pass" onclick="togglePassword('password')" aria-label="Show password">Show</button>
                </div>
                <div class="error" id="passwordError" aria-live="polite">
                    @error('password') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password" minlength="6">
                <div class="error" id="confirmError" aria-live="polite">
                    @error('password_confirmation') {{ $message }} @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Update Profile</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = 'Hide';
            } else {
                input.type = 'password';
                button.textContent = 'Show';
            }
        }
    </script>
@endsection

