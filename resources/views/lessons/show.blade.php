@extends('layouts.app')

@section('title', $lesson->title)
@section('content')

<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-3">{{ $lesson->title }}</h1>

    <p class="text-gray-600 mb-4">Course: <strong>{{ $lesson->course->title }}</strong></p>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold mb-2">Lesson Content</h2>

        <p class="leading-relaxed">
            {!! nl2br(e($lesson->content)) !!}
        </p>
    </div>

    <a href="{{ route('lessons.index') }}" class="mt-4 inline-block bg-gray-700 text-white px-4 py-2 rounded">
        Back
    </a>

</div>

@endsection
