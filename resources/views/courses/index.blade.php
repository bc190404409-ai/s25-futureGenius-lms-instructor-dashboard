@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">My Courses</h1>

<a href="{{ route('instructor.courses.create') }}" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
    + Add New Course
</a>

<table class="min-w-full bg-white shadow-md rounded mb-4">
    <thead>
        <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
            <th class="py-3 px-6">#</th>
            <th class="py-3 px-6">Title</th>
            <th class="py-3 px-6">Price</th>
            <th class="py-3 px-6">Level</th>
            <th class="py-3 px-6">Status</th>
            <th class="py-3 px-6 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($courses as $index => $course)
        <tr class="border-b hover:bg-gray-100">
            <td class="py-3 px-6">{{ $index + 1 }}</td>
            <td class="py-3 px-6">{{ $course->title }}</td>
            <td class="py-3 px-6">{{ $course->price }}</td>
            <td class="py-3 px-6">{{ ucfirst($course->level) }}</td>
            <td class="py-3 px-6">{{ $course->status ?? 'N/A' }}</td>
            <td class="py-3 px-6 text-center space-x-2">
                <a href="{{ route('instructor.courses.edit', $course->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-300">Edit</a>
                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4">No courses found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $courses->links() }}
</div>
@endsection