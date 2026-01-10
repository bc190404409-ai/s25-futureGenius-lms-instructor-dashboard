@extends('layouts.app')

@section('title', 'Edit Project')
@section('page_title', 'Edit Project')

@section('content')
<div class="page-header">
    <h1> Edit Project</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Update Your Project</h2>
    </div>
    <div class="card-body">
            @if($errors->any())
            <div style="background-color: #fee; border-left: 4px solid #ef4444; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
                <p style="color: #991b1b; font-weight: 600; margin-bottom: 8px;"> Please fix the following errors:</p>
                <ul style="color: #991b1b; margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label> Project Title</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('title')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>📂 Category</label>
                    <input type="text" name="category" value="{{ old('category', $project->category) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('category')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Description</label>
                    <textarea name="description"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="4">{{ old('description', $project->description) }}</textarea>
                    @error('description')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('start_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>🏁 End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('end_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Project Media (Optional)</label>
                    <input type="file" name="media"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('media')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    @if($project->media)
                    <p style="color: #666; font-size: 12px; margin-top: 8px;">📎 Current media: 
                        <a href="{{ asset('storage/' . $project->media) }}" target="_blank" style="color: #4f46e5; text-decoration: underline;">View</a>
                    </p>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"> Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
