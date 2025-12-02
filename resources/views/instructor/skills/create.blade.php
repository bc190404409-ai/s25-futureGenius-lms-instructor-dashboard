@extends('layouts.app')

@section('title', 'Add Skill')
@section('page_title', 'Add Skill')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('skills.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 mb-1">Skill Name</label>
            <input type="text" name="skill_name" value="{{ old('skill_name') }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Skill Type</label>
            <select name="skill_type" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
                <option value="">Select Type</option>
                <option value="technical">Technical</option>
                <option value="soft">Soft</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Video Link (optional)</label>
            <input type="url" name="video_link" value="{{ old('video_link') }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
                <option value="">Select Status</option>
                <option value="pending" {{ old('status') == 'active' ? 'selected' : '' }}>Pending</option>
                <option value="approval" {{ old('status') == 'inactive' ? 'selected' : '' }}>Approval</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
            Add Skill
        </button>
    </form>
</div>
@endsection
