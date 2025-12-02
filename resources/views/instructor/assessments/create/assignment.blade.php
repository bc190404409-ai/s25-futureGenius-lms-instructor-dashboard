@extends('layouts.app')

@section('content')
<div class="container">

<h2>Create Assignment</h2>

<form action="{{ route('assessments.store') }}" method="POST">
@csrf

<input type="hidden" name="type" value="assignment">

<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" class="form-control">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
</div>

<div class="form-group">
    <label>Total Marks</label>
    <input type="number" name="total_marks" class="form-control">
</div>

<div class="form-group">
    <label>Due Date</label>
    <input type="datetime-local" name="due_date" class="form-control">
</div>

<button class="btn btn-primary mt-3">Create Assignment</button>

</form>

</div>
@endsection
