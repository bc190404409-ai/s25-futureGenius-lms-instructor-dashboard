@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Question</h2>

<form action="{{ route('instructor.assessments.questions.update', [$assessment->id, $question->id]) }}" 
      method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium">Question Text</label>
        <textarea name="question_text" class="w-full border p-2 rounded" required>{{ $question->question_text }}</textarea>
    </div>

    <div>
        <label class="block font-medium">Question Type</label>
        <select name="question_type" class="w-full border p-2 rounded" required>
            <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
            <option value="true_false" {{ $question->question_type == 'true_false' ? 'selected' : '' }}>True / False</option>
        </select>
    </div>

    <div>
        <label class="block font-medium">Marks</label>
        <input type="number" name="marks" class="w-full border p-2 rounded" value="{{ $question->marks }}" required>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">Update Question</button>
</form>
@endsection
