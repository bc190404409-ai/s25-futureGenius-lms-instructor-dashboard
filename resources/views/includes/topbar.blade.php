<header class="topbar flex items-center justify-between px-4 py-3 bg-white border-b">
    <div class="flex items-center space-x-4">
        <h2 class="text-lg font-semibold">📊 Dashboard</h2>

        <!-- <div class="relative max-w-md">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center" onsubmit="return true;">
                <label for="topbar-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input id="topbar-search" name="q" type="search" placeholder="Search for instructors, certifications, courses..." value="{{ request('q', '') }}" class="w-full pl-10 pr-3 py-2 rounded-full border border-gray-200 shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" autocomplete="off" />
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.386a1 1 0 01-1.414 1.415l-3.387-3.386zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <button type="submit" class="ml-3 inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-full shadow">Search</button>
            </form>

            <div id="topbar-suggestions" class="hidden absolute mt-2 left-0 w-full bg-white border border-gray-100 rounded-md shadow-lg z-50 overflow-auto" style="max-height:280px;"></div>
        </div> -->
    </div>

    <div class="user-info">
        @auth
            <div class="flex items-center space-x-3">
                <span class="user-name text-sm">{{ Auth::user()->name }}</span>
                <!-- <form method="POST" action="{{ route('admin.logout') }}" class="ml-3">
                    @csrf
                    <button type="submit" class="btn text-sm bg-gray-100 hover:bg-gray-200">Logout</button>
                </form> -->
            </div>
        @endauth
    </div>
</header>

@push('scripts')
<script>
(() => {
    const input = document.getElementById('topbar-search');
    const box = document.getElementById('topbar-suggestions');
    if (!input || !box) return;

    const adminUrl = '{{ route('admin.search') }}';
    const instructorUrl = '{{ route('instructor.search') }}';

    let timeout = null;

    input.addEventListener('input', (e) => {
        clearTimeout(timeout);
        const q = e.target.value.trim();
        if (q.length < 2) { box.classList.add('hidden'); box.innerHTML = ''; return; }
        timeout = setTimeout(() => fetchSuggestions(q), 250);
    });

    function currentScopeUrl(){
        const path = window.location.pathname;
        if (path.startsWith('/admin')) return adminUrl;
        if (path.startsWith('/instructor')) return instructorUrl;
        return adminUrl; // default to admin suggestions when unsure
    }

    function fetchSuggestions(q){
        const url = new URL(currentScopeUrl(), window.location.origin);
        url.searchParams.set('q', q);
        fetch(url.toString(), { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(renderSuggestions)
            .catch(err => { console.error(err); box.classList.add('hidden'); });
    }

    function renderSuggestions(items){
        if (!items || !items.length){ box.classList.add('hidden'); box.innerHTML=''; return; }
        box.classList.remove('hidden');
        box.innerHTML = '';
        items.forEach(it => {
            const el = document.createElement('a');
            el.href = it.url;
            el.className = 'block px-3 py-2 hover:bg-gray-100 text-sm text-gray-800 border-b last:border-b-0';
            el.textContent = it.label;
            box.appendChild(el);
        });
    }

    document.addEventListener('click', (e) => {
        if (!box.contains(e.target) && e.target !== input) { box.classList.add('hidden'); }
    });
})();
</script>
@endpush
