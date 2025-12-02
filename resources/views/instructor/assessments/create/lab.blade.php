@extends('layouts.app')

@section('content')
<div class="container">

<h2>Create Lab Task</h2>

<form action="{{ route('assessments.store') }}" method="POST">
@csrf

<input type="hidden" name="type" value="lab">

<div class="form-group">
    <label>Lab Title</label>
    <input type="text" name="title" class="form-control">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description"></textarea>
</div>

<div class="form-group">
    <label>Total Marks</label>
    <input type="number" name="total_marks" class="form-control">
</div>

<button class="btn btn-primary mt-3">Create Lab</button>

</form>

</div>
@endsection
