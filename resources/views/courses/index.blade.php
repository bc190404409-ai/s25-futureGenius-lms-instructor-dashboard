@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>My Courses</h1>
</div>

<div style="display: flex; gap: 16px; margin-bottom: 24px;">
    <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">Add New Course</a>
</div>

<div class="table-container">
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Price</th>
                <th>Level</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $index => $course)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $course->title }}</td>
                <td>${{ number_format($course->price, 2) }}</td>
                <td>
                    @if($course->level == 'beginner')
                        <span class="badge badge-primary">Beginner</span>
                    @elseif($course->level == 'intermediate')
                        <span class="badge badge-warning">Intermediate</span>
                    @else
                        <span class="badge badge-success">Advanced</span>
                    @endif
                </td>
                <td>
                    @if($course->status == 'published')
                        <span class="badge badge-success">Published</span>
                    @elseif($course->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-secondary">Archived</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn btn-sm btn-secondary" style="display: inline-block; margin-right: 8px;">Edit</a>
                    <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this course?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #999;">No courses found. <a href="{{ route('instructor.courses.create') }}" style="color: #4f46e5; text-decoration: underline;">Create your first course</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($courses->hasPages())
<div style="margin-top: 24px; display: flex; justify-content: center;">
    {{ $courses->links() }}
</div>
@endif
@endsection