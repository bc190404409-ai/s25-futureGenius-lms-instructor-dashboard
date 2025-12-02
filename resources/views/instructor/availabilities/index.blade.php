@extends('layouts.app')

@section('title', 'My Availabilities')
@section('page_title', 'My Availabilities')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Availabilities</h2>
    <a href="{{ route('availabilities.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Availability</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-left p-4">Mode</th>
            <th class="text-left p-4">City</th>
            <th class="text-left p-4">Days</th>
            <th class="text-left p-4">Time Slots</th>
            <th class="text-center p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($availabilities as $availability)
            <tr class="border-b">
                <td class="p-4 capitalize">{{ $availability->mode }}</td>
                <td class="p-4">{{ $availability->city ?? '-' }}</td>
                <td class="p-4">{{ implode(', ', json_decode($availability->days)) }}</td>
                <td class="p-4">{{ implode(', ', json_decode($availability->time_slots)) }}</td>
                <td class="p-4 flex justify-center gap-2">
                    <a href="{{ route('availabilities.edit', $availability) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-300">Edit</a>
                    <form action="{{ route('availabilities.destroy', $availability) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-4 text-gray-500">No availabilities added yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
