@extends('layouts.app')

@section('title', 'Select Assessment Type')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Assessment</h1>

<form action="{{ route('instructor.assessments.createForm') }}" method="GET" id="selectTypeForm">
    <div class="mb-4">
        <label class="block font-medium mb-1">Select Assessment Type</label>
        <select name="type" id="assessmentType" class="border rounded px-3 py-2 w-full" required>
            <option value="">-- Select Type --</option>
            <option value="quiz">Quiz</option>
            <option value="assignment">Assignment</option>
            <option value="lab">Lab</option>
            <option value="true_false">True / False</option>
        </select>
    </div>

    <div class="mb-4" id="questionsCountDiv">
        <label class="block font-medium mb-1">Number of Questions</label>
        <input type="number" name="questions_count" id="questionsCount" class="border rounded px-3 py-2 w-full" min="1">
        <p id="questionsError" class="text-red-500 text-sm hidden">Number of questions is not allowed for this type.</p>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Continue</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('assessmentType');
    const questionsDiv = document.getElementById('questionsCountDiv');
    const questionsInput = document.getElementById('questionsCount');
    const questionsError = document.getElementById('questionsError');

    function toggleQuestionsField() {
        const type = typeSelect.value;

        if (type === 'quiz' || type === 'true_false') {
            questionsDiv.style.display = 'block';
            questionsInput.required = true;
            questionsError.classList.add('hidden');
        } else {
            questionsDiv.style.display = 'none';
            questionsInput.required = false;
            questionsInput.value = '';
            questionsError.classList.remove('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleQuestionsField);

    // Initial check in case of old value
    toggleQuestionsField();
});
</script>
@endsection
