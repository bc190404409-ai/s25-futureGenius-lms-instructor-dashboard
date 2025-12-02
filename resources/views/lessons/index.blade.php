@extends('layouts.app')

@section('title', 'Lessons')
@section('page_title', 'Lessons')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Lessons</h2>
        <a href="{{ route('lessons.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
            + Add Lesson
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded p-4">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Course</th>
                    <th class="border px-3 py-2">Title</th>
                    <th class="border px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)
                <tr>
                    <td class="border px-3 py-2">{{ $lesson->id }}</td>
                    <td class="border px-3 py-2">{{ $lesson->course->title }}</td>
                    <td class="border px-3 py-2">{{ $lesson->title }}</td>
                    <td class="border px-3 py-2 flex gap-2">
                        <a href="{{ route('lessons.edit', $lesson->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-400">Edit</a>

                        <form action="{{ route('lessons.destroy', $lesson->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this lesson?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($lessons->count() == 0)
                <tr>
                    <td colspan="4" class="text-center p-4 text-gray-500">No lessons found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
