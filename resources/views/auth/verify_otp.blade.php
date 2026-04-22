@extends('layouts.guest')

@section('title', 'Verify your email')

@section('content')
<div class="login-container">
    <h2>Verify your email</h2>
    <p class="muted text-center mb-3">Enter the 6-digit code sent to <strong>{{ $user->email }}</strong></p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
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

    <form method="POST" action="{{ route('verify.otp') }}" id="verify-form" class="" aria-label="Verify OTP form">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}" />

        <div class="form-group">
            <input type="text" name="code" required maxlength="6" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/\D/g, '')" placeholder="000000" class="otp-input">
        </div>

        <button id="verify-btn" type="submit" class="login-btn" aria-live="polite">
            <span id="verify-text">Verify</span>
            <span id="verify-spinner" class="hidden spinner" style="border-color: rgba(255,255,255,0.6);"></span>
        </button>
    </form>

    <form method="POST" action="{{ route('resend.otp') }}" id="resend-form" class="mt-3">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <button id="resend-btn" data-loading-text="Sending..." type="submit" class="btn-secondary"> <span id="resend-text">Resend Code</span> <span id="resend-spinner" class="hidden spinner"></span></button>
    </form>

    <div class="login-links" style="margin-top:14px;">
        <span style="font-size:12px; color:#666;">After verification, your account will await admin approval.</span>
    </div>
</div>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.hidden { display: none; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const resendBtn = document.getElementById('resend-btn');
        const resendSpinner = document.getElementById('resend-spinner');
        const resendText = document.getElementById('resend-text');
        const resendForm = document.getElementById('resend-form');

        const verifyForm = document.getElementById('verify-form');
        const verifyBtn = document.getElementById('verify-btn');
        const verifySpinner = document.getElementById('verify-spinner');
        const verifyText = document.getElementById('verify-text');

        function startCountdown(button, originalText, seconds=60) {
            if (!button) return;
            button.disabled = true;
            let s = seconds;
            button.textContent = `${originalText} (${s}s)`;
            const iv = setInterval(() => {
                s--;
                button.textContent = `${originalText} (${s}s)`;
                if (s <= 0) {
                    clearInterval(iv);
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }, 1000);
        }

        if (resendForm && resendBtn) {
            resendForm.addEventListener('submit', function(e){
                // show loading state
                if (resendBtn) resendBtn.disabled = true;
                if (resendSpinner) resendSpinner.classList.remove('hidden');
                if (resendText) resendText.textContent = resendBtn.getAttribute('data-loading-text') || 'Sending...';
                startCountdown(resendBtn, 'Resend Code', 60);
            });
        }

        if (verifyForm && verifyBtn) {
            verifyForm.addEventListener('submit', function(e){
                if (verifyBtn) verifyBtn.disabled = true;
                if (verifySpinner) verifySpinner.classList.remove('hidden');
                if (verifyText) verifyText.textContent = 'Verifying...';
            });
        }
    });
</script>
@endsection