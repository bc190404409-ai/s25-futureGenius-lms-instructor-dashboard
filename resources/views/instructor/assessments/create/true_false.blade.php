@extends('layouts.app')

@section('content')
<div class="container">

<h2>Create True/False Assessment</h2>

<form method="POST" action="{{ route('assessments.store') }}">
@csrf

<input type="hidden" name="type" value="true_false">

<div class="form-group">
    <label>Assessment Title</label>
    <input type="text" name="title" class="form-control">
</div>

<hr>

<h4>Questions</h4>
<div id="tf-wrapper">

    <div class="border p-3 mb-3">
        <label>Question</label>
        <input type="text" class="form-control" name="questions[0][question_text]">

        <label class="mt-2">Correct Answer</label>
        <select name="questions[0][correct]" class="form-control">
            <option value="true">True</option>
            <option value="false">False</option>
        </select>
    </div>

</div>

<button type="button" id="add-tf" class="btn btn-secondary">Add Question</button>

<button class="btn btn-primary mt-3">Create True/False Assessment</button>

</form>

</div>

<script>
let tfIndex = 1;

document.getElementById('add-tf').addEventListener('click', function(){
    let html = `
    <div class="border p-3 mb-3">
        <label>Question</label>
        <input type="text" class="form-control" name="questions[${tfIndex}][question_text]">

        <label class="mt-2">Correct Answer</label>
        <select name="questions[${tfIndex}][correct]" class="form-control">
            <option value="true">True</option>
            <option value="false">False</option>
        </select>
    </div>
    `;
    document.getElementById('tf-wrapper').insertAdjacentHTML('beforeend', html);
    tfIndex++;
});
</script>

@endsection
