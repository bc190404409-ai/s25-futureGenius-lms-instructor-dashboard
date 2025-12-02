@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Option</h2>

<form action="{{ route('instructor.questions.options.update', [$question->id, $option->id]) }}" 
      method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium">Option Text</label>
        <input type="text" name="option_text" class="w-full border p-2 rounded" value="{{ $option->option_text }}" required>
    </div>

    <div>
        <label class="block font-medium">Is Correct?</label>
        <select name="is_correct" class="w-full border p-2 rounded" required>
            <option value="0" {{ !$option->is_correct ? 'selected' : '' }}>No</option>
            <option value="1" {{ $option->is_correct ? 'selected' : '' }}>Yes</option>
        </select>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">Update Option</button>
</form>
@endsection
