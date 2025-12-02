@extends('layouts.app')

@section('title', 'Add Certification')
@section('page_title', 'Add Certification')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Display all errors at top --}}
        @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div>
            <label class="block text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('title')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Issuer</label>
            <input type="text" name="issuer" value="{{ old('issuer') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('issuer')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">File (PDF/JPG/PNG)</label>
            <input type="file" name="file"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('file')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Issue Date</label>
            <input type="date" name="issue_date" value="{{ old('issue_date') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('issue_date')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Expiry Date (optional)</label>
            <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('expiry_date')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Status</label>
            <select name="status"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
                <option value="">Select Status</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approval" {{ old('status') == 'approval' ? 'selected' : '' }}>Approval</option>
            </select>
            @error('status')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Certification</button>
    </form>
</div>
@endsection