@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-8">
        {{-- Profile Header --}}
        <div class="flex items-center space-x-6">
            <img src="{{ $instructor->profile_photo ? asset('storage/' . $instructor->profile_photo) : asset('images/default-avatar.png') }}"
                 class="w-28 h-28 rounded-full object-cover border-4 border-indigo-500" alt="Profile Photo">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $instructor->name }}</h2>
                <p class="text-gray-600">{{ $instructor->email }}</p>
                <p class="text-gray-500">{{ trim(($instructor->province ? $instructor->province . ' / ' : '') . ($instructor->city ?? '')) ?: 'No location set' }}</p>
                <a href="{{ route('instructor.profile.edit') }}" class="mt-3 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- Bio and Links --}}
        <div class="mt-8 border-t pt-6 space-y-4">
            {{-- Bio --}}
            <h3 class="text-lg font-semibold text-gray-800">Bio</h3>
            <p class="text-gray-600">{{ $instructor->bio ?? 'No bio added yet.' }}</p>

            {{-- LinkedIn --}}
            @if($instructor->linkedin_url)
                <p><strong>LinkedIn:</strong> 
                   <a href="{{ $instructor->linkedin_url }}" target="_blank" class="text-blue-600 hover:underline">
                       {{ $instructor->linkedin_url }}
                   </a>
                </p>
            @endif

            {{-- CV --}}
            {{-- CV removed per request --}}

            {{-- Portfolio File --}}
            @if($instructor->portfolio_file)
                <p><strong>Portfolio:</strong>
                    <a href="{{ asset('storage/' . $instructor->portfolio_file) }}" target="_blank" class="text-blue-600 hover:underline">
                        Download Portfolio
                    </a>
                </p>
            @endif

            {{-- Portfolio URL --}}
            @if($instructor->portfolio_url)
                <p><strong>Portfolio URL:</strong>
                    <a href="{{ $instructor->portfolio_url }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $instructor->portfolio_url }}
                    </a>
                </p>
            @endif

            {{-- Intro Video URL --}}
            @if($instructor->video_url)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mt-4">Intro Video</h3>
                    <p><a href="{{ $instructor->video_url }}" target="_blank" class="text-blue-600 hover:underline">Watch intro</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
