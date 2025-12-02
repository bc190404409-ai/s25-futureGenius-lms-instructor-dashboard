@extends('layouts.app')

@section('title', 'Edit Availability')
@section('page_title', 'Edit Availability')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Availability</h2>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('availabilities.update', $availability) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 mb-1">Mode</label>
                <select name="mode" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    <option value="online" {{ $availability->mode == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="in-person" {{ $availability->mode == 'in-person' ? 'selected' : '' }}>In-Person</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">City (if in-person)</label>
                <input type="text" name="city" value="{{ $availability->city }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Days</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="days[]" value="{{ $day }}" {{ in_array($day, json_decode($availability->days)) ? 'checked' : '' }} class="form-checkbox">
                            {{ $day }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Time Slots</label>
                @foreach(json_decode($availability->time_slots) as $slot)
                    <input type="text" name="time_slots[]" value="{{ $slot }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300 mb-1">
                @endforeach
                <input type="text" name="time_slots[]" placeholder="Add another time slot" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
                    Update Availability
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
