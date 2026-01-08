@extends('layouts.app')

@section('title', 'Create Quiz')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Quiz</h1>

<form action="{{ route('instructor.assessments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="type" value="quiz">

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

        <label>Option 1</label>
        <input type="text" name="questions[{{ $i }}][options][0][option_text]" class="border rounded px-3 py-2 w-full mb-1" required>
        <label>Option 2</label>
        <input type="text" name="questions[{{ $i }}][options][1][option_text]" class="border rounded px-3 py-2 w-full mb-1" required>
        <label>Option 3</label>
        <input type="text" name="questions[{{ $i }}][options][2][option_text]" class="border rounded px-3 py-2 w-full mb-1">
        <label>Option 4</label>
        <input type="text" name="questions[{{ $i }}][options][3][option_text]" class="border rounded px-3 py-2 w-full mb-1">

        <label>Correct Option (0-3)</label>
        <input type="number" name="questions[{{ $i }}][correct_option]" min="0" max="3" class="border rounded px-3 py-2 w-full mb-1" required>
    </div>
    @endfor
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Quiz</button>
</form>
@endsection
