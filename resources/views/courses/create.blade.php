@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Course</h1>

{{-- Global error messages --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-4">
    @csrf

    <div>
        <label class="block font-medium mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2" required>
        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Thumbnail</label>
        <input type="file" name="thumbnail" class="w-full border rounded px-3 py-2">
        @error('thumbnail') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Price</label>
        <input type="number" name="price" step="0.01" value="{{ old('price', 0) }}" class="w-full border rounded px-3 py-2" required>
        @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Level</label>
        <select name="level" class="w-full border rounded px-3 py-2" required>
            <option value="beginner" {{ old('level')=='beginner' ? 'selected':'' }}>Beginner</option>
            <option value="intermediate" {{ old('level')=='intermediate' ? 'selected':'' }}>Intermediate</option>
            <option value="advanced" {{ old('level')=='advanced' ? 'selected':'' }}>Advanced</option>
        </select>
        @error('level') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2" required>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border rounded px-3 py-2">
        @error('start_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium mb-1">End Date</label>
        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border rounded px-3 py-2">
        @error('end_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('instructor.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </div>
</form>
@endsection
