@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Add Option</h2>

<form action="{{ route('instructor.questions.options.store', $question->id) }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block font-medium">Option Text</label>
        <input type="text" name="option_text" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium">Is Correct?</label>
        <select name="is_correct" class="w-full border p-2 rounded" required>
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">Save Option</button>
</form>
@endsection
