@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        {{-- Display all validation errors at top --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Full Name --}}
            <div>
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $instructor->name) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- City & Phone --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">City</label>
                    <input type="text" name="city" value="{{ old('city', $instructor->city) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('city')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $instructor->phone) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('phone')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- LinkedIn --}}
            <div>
                <label class="block text-gray-700">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $instructor->linkedin_url) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('linkedin_url')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700">Portfolio URL</label>
                <input type="url" name="Portfolio_url" value="{{ old('Portfolio_url', $instructor->Portfolio_url) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('Portfolio_url')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-gray-700">Bio</label>
                <textarea name="bio" rows="4"
                    class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio', $instructor->bio) }}</textarea>
                @error('bio')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Profile Photo --}}
            <div>
                <label class="block text-gray-700">Profile Photo</label>
                <input type="file" name="profile_photo"
                    class="mt-2 border border-gray-300 rounded-md px-3 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('profile_photo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                @if($instructor->profile_photo)
                    <p class="mt-1 text-gray-500">Current: 
                        <img src="{{ asset('storage/' . $instructor->profile_photo) }}" alt="Profile Photo" class="w-16 h-16 rounded-full border">
                    </p>
                @endif
            </div>

            {{-- CV --}}
            <div>
                <label class="block text-gray-700">CV File</label>
                <input type="file" name="cv_file"
                    class="mt-2 border border-gray-300 rounded-md px-3 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('cv_file')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @if($instructor->cv_file)
                    <p class="mt-1 text-gray-500">Current: 
                        <a href="{{ asset('storage/' . $instructor->cv_file) }}" target="_blank" class="text-blue-600 hover:underline">
                            View CV
                        </a>
                    </p>
                @endif
            </div>

            {{-- Intro Video --}}
            <div>
                <label class="block text-gray-700">Intro Video</label>
                <input type="file" name="intro_video"
                    class="mt-2 border border-gray-300 rounded-md px-3 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('intro_video')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @if($instructor->intro_video)
                    <video class="w-full mt-2 rounded-lg" controls>
                        <source src="{{ asset('storage/' . $instructor->intro_video) }}" type="video/mp4">
                        Your browser does not support video playback.
                    </video>
                @endif
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
