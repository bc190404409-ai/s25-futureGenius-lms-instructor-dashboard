@extends('layouts.app')

@section('title', 'Add Skill')
@section('page_title', 'Add Skill')

@section('content')
<div class="page-header">
    <h1> Add New Skill</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Create Your Skill</h2>
    </div>
    <div class="card-body">
            <form action="{{ route('skills.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label> Skill Name</label>
                    <input type="text" name="skill_name" value="{{ old('skill_name') }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('skill_name')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>📂 Skill Type</label>
                    <select name="skill_type" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Type</option>
                        <option value="technical" {{ old('skill_type') == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="soft" {{ old('skill_type') == 'soft' ? 'selected' : '' }}>Soft</option>
                        <option value="other" {{ old('skill_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('skill_type')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Video Link (Optional)</label>
                    <input type="url" name="video_link" value="{{ old('video_link') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('video_link')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Status</label>
                    <select name="status"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    </select>
                    @error('status')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="card-footer">
                    <a href="{{ route('skills.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"> Create Skill</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
