<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Kidicode LMS</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-lg font-bold text-gray-800 mb-2">Verify your email</h1>
            <p class="text-gray-600 text-sm mb-4">Enter the 6-digit code sent to <strong>{{ $user->email }}</strong></p>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm p-3 rounded mb-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded mb-3">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('verify.otp') }}" id="verify-form" class="space-y-3">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                <div>
                    <input type="text" name="code" required maxlength="6" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/\D/g, '')" placeholder="000000" class="w-full border border-gray-300 rounded px-3 py-2 text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button id="verify-btn" type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold text-sm hover:bg-blue-700 transition">Verify</button>
            </form>

            <form method="POST" action="{{ route('resend.otp') }}" id="resend-form" class="mt-3">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                <button id="resend-btn" data-loading-text="Sending..." type="submit" class="w-full border border-gray-200 py-2 rounded text-sm hover:bg-gray-50">Resend Code</button>
            </form>

            <p class="text-xs text-gray-500 text-center mt-4">After verification, your account will await admin approval.</p>
        </div>
    </div> 

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
                    resendBtn.disabled = true;
                    resendSpinner.classList.remove('hidden');
                    resendText.textContent = resendBtn.getAttribute('data-loading-text') || 'Sending...';
                    startCountdown(resendBtn, 'Resend Code', 60);
                });
            }

            if (verifyForm && verifyBtn) {
                verifyForm.addEventListener('submit', function(e){
                    verifyBtn.disabled = true;
                    verifySpinner.classList.remove('hidden');
                    verifyText.textContent = 'Verifying...';
                });
            }
        });
    </script>
</body>
</html>