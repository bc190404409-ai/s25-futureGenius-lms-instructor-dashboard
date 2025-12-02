<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Registration - Kidicode LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-sm p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-center mb-5 text-blue-700">Instructor Registration</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            <div>
                <label class="block text-gray-700 text-sm mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Password</label>
                <input type="password" name="password" placeholder="Enter password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-500 transition duration-200">
                Register
            </button>

            <p class="text-center text-gray-500 text-sm mt-4">
                Already have an account?
                <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline font-medium">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
