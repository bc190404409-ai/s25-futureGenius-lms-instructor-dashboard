@extends('layouts.app')

@section('title', 'My Certifications')
@section('page_title', 'My Certifications')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Certifications</h2>
    <a href="{{ route('certifications.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Certification</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-left p-4">Title</th>
            <th class="text-left p-4">Issuer</th>
            <th class="text-left p-4">File</th>
            <th class="text-left p-4">Issue Date</th>
            <th class="text-left p-4">Expiry Date</th>
            <th class="text-left p-4">Status</th>
            <th class="text-center p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($certifications as $cert)
            <tr class="border-b">
                <td class="p-4">{{ $cert->title }}</td>
                <td class="p-4">{{ $cert->issuer }}</td>
                <td class="p-4">
                    <a href="{{ asset('storage/' . $cert->file_path) }}" class="text-blue-600 hover:underline" target="_blank">View</a>
                </td>
                <td class="p-4">{{ $cert->issue_date }}</td>
                <td class="p-4">{{ $cert->expiry_date ?? 'N/A' }}</td>
                <td class="p-4 capitalize">{{ $cert->status }}</td>
                <td class="p-4 flex justify-center gap-2">
                    <a href="{{ route('certifications.edit', $cert) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-300">Edit</a>
                    <form action="{{ route('certifications.destroy', $cert) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center p-4 text-gray-500">No certifications added yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
