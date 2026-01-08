<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page-bg text-gray-800">
    <a href="#main-content" class="sr-only focus:not-sr-only">Skip to main content</a>
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-brand-600 text-white shadow-sm" aria-label="Sidebar">
        <div class="p-4 border-b border-brand-500">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold">Admin</a>
        </div>
        <nav class="p-4" role="navigation" aria-label="Admin menu">
            <ul class="space-y-2" role="menu">
                <li role="none">
                    <a href="{{ route('admin.dashboard') }}" role="menuitem" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif class="flex items-center gap-2 px-3 py-2 rounded hover:bg-brand-700 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-700 font-medium' : '' }}">
                        <span aria-hidden="true">📊</span> <span class="ml-1">Dashboard</span>
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('admin.instructors.index') }}" role="menuitem" @if(request()->routeIs('admin.instructors.*')) aria-current="page" @endif class="flex items-center gap-2 px-3 py-2 rounded hover:bg-brand-700 {{ request()->routeIs('admin.instructors.*') ? 'bg-brand-700 font-medium' : '' }}">
                        <span aria-hidden="true">👩‍🏫</span> <span class="ml-1">Instructors</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto p-4 border-t border-brand-500">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" aria-label="Log out" class="w-full text-left text-sm text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-white">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main id="main-content" class="flex-1 p-6" role="main">
        <div class="max-w-7xl mx-auto">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>