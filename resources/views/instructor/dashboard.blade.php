@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Instructor Dashboard</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow-md rounded-xl p-6 text-center border-t-4 border-indigo-600">
            <h2 class="text-lg font-semibold text-gray-700">Skills</h2>
            <p class="text-3xl font-bold text-indigo-700 mt-2">{{ $stats['skills'] }}</p>
        </div>
        <div class="bg-white shadow-md rounded-xl p-6 text-center border-t-4 border-green-600">
            <h2 class="text-lg font-semibold text-gray-700">Certifications</h2>
            <p class="text-3xl font-bold text-green-700 mt-2">{{ $stats['certifications'] }}</p>
        </div>
        <div class="bg-white shadow-md rounded-xl p-6 text-center border-t-4 border-blue-600">
            <h2 class="text-lg font-semibold text-gray-700">Projects</h2>
            <p class="text-3xl font-bold text-blue-700 mt-2">{{ $stats['projects'] }}</p>
        </div>
        <div class="bg-white shadow-md rounded-xl p-6 text-center border-t-4 border-yellow-600">
            <h2 class="text-lg font-semibold text-gray-700">Availability Slots</h2>
            <p class="text-3xl font-bold text-yellow-700 mt-2">{{ $stats['availabilities'] }}</p>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Recent Skills --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <h3 class="font-semibold text-gray-700 text-lg mb-4 border-b pb-2">Recent Skills</h3>
            <ul>
                @forelse($recentSkills as $skill)
                    <li class="py-2 border-b last:border-none flex justify-between">
                        <span>{{ $skill->skill_name }}</span>
                        <span class="text-sm text-gray-500">{{ ucfirst($skill->status) }}</span>
                    </li>
                @empty
                    <p class="text-gray-500 text-sm">No recent skills found.</p>
                @endforelse
            </ul>
        </div>

        {{-- Recent Certifications --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <h3 class="font-semibold text-gray-700 text-lg mb-4 border-b pb-2">Recent Certifications</h3>
            <ul>
                @forelse($recentCerts as $cert)
                    <li class="py-2 border-b last:border-none flex justify-between">
                        <span>{{ $cert->title }}</span>
                        <span class="text-sm text-gray-500">{{ ucfirst($cert->status) }}</span>
                    </li>
                @empty
                    <p class="text-gray-500 text-sm">No recent certifications found.</p>
                @endforelse
            </ul>
        </div>

        {{-- Recent Projects --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <h3 class="font-semibold text-gray-700 text-lg mb-4 border-b pb-2">Recent Projects</h3>
            <ul>
                @forelse($recentProjects as $proj)
                    <li class="py-2 border-b last:border-none flex justify-between">
                        <span>{{ $proj->project_title }}</span>
                        <span class="text-sm text-gray-500">{{ ucfirst($proj->status) }}</span>
                    </li>
                @empty
                    <p class="text-gray-500 text-sm">No recent projects found.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
