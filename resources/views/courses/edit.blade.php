@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Edit Course</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2>Update Course Information</h2>
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div style="background-color: #fee; border-left: 4px solid #ef4444; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
            <p style="color: #991b1b; font-weight: 600; margin-bottom: 8px;">Please fix the following errors:</p>
                <ul style="color: #991b1b; margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Course Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('title')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $course->description) }}</textarea>
                    @error('description')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Thumbnail Image</label>
                    @if($course->thumbnail)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="Thumbnail" style="max-width: 150px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb;">
                        <p style="color: #666; font-size: 12px; margin-top: 8px;">Current thumbnail</p>
                    </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('thumbnail')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $course->price) }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('price')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Level</option>
                        <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status', $course->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ old('status', $course->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $course->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', is_string($course->start_date) ? $course->start_date : ($course->start_date?->format('Y-m-d') ?? '')) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('start_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', is_string($course->end_date) ? $course->end_date : ($course->end_date?->format('Y-m-d') ?? '')) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('end_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="card-footer">
                    <a href="{{ route('instructor.courses.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
