<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kidicode LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-sm p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-center mb-5 text-blue-700">Instructor Registration</h2>
        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-3 text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-3 text-sm">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-3" >
            @csrf

            <div>
                <label class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition">
                Login
            </button>

            <p class="text-center text-gray-600 text-sm mt-4">
                Don’t have an account?
                <a href="{{ route('register.form') }}" class="text-indigo-600 hover:underline font-medium">
                    Register
                </a>
            </p>
        </form>
    </div>

</body>

</html>