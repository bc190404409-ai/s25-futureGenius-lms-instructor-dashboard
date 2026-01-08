<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval - Kidicode LMS</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <h1 class="text-lg font-bold text-gray-800 mb-2">Account Pending Approval</h1>
            <p class="text-gray-600 text-sm mb-4">Thanks for registering — your account is awaiting admin approval. We'll email you once it's approved.</p>

            <div class="space-y-3">
                <a href="{{ route('login.form') }}" class="block w-full bg-blue-600 text-white py-2 rounded font-semibold text-sm hover:bg-blue-700 transition">Back to Login</a>
                <a href="{{ url('/') }}" class="block w-full border border-gray-200 py-2 rounded text-sm hover:bg-gray-50 transition">Return Home</a>
            </div>

            <p class="text-xs text-gray-500 mt-4">Need help? <a href="mailto:support@example.com" class="text-blue-600">support@example.com</a></p>
        </div>
    </div>
</html>