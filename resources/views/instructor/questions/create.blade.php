@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Add Question</h2>

<form action="{{ route('instructor.assessments.questions.store', $assessment->id) }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block font-medium">Question Text</label>
        <textarea name="question_text" class="w-full border p-2 rounded" required></textarea>
    </div>

    <div>
        <label class="block font-medium">Question Type</label>
        <select name="question_type" class="w-full border p-2 rounded" required>
            <option value="multiple_choice">Multiple Choice</option>
            <option value="true_false">True / False</option>
        </select>
    </div>

    <div>
        <label class="block font-medium">Marks</label>
        <input type="number" name="marks" class="w-full border p-2 rounded" required>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">Save Question</button>
</form>
@endsection
