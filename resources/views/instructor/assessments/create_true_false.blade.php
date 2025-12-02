@extends('layouts.app')

@section('title', 'Create True/False Assessment')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create True/False Assessment</h1>

<form action="{{ route('instructor.assessments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="type" value="true_false">

    <div class="mb-4">
        <label>Title</label>
        <input type="text" name="title" class="border rounded px-3 py-2 w-full" required>
    </div>

    <div class="mb-4">
        <label>Course</label>
        <select name="course_id" class="border rounded px-3 py-2 w-full" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
    </div>

    @for($i=1; $i <= $questions_count; $i++)
    <div class="mb-4 p-3 border rounded">
        <h3 class="font-semibold mb-2">Question {{ $i }}</h3>
        <input type="text" name="questions[{{ $i }}][question_text]" placeholder="Enter question" class="border rounded px-3 py-2 w-full mb-2" required>

        <label>Correct Answer</label>
        <select name="questions[{{ $i }}][correct_option]" class="border rounded px-3 py-2 w-full mb-1" required>
            <option value="true">True</option>
            <option value="false">False</option>
        </select>

        <label>Marks</label>
        <input type="number" name="questions[{{ $i }}][marks]" min="0" class="border rounded px-3 py-2 w-full mb-1" required>
    </div>
    @endfor

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save True/False Assessment</button>
</form>
@endsection
