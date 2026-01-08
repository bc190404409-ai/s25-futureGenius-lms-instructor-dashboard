<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kidicode LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center p-4">
    @include('auth.partials.login-card', ['action' => route('login'), 'title' => 'Login', 'subtitle' => 'Sign in to your instructor account', 'submitText' => 'Login', 'showSocial' => true])
</body> 

</html>