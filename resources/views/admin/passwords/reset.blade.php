@extends('layouts.guest')

@section('title', 'Reset Admin Password')

@section('content')
<div class="login-container">
    <h2>Reset Admin Password</h2>

    @if($errors->any())
        <div class="error" style="margin-bottom:12px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.update') }}" aria-label="Admin password reset form">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="login-btn">Reset Password</button>
    </form>

    <div class="login-links" style="margin-top:14px;">
        Remembered your password? <a href="{{ route('admin.login.form') }}">Sign in</a>
    </div>
</div>
@endsection