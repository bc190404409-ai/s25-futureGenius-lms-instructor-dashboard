@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Questions for: {{ $assessment->title }}</h2>

<a href="{{ route('instructor.assessments.questions.create', $assessment->id) }}" 
   class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">
    + Add New Question
</a>

<table class="w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2 border">Question</th>
            <th class="p-2 border">Type</th>
            <th class="p-2 border">Marks</th>
            <th class="p-2 border">Options</th>
            <th class="p-2 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
        <tr>
            <td class="border p-2">{{ $question->question_text }}</td>
            <td class="border p-2">{{ ucfirst($question->question_type) }}</td>
            <td class="border p-2">{{ $question->marks }}</td>
            <td class="border p-2">
                @if ($question->question_type == 'multiple_choice')
                    <a href="{{ route('instructor.questions.options.index', $question->id) }}" 
                       class="text-blue-500 underline">Manage Options</a>
                @else
                    — 
                @endif
            </td>
            <td class="border p-2">
                <a href="{{ route('instructor.assessments.questions.edit', [$assessment->id, $question->id]) }}" 
                   class="text-green-500">Edit</a> |
                <form action="{{ route('instructor.assessments.questions.destroy', [$assessment->id, $question->id]) }}"
                      method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-500" onclick="return confirm('Delete this question?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
