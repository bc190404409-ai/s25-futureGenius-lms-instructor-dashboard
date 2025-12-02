@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Quiz</h2>

<form action="{{ route('assessments.store') }}" method="POST">
@csrf

<input type="hidden" name="type" value="quiz">

<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
</div>

<div class="form-group">
    <label>Total Marks</label>
    <input type="number" name="total_marks" class="form-control" required>
</div>

<hr>

<h4>Questions</h4>

<div id="questions-wrapper">

    <div class="question-block mb-4 border p-3">
        <label>Question</label>
        <input type="text" name="questions[0][question_text]" class="form-control">

        <label class="mt-2">Options</label>
        <input type="text" class="form-control mt-1" name="questions[0][options][0][option_text]" placeholder="Option 1">
        <input type="text" class="form-control mt-1" name="questions[0][options][1][option_text]" placeholder="Option 2">
        <input type="text" class="form-control mt-1" name="questions[0][options][2][option_text]" placeholder="Option 3">

        <label class="mt-2">Correct Option Index</label>
        <input type="number" class="form-control" name="questions[0][correct_option]">
    </div>

</div>

<button type="button" id="add-question" class="btn btn-secondary">Add Question</button>

<button type="submit" class="btn btn-primary mt-3">Create Quiz</button>

</form>
</div>

<script>
let questionIndex = 1;
document.getElementById('add-question').addEventListener('click', function() {
    let html = `
    <div class="question-block mb-4 border p-3">
        <label>Question</label>
        <input type="text" name="questions[${questionIndex}][question_text]" class="form-control">

        <label class="mt-2">Options</label>
        <input type="text" class="form-control mt-1" name="questions[${questionIndex}][options][0][option_text]" placeholder="Option 1">
        <input type="text" class="form-control mt-1" name="questions[${questionIndex}][options][1][option_text]" placeholder="Option 2">
        <input type="text" class="form-control mt-1" name="questions[${questionIndex}][options][2][option_text]" placeholder="Option 3">

        <label class="mt-2">Correct Option Index</label>
        <input type="number" class="form-control" name="questions[${questionIndex}][correct_option]">
    </div>`;
    
    document.getElementById('questions-wrapper').insertAdjacentHTML('beforeend', html);

    questionIndex++;
});
</script>

@endsection
