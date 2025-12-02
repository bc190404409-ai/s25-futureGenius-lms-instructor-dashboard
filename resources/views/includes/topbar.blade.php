<header class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Instructor Dashboard</h1>

    <div class="flex items-center space-x-4">
        @auth
            <span class="text-gray-700">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default-avatar.png') }}"
                 class="w-10 h-10 rounded-full object-cover border-2 border-indigo-500" alt="User Avatar">

            {{-- Notifications --}}
            <div class="relative">
                @php
                    $unreadCount = Auth::user()->unreadNotifications->count();
                @endphp

                <button class="relative inline-flex items-center px-3 py-2 rounded hover:bg-gray-100">
                    Notifications
                    @if($unreadCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </button>

                <div class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        @forelse(Auth::user()->notifications as $notification)
                        <li class="px-4 py-2 hover:bg-gray-100 {{ $notification->read_at ? 'bg-gray-50' : '' }}">
                            <a href="#" class="block">
                                {{ $notification->data['message'] }}
                                <span class="text-xs text-gray-400 float-right">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                        @empty
                        
                        @endforelse
                    </ul>
                </div>
            </div>
        @endauth
    </div>
</header>
