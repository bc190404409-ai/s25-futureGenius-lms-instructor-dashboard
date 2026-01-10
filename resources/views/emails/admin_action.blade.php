<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($type) }} {{ $status }}</title>
</head>
<body>
    <h1>{{ ucfirst($type) }} {{ $status }}</h1>

    <p>Hi {{ $item->instructor->user->name ?? $item->creator->name ?? 'Instructor' }},</p>

    <p>
        Your {{ strtolower($type) }} "{{ $item->title ?? $item->skill_name ?? 'item' }}" has been <strong>{{ $status }}</strong> by an administrator.
    </p>

    <p>If you have any questions, please contact support.</p>

    <p>Thanks,<br>Kidicode Team</p>
</body>
</html>
