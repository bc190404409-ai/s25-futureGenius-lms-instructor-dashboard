<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kidicode LMS</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Register</h1>
            <p class="text-gray-600 text-sm mb-6">Create your instructor account</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold text-sm hover:bg-blue-700 transition">
                    Create Account
                </button>
            </form>

            <div class="my-4 flex items-center">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2 text-gray-500 text-xs">Or</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('social.redirect', 'google') }}" class="block w-full border border-gray-300 text-gray-800 py-2 rounded font-semibold text-sm hover:bg-gray-50 transition text-center">
                    Sign up with Google
                </a>
                <a href="{{ route('social.redirect', 'linkedin') }}" class="block w-full border border-gray-300 text-gray-800 py-2 rounded font-semibold text-sm hover:bg-gray-50 transition text-center">
                    Sign up with LinkedIn
                </a>
            </div>

            <p class="text-center text-gray-600 text-sm mt-4">
                Already have an account?
                <a href="{{ route('login.form') }}" class="text-blue-600 font-semibold hover:underline">Sign in</a>
            </p>
        </div>
    </div>

</body>
</html>