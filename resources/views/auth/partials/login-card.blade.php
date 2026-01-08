@props([
    'action' => route('login'),
    'title' => 'Login',
    'subtitle' => 'Sign in to your account',
    'submitText' => 'Sign in',
    'showSocial' => true,
])

<div class="w-full max-w-md">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-1">{{ $title }}</h1>
        <p class="text-gray-600 text-sm mb-4">{{ $subtitle }}</p>

        @if(session('status'))
            <div role="status" class="mb-3 p-3 rounded text-sm bg-green-50 text-green-700 border border-green-200">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div role="alert" class="mb-3 p-3 rounded text-sm bg-red-50 text-red-700 border border-red-200">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $action }}" class="space-y-3" aria-label="{{ $title }} form">
            @csrf

            <div>
                <label class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-primary w-full">{{ $submitText }}</button>
        </form>

        @if($showSocial)
            <div class="my-4 flex items-center">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="px-2 text-gray-400 text-xs">Or</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('social.redirect', 'google') }}" class="block w-full text-center border border-gray-200 py-2 rounded text-sm hover:bg-gray-50">Sign in with Google</a>
                <a href="{{ route('social.redirect', 'linkedin') }}" class="block w-full text-center border border-gray-200 py-2 rounded text-sm hover:bg-gray-50">Sign in with LinkedIn</a>
            </div>
        @endif

        <p class="text-center text-gray-600 text-sm mt-4">Don’t have an account? <a href="{{ route('register.form') }}" class="text-blue-600 font-semibold">Register</a></p>
    </div>
</div>
