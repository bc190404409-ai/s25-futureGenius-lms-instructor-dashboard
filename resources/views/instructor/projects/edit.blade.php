@extends('layouts.app')

@section('title', 'Edit Project')
@section('page_title', 'Edit Project')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $project->title) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category', $project->category) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('description', $project->description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Media (optional)</label>
            <input type="file" name="media" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @if($project->media)
                <p class="text-gray-500 mt-1">Current media: 
                    <a href="{{ asset('storage/' . $project->media) }}" target="_blank" class="text-blue-600 hover:underline">View</a>
                </p>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Update Project</button>
    </form>
</div>
@endsection
