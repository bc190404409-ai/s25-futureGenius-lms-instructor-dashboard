@extends('layouts.app')

@section('title', 'Add Project')
@section('page_title', 'Add Project')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Media (optional)</label>
            <input type="file" name="media" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Project</button>
    </form>
</div>
@endsection
