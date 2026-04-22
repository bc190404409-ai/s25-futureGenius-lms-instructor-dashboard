@extends('layouts.guest')

@section('title', 'Session expired')

@section('content')
<div class="login-container">
    <h2>Session expired</h2>
    <p style="text-align:center; color:#666; margin:8px 0 16px;">Your session has expired or the form took too long to submit.</p>
    <p style="text-align:center; margin-bottom:16px;">Please refresh the page and try again. If the issue persists, try clearing cookies or logging in again.</p>

    <div style="display:flex; gap:10px; flex-direction:column;">
        <a href="{{ route('login.form') }}" class="login-btn" style="text-align:center; display:block;">Back to Login</a>
        <a href="{{ url()->previous() ?? route('login.form') }}" style="text-align:center; display:block; border:1px solid #e5e7eb; padding:10px; border-radius:6px; background:#fff;">Go Back</a>
    </div>

    <div class="login-links">
        <span class="muted">Need help? <a href="mailto:support@example.com" style="color:#4f46e5;">support@example.com</a></span>
    </div>
</div>
@endsection