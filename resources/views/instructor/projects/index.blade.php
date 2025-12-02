@extends('layouts.app')

@section('title', 'My Projects')
@section('page_title', 'My Projects')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Projects</h2>
    <a href="{{ route('projects.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Project</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-left p-4">Title</th>
            <th class="text-left p-4">Category</th>
            <th class="text-left p-4">Start Date</th>
            <th class="text-left p-4">End Date</th>
            <th class="text-left p-4">Status</th>
            <th class="text-left p-4">Media</th>
            <th class="text-center p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $project)
            <tr class="border-b">
                <td class="p-4">{{ $project->title }}</td>
                <td class="p-4">{{ $project->category }}</td>
                <td class="p-4">{{ $project->start_date }}</td>
                <td class="p-4">{{ $project->end_date }}</td>
                <td class="p-4 capitalize">{{ $project->status }}</td>
                <td class="p-4">
                    @if($project->media)
                        <a href="{{ asset('storage/' . $project->media) }}" target="_blank" class="text-blue-600 hover:underline">View</a>
                    @else
                        N/A
                    @endif
                </td>
                <td class="p-4 flex justify-center gap-2">
                    <a href="{{ route('projects.edit', $project) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-300">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center p-4 text-gray-500">No projects added yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
