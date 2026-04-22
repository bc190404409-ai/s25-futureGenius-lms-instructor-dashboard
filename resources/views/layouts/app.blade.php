<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - Kidicode LMS</title>
    <link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">
    @vite('resources/css/app.css')
</head>
<body class="page-bg font-sans">

<div class="flex h-screen">

    {{-- Sidebar --}}
    @include('includes.sidebar')

    {{-- Main content area --}}
    <div class="main-wrapper">

        {{-- Topbar --}}
        @include('includes.topbar')

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
