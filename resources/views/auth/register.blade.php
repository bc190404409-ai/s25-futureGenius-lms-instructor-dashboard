@extends('layouts.guest')

@section('content')
<div class="login-container">
    <h2>Register</h2>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<span class="error" style="display:block; margin-top:5px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<span class="error" style="display:block; margin-top:5px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')<span class="error" style="display:block; margin-top:5px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')<span class="error" style="display:block; margin-top:5px;">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="login-btn">Create Account</button>
    </form>

    <div style="margin: 20px 0; text-align: center; color: #999; font-size: 14px;">
        Or continue with
    </div>

    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('social.redirect', 'google') }}" style="display: block; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 6px; text-decoration: none; color: #333; font-size: 14px;">Google</a>
        <a href="{{ route('social.redirect', 'linkedin') }}" style="display: block; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 6px; text-decoration: none; color: #333; font-size: 14px;">LinkedIn</a>
    </div>

    <div class="login-links">
        Already have an account? <a href="{{ route('login.form') }}">Sign in</a>
    </div>
</div>
@endsection