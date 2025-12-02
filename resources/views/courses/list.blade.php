@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-3xl mb-4">Available Courses</h2>

    @foreach ($courses as $course)
        <div class="p-4 mb-3 bg-white shadow rounded">
            <h3 class="text-xl font-bold">{{ $course->name }}</h3>
            <p>{{ $course->description }}</p>

            <form action="{{ route('course.enroll', $course->id) }}" method="POST">
                @csrf
                <button class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">
                    Enroll Now
                </button>
            </form>
        </div>
    @endforeach
</div>
@endsection
