<!doctype html>
<html>

<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center p-4">
    @include('auth.partials.admin-login-card', ['action' => route('admin.login'), 'title' => 'Admin Login', 'subtitle' => 'Sign in to the admin panel', 'submitText' => 'Sign in', 'showSocial' => false, 'showRegister' => false])

    <!-- <div class="w-full max-w-md mt-3">
        <a href="{{ route('admin.password.request') }}" class="text-white underline block text-center">Forgot admin password?</a>
    </div> -->
</body>

</html>