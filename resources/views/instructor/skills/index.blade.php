@extends('layouts.app')

@section('title', 'My Skills')
@section('page_title', 'My Skills')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Skills</h2>
    <a href="{{ route('skills.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Skill</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-left p-4">Skill Name</th>
            <th class="text-left p-4">Skill Type</th>
            <th class="text-left p-4">Video Link</th>
            <th class="text-left p-4">Status</th>
            <th class="text-center p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($skills as $skill)
            <tr class="border-b">
                <td class="p-4">{{ $skill->skill_name }}</td>
                <td class="p-4 capitalize">{{ $skill->skill_type }}</td>
                <td class="p-4">
                    @if($skill->video_link)
                        <a href="{{ $skill->video_link }}" class="text-blue-600 hover:underline" target="_blank">View</a>
                    @else
                        N/A
                    @endif
                </td>
                <td class="p-4 capitalize">{{ $skill->status }}</td>
                <td class="p-4 flex justify-center gap-2">
                    <a href="{{ route('skills.edit', $skill) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-300">Edit</a>
                    <form action="{{ route('skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-4 text-gray-500">No skills added yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
