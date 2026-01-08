<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instructor Approved</title>
</head>
<body>
    <h1>Congratulations!</h1>
    <p>Hi {{ $instructor->user->name }},</p>
    <p>Your instructor account has been approved by the administrator. You can now log in and access your instructor dashboard.</p>
    <p><a href="{{ url('/login') }}">Login to Kidicode</a></p>
    <p>Thanks,<br>Kidicode Team</p>
</body>
</html>