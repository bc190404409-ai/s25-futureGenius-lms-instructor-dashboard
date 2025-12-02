@extends('layouts.app')

@section('title', 'Add Lesson')
@section('page_title', 'Add Lesson')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

        <h2 class="text-2xl font-bold text-center mb-6">Create Lesson</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lessons.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 mb-1">Course</label>
                <select name="course_id"
                        class="w-full border rounded px-3 py-2">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Lesson Title</label>
                <input type="text" name="title"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Enter lesson title">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Content</label>
                <textarea name="content"
                          class="w-full border rounded px-3 py-2"
                          rows="4"
                          placeholder="Lesson description"></textarea>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">
                Create Lesson
            </button>
        </form>

    </div>
</div>
@endsection
