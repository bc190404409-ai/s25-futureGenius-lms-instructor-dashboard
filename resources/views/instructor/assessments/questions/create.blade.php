@extends('layouts.instructor')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Add Questions — {{ $assessment->title }}
</h2>

<div class="bg-white p-6 rounded-lg shadow">

    <form method="POST" action="{{ route('assessment.questions.store', $assessment->id) }}">
        @csrf

        <label class="font-semibold">Question Text</label>
        <textarea name="question_text" class="w-full p-2 border rounded"></textarea>

        <label class="font-semibold mt-4 block">Question Type</label>
        <select name="type" class="w-full p-2 border rounded">
            <option value="mcq">MCQ</option>
            <option value="true_false">True/False</option>
        </select>

        <div class="mt-4">
            <label class="font-semibold">Marks</label>
            <input type="number" name="marks" class="w-full p-2 border rounded" value="1">
        </div>

        <h3 class="mt-6 font-bold">Options</h3>

        <div id="options-area" class="space-y-3 mt-3">

            <div class="flex space-x-3">
                <input type="text" name="options[]" class="w-full p-2 border rounded" placeholder="Option text">
                <input type="checkbox" name="correct[]" value="0"> Correct
            </div>

        </div>

        <button type="button" onclick="addOption()"
                class="mt-3 bg-gray-300 px-3 py-1 rounded">
            + Add Option
        </button>

        <button class="mt-6 bg-indigo-600 text-white px-4 py-2 rounded">Save Question</button>

    </form>

</div>

<script>
    function addOption() {
        let area = document.getElementById('options-area');
        area.insertAdjacentHTML('beforeend', `
            <div class="flex space-x-3">
                <input type="text" name="options[]" class="w-full p-2 border rounded" placeholder="Option text">
                <input type="checkbox" name="correct[]" value="1"> Correct
            </div>
        `);
    }
</script>

@endsection
