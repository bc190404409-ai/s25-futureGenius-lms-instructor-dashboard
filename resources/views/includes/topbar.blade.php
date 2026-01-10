<header class="topbar">
    <h2>📊 Instructor Dashboard</h2>

    <div class="user-info">
        @auth
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span class="user-name">{{ Auth::user()->name }}</span>
        @endauth
    </div>
</header>
