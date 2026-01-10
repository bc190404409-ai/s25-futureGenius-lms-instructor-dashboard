@props([
    'action' => route('login'),
    'title' => 'Login',
    'subtitle' => 'Sign in to your account',
    'submitText' => 'Sign in',
    'showSocial' => true,
    'showRegister' => true,
])

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="login-container">
    <h2>{{ $title }}</h2>

    @if(session('status'))
        <div class="success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ $action }}" aria-label="{{ $title }} form">
        @csrf

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

        <button type="submit" class="login-btn">{{ $submitText }}</button>
    </form>

    @if($showSocial)
        <div style="margin: 20px 0; text-align: center; color: #999; font-size: 14px;">
            Or
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ route('social.redirect', 'google') }}" style="display: block; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 6px; text-decoration: none; color: #333; font-size: 14px;">Sign in with Google</a>
            <a href="{{ route('social.redirect', 'linkedin') }}" style="display: block; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 6px; text-decoration: none; color: #333; font-size: 14px;">Sign in with LinkedIn</a>
        </div>
    @endif

    @if($showRegister)
    <div class="login-links">
        Don't have an account? <a href="{{ route('register.form') }}">Register</a>
    </div>
    @endif
</div>
