<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instructor Request Not Approved</title>
    <style>
        .container { font-family: Arial, Helvetica, sans-serif; color:#111827; }
        .footer { color:#6b7280; font-size:13px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Regarding Your Instructor Request</h1>
        <p>Hi {{ $instructor->user->name }},</p>

        <p>
            We reviewed your instructor request and it was <strong>not approved</strong> at this time{{ $adminName ? ' by ' . e($adminName) : '' }}.
        </p>

        @if(!empty($reason))
            <p><strong>Reason:</strong> {{ e($reason) }}</p>
        @endif

        <p>If you believe this decision is in error or would like feedback on how to proceed, reply to this message or contact <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">support</a>.</p>

        <p class="footer">Thanks,<br>Kidicode Team</p>
    </div>
</body>
</html>