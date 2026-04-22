@props([
    'action' => route('login'),
    'title' => 'Login',
    'subtitle' => 'Sign in to your account',
    'submitText' => 'Sign in',
    'showSocial' => true,
    'showRegister' => true,
    'forgotRoute' => null,
    'variant' => null,
])

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="login-container {{ $variant ? 'variant-' . $variant : '' }}">
    <h2>{{ $title }}</h2>

    @if(session('status'))
        <div class="success">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
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
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="login-btn {{ $variant ? 'login-btn-' . $variant : '' }}">{{ $submitText }}</button>

        <div class="mt-3 text-right">
            <a href="{{ $forgotRoute ?? route('password.request') }}" class="link-primary">Forgot your password?</a>
        </div>
    </form>

    @if($showSocial)
        <div class="or-divider">Or</div>

        <div class="social-group">
            <a href="{{ route('social.redirect', 'google') }}" class="social-btn social-google" aria-label="Sign in with Google">
                <span class="social-icon" aria-hidden>
                    <svg width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" focusable="false"><path fill="#4285F4" d="M23.5 9h10.6c.6 3.5.6 6.9.6 7.7 0 6.2-4.2 11.9-10.7 15.7-6.6 3.8-15.6 4.8-23.4 2.3l4.3-7.2c5.7 1.9 11.5 1.7 15.3-.8 3.9-2.5 6.8-6.8 6.8-12.8 0-.9 0-2.2-.2-3z"/><path fill="#34A853" d="M9.3 28.3l-4.3 7.2C2 29.2 1.9 25.7 1.9 23 1.9 20.2 3 17.1 4.9 14.6l4.4 6c-.5 2.1-.6 5-0 7.7z"/><path fill="#FBBC05" d="M23.5 39.5c5.7 0 9.9-1.7 13.3-4.2l-6.2-5.1c-1.6 1.1-4.1 1.9-7.1 1.9-5.5 0-10.1-3.7-11.7-8.6l-4.4 6c3 6.1 9.9 9.9 16.1 9.9z"/><path fill="#EA4335" d="M36.8 13.4l4.7-3.6C39.8 8 32.9 5 23.5 5 14.9 5 7.5 8.1 3.9 14.4l5.4 4.1C12.8 13.3 17.9 9 23.5 9c3.2 0 6.2.9 8.9 4.4z"/></svg>
                </span>
                <span>Sign in with Google</span>
            </a>

            <a href="{{ route('social.redirect', 'linkedin') }}" class="social-btn social-linkedin" aria-label="Sign in with LinkedIn">
                <span class="social-icon" aria-hidden>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.48 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5V24H0zM8.5 8h4.8v2.1h.1c.7-1.3 2.5-2.6 5.1-2.6 5.4 0 6.4 3.6 6.4 8.3V24h-5V15.2c0-2.1 0-4.8-3-4.8-3 0-3.4 2.2-3.4 4.6V24h-5z"/></svg>
                </span>
                <span>Sign in with LinkedIn</span>
            </a>
        </div>
    @endif

    @if($showRegister)
    <div class="login-links">
        Don't have an account? <a href="{{ route('register.form') }}">Register</a>
    </div>
    @endif
</div>
