<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - Kidicode LMS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen">

    {{-- Sidebar --}}
    @include('includes.sidebar')

    {{-- Main content area --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        @include('includes.topbar')

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
