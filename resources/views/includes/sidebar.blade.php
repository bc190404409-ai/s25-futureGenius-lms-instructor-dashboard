<link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">
<div class="sidebar">
    <div class="logo">🎓 Kidicode LMS</div>

    <nav>
        <a href="{{ route('dashboard') }}"
            class="@if(request()->routeIs('dashboard')) active @endif">
            📊 Dashboard
        </a>
        <a href="{{ route('instructor.profile') }}"
            class="@if(request()->routeIs('instructor.profile')) active @endif">
            👤 Profile
        </a>
        <a href="{{ route('instructor.courses.index') }}"
            class="@if(request()->routeIs('instructor.courses.*')) active @endif">
            📚 My Courses
        </a>

        <a href="{{ route('skills.index') }}"
            class="@if(request()->routeIs('skills.*')) active @endif">
            🧠 Skills
        </a>

        <a href="{{ route('certifications.index') }}"
            class="@if(request()->routeIs('certifications.*')) active @endif">
            🏆 Certifications
        </a>

        <a href="{{ route('projects.index') }}"
            class="@if(request()->routeIs('projects.*')) active @endif">
            💼 Projects
        </a>

        <a href="{{ route('availabilities.index') }}"
            class="@if(request()->routeIs('availabilities.*')) active @endif">
            🕒 Availability
        </a>
        </a>
    </nav>

    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">🚪 Logout</button>
        </form>
    </div>
</div>