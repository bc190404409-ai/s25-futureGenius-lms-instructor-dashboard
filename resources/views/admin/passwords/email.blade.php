@extends('layouts.guest')

@section('title', 'Admin Password Reset')

@section('content')
<div class="login-container">
    <h2>Admin: Forgot your password?</h2>

    @if (session('status'))
        <div class="success" style="margin-bottom:12px;">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="error" style="margin-bottom:12px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}" id="reset-form" aria-label="Admin password reset request form">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <button id="send-btn" type="submit" class="login-btn" aria-live="polite">
            <span id="send-text">Send Password Reset Link</span>
            <span id="send-spinner" class="hidden" style="margin-left:8px; display:inline-block; width:14px; height:14px; border:2px solid rgba(255,255,255,0.6); border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite"></span>
        </button>
    </form>

    <div class="login-links" style="margin-top:14px;">
        Remembered your password? <a href="{{ route('admin.login.form') }}">Sign in</a>
    </div>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.hidden { display: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const sendBtn = document.getElementById('send-btn');
    const sendSpinner = document.getElementById('send-spinner');
    const sendText = document.getElementById('send-text');
    const form = document.getElementById('reset-form');

    const cooldownKey = 'pwResetCooldown_admin';
    const defaultCooldown = {{ session('reset_remaining', 60) }};

    function startCooldown(seconds){
        if(!sendBtn) return;
        const end = Date.now() + seconds * 1000;
        sessionStorage.setItem(cooldownKey, end);
        updateCooldown();
    }

    function updateCooldown(){
        const end = parseInt(sessionStorage.getItem(cooldownKey) || '0', 10);
        const now = Date.now();
        const remaining = Math.ceil((end - now) / 1000);
        if(remaining > 0){
            sendBtn.disabled = true;
            sendText.textContent = `Resend (${remaining}s)`;
            setTimeout(updateCooldown, 500);
        } else {
            sendBtn.disabled = false;
            sendText.textContent = 'Send Password Reset Link';
            sessionStorage.removeItem(cooldownKey);
        }
    }

    // Initialize from server-side flash if available
    @if(session('reset_remaining'))
        startCooldown({{ session('reset_remaining') }});
    @else
        updateCooldown();
    @endif

    if(form && sendBtn){
        form.addEventListener('submit', function(){
            if(sendSpinner) sendSpinner.classList.remove('hidden');
            if(sendText) sendText.textContent = 'Sending...';
            startCooldown(defaultCooldown);
        });
    }
});
</script> 
</div>
@endsection