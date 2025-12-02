@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-3xl mb-4">My Courses</h2>

    @forelse ($courses as $course)
        <div class="p-4 mb-3 bg-white shadow rounded">
            <h3 class="text-xl font-bold">{{ $course->name }}</h3>
            <a href="{{ route('lessons.index', $course->id) }}" class="text-blue-600 underline">View Lessons</a>
        </div>
    @empty
        <p class="text-gray-600">You are not enrolled in any course yet.</p>
    @endforelse
</div>
@endsection
