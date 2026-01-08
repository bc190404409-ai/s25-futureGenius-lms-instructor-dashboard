<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verification code</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>
    <p>Your verification code is <strong>{{ $otp->code }}</strong>. It expires at {{ $otp->expires_at->toDayDateTimeString() }}.</p>
    <p>If you did not request this, please ignore this message.</p>
</body>
</html>