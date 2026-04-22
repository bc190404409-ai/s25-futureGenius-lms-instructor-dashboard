<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="page-bg text-gray-800">
    <a href="#main-content" class="sr-only focus:not-sr-only">Skip to main content</a>
<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar" aria-label="Sidebar">
        <h3>Admin Panel</h3>
        <nav role="navigation" aria-label="Admin menu">
            <ul role="menu">
                <li role="none">
                    <a href="{{ route('admin.dashboard') }}" role="menuitem" @if(request()->routeIs('admin.dashboard')) class="active" @endif>
                         Dashboard
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('admin.instructors.index') }}" role="menuitem" @if(request()->routeIs('admin.instructors.*')) class="active" @endif>
                        👩‍🏫 Instructors
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('admin.approvals.certifications') }}" role="menuitem" @if(request()->routeIs('admin.approvals.*')) class="active" @endif>
                        🏆 Certification Approvals
                    </a>
                </li>
            </ul>
        </nav>
        <div class="logout-section">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        @include('includes.topbar')
        @include('partials.flash')
        @yield('content')
    </div>
</div>

    @stack('scripts')
    @yield('scripts')
</body>
</html>