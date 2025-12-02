@extends('layouts.app')

@section('title', 'Manage Assessments')

@section('content')
<h1 class="text-2xl font-bold mb-4">Assessments</h1>

<a href="{{ route('instructor.assessments.create') }}" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
    + Add New Assessment
</a>

<table class="min-w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="py-2 px-4">#</th>
            <th class="py-2 px-4">Title</th>
            <th class="py-2 px-4">Course</th>
            <th class="py-2 px-4">Type</th>
            <th class="py-2 px-4">Total Marks</th>
            <th class="py-2 px-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assessments as $index => $assessment)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $index + 1 }}</td>
            <td class="py-2 px-4">{{ $assessment->title }}</td>
            <td class="py-2 px-4">{{ $assessment->course->title ?? 'N/A' }}</td>
            <td class="py-2 px-4">{{ ucfirst($assessment->type) }}</td>
            <td class="py-2 px-4">{{ $assessment->total_marks }}</td>
            <td class="py-2 px-4 space-x-2">
                <a href="{{ route('instructor.assessments.edit', $assessment->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('instructor.assessments.destroy', $assessment->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4">No assessments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
