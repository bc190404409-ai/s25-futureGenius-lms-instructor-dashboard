<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instructor Account Status</title>
    <style>
        .container { font-family: Arial, Helvetica, sans-serif; color:#111827; }
        .btn { display:inline-block; background:#2563eb; color:#fff; padding:10px 16px; border-radius:6px; text-decoration:none; }
        .footer { color:#6b7280; font-size:13px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Account {{ ucfirst($status) }}</h1>

        <p>Hi {{ $instructor->user->name }},</p>

        @if($status === 'disabled')
            <p>Your instructor account has been <strong>disabled</strong> by the administrator{{ $adminName ? ' (' . e($adminName) . ')' : '' }}. If you believe this is a mistake, contact <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">support</a>.</p>
        @else
            <p>Your instructor account has been <strong>enabled</strong> by the administrator{{ $adminName ? ' (' . e($adminName) . ')' : '' }}. You can now <a class="btn" href="{{ route('login.form', ['redirect' => route('dashboard')]) }}">log in to your dashboard</a>.</p>
        @endif

        <p class="footer">Thanks,<br>Kidicode Team</p>
    </div>
</body>
</html>