@extends('layouts.app')

@section('title', 'Edit Lesson')
@section('page_title', 'Edit Lesson')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

        <h2 class="text-2xl font-bold text-center mb-6">Edit Lesson</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 mb-1">Course</label>
                <select name="course_id" class="w-full border rounded px-3 py-2">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Lesson Title</label>
                <input type="text" name="title"
                       value="{{ $lesson->title }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Content</label>
                <textarea name="content"
                          class="w-full border rounded px-3 py-2"
                          rows="4">{{ $lesson->content }}</textarea>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">
                Update Lesson
            </button>
        </form>

    </div>
</div>
@endsection
