@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Options for: {{ $question->question_text }}</h2>

<a href="{{ route('instructor.questions.options.create', $question->id) }}" 
   class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">
    + Add Option
</a>

<table class="w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2 border">Option</th>
            <th class="p-2 border">Correct?</th>
            <th class="p-2 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($options as $option)
        <tr>
            <td class="border p-2">{{ $option->option_text }}</td>
            <td class="border p-2">{{ $option->is_correct ? 'Yes' : 'No' }}</td>
            <td class="border p-2">
                <a href="{{ route('instructor.questions.options.edit', [$question->id, $option->id]) }}" 
                   class="text-green-500">Edit</a> |

                <form action="{{ route('instructor.questions.options.destroy', [$question->id, $option->id]) }}" 
                      method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete this option?')" class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
