@extends('layouts.guest')

@section('title', 'Account Pending Approval')

@section('content')
<div class="login-container">
    <h2>Account Pending Approval</h2>

    <p class="muted">Thanks for registering — your account is awaiting admin approval. We'll email you once it's approved.</p>

    <div style="display:flex; gap:10px; flex-direction:column;">
        <a href="{{ route('login.form') }}" class="login-btn">Back to Login</a>
        <a href="{{ url('/') }}" class="btn-secondary">Return Home</a>
    </div>

    <div class="login-links">
        <span class="muted">Need help? <a href="mailto:support@example.com" style="color:#4f46e5;">support@example.com</a></span>
    </div>
</div>
@endsection