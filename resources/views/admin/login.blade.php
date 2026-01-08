<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center p-4">
    @include('auth.partials.login-card', ['action' => route('admin.login'), 'title' => 'Admin Login', 'subtitle' => 'Sign in to the admin panel', 'submitText' => 'Sign in', 'showSocial' => false])
</body>
</html>