@props([
    'action' => route('login'),
    'title' => 'Login',
    'subtitle' => 'Sign in to your account',
    'submitText' => 'Sign in',
    'showRegister' => true,
])

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="login-container">
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

    <form method="POST" action="{{ $action }}">
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

        <button type="submit" class="login-btn">{{ $submitText }}</button>
    </form> 
</div>
