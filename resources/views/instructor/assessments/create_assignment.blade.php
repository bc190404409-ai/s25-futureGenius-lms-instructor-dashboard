@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Assignment</h1>

<form action="{{ route('instructor.assessments.store') }}" method="POST">
    @csrf

    <input type="hidden" name="type" value="assignment">

    <div class="mb-4">
        <label class="block font-semibold">Title</label>
        <input type="text" name="title" class="border rounded px-3 py-2 w-full" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Course</label>
        <select name="course_id" class="border rounded px-3 py-2 w-full" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Description</label>
        <textarea name="description" class="border rounded px-3 py-2 w-full"></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Due Date</label>
        <input type="date" name="due_date" class="border rounded px-3 py-2 w-full">
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Number of Questions</label>
        <input type="number" name="questions_count" id="questions_count" min="1" class="border rounded px-3 py-2 w-full" required>
    </div>

    <div id="questions-container"></div>

    <div class="mb-4">
        <label class="block font-semibold">Total Marks</label>
        <input type="number" name="total_marks" id="total_marks" class="border rounded px-3 py-2 w-full" readonly required>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
        
    </button>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Assignment</button>
</form>

<script>
document.getElementById('questions_count').addEventListener('change', function () {
    let count = this.value;
    let container = document.getElementById('questions-container');
    container.innerHTML = '';

    for (let i = 1; i <= count; i++) {
        container.innerHTML += `
            <div class="mb-4 p-3 border rounded">
                <h3 class="font-semibold mb-2">Task / Question ${i}</h3>
                <textarea name="questions[${i}][question_text]" class="border rounded px-3 py-2 w-full mb-2" required></textarea>
                <label>Marks</label>
                <input type="number" name="questions[${i}][marks]" class="marks border rounded px-3 py-2 w-full" min="0" required>
            </div>
        `;
    }

    calculateTotal();
});

document.addEventListener('input', function (e) {
    if (e.target.classList.contains('marks')) {
        calculateTotal();
    }
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.marks').forEach(input => {
        total += Number(input.value) || 0;
    });
    document.getElementById('total_marks').value = total;
}
</script>
@endsection
