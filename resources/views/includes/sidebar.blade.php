<div class="w-64 bg-indigo-700 text-white flex flex-col">
    <div class="p-6 text-2xl font-bold border-b border-indigo-500">
        Kidicode LMS
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('instructor.profile') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('instructor.profile') ? 'bg-indigo-600' : '' }}">
            👤 Profile
        </a>
        <a href="{{ route('instructor.courses.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('instructor.courses.*') ? 'bg-indigo-600' : '' }}">
            📚 My Courses
        </a>

        <a href="{{ route('skills.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('skills.*') ? 'bg-indigo-600' : '' }}">
            🧠 Skills
        </a>

        <a href="{{ route('certifications.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('certifications.*') ? 'bg-indigo-600' : '' }}">
            🎓 Certifications
        </a>

        <a href="{{ route('projects.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('projects.*') ? 'bg-indigo-600' : '' }}">
            💼 Projects
        </a>

        <a href="{{ route('availabilities.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('availabilities.*') ? 'bg-indigo-600' : '' }}">
            🕒 Availability
        </a>
        <h3 class="text-sm text-indigo-300 font-semibold mt-6">ASSESSMENTS</h3>

        <a href="{{ route('instructor.assessments.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('assessments.*') ? 'bg-indigo-600' : '' }}">
            📝 Manage Assessments
        </a>

        <a href="{{ route('instructor.assessments.submissions.index') }}"
            class="block px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('assessments.submissions.*') ? 'bg-indigo-600' : '' }}">
            📊 Assessment Submissions
        </a>
    </nav>

    <div class="p-4 border-t border-indigo-500">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded">
                🚪 Logout
            </button>
        </form>
    </div>
</div>