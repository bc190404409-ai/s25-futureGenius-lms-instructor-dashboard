@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg p-8 mt-8">
    <div class="flex items-center space-x-6 border-b pb-6 mb-6">
        <img src="{{ $instructor->profile_photo ? asset('storage/'.$instructor->profile_photo) : asset('images/default-avatar.png') }}"
             class="w-32 h-32 rounded-full border-4 border-indigo-500 object-cover" alt="Instructor">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $instructor->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $instructor->city ?? 'City not specified' }}</p>
            <p class="mt-2 text-gray-500">{{ $instructor->bio ?? 'No bio available yet.' }}</p>

            <div class="mt-4 flex space-x-3">
                @if($instructor->linkedin_url)
                    <a href="{{ $instructor->linkedin_url }}" target="_blank"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                       🔗 LinkedIn
                    </a>
                @endif
                @if($instructor->cv_file)
                    <a href="{{ asset('storage/'.$instructor->cv_file) }}" target="_blank"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                       📄 View CV
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- SKILLS --}}
    <section class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-4">Skills</h2>
        @if($instructor->skills->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($instructor->skills as $skill)
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md">
                        <h3 class="font-semibold text-lg">{{ $skill->skill_name }}</h3>
                        <p class="text-sm text-gray-600">Type: {{ ucfirst($skill->skill_type) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Status: {{ ucfirst($skill->status) }}</p>
                        @if($skill->video_link)
                            <a href="{{ $skill->video_link }}" target="_blank"
                               class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                               ▶ Watch Demo
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No skills added yet.</p>
        @endif
    </section>

    {{-- CERTIFICATIONS --}}
    <section class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-4">Certifications</h2>
        @if($instructor->certifications->count())
            <ul class="space-y-4">
                @foreach($instructor->certifications as $cert)
                    <li class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md">
                        <h3 class="font-semibold">{{ $cert->title }}</h3>
                        <p class="text-sm text-gray-600">Issuer: {{ $cert->issuer }}</p>
                        <p class="text-sm text-gray-500">Issued: {{ $cert->issue_date->format('M Y') }}</p>
                        <p class="text-sm text-gray-500">Status: {{ ucfirst($cert->status) }}</p>
                        <a href="{{ asset('storage/'.$cert->file_path) }}" target="_blank"
                           class="text-indigo-600 hover:underline text-sm mt-2 inline-block">📄 View Certificate</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No certifications uploaded yet.</p>
        @endif
    </section>

    {{-- PROJECTS --}}
    <section>
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-4">Projects</h2>
        @if($instructor->projectsCreated->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($instructor->projectsCreated as $project)
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md">
                        <h3 class="font-semibold text-lg">{{ $project->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($project->description, 80) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Status: {{ ucfirst($project->status) }}</p>
                        <p class="text-sm text-gray-500">Duration: {{ $project->start_date }} → {{ $project->end_date }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No projects shared yet.</p>
        @endif
    </section>
</div>
@endsection
