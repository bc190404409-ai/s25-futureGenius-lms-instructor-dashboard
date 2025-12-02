@extends('layouts.app')

@section('title', 'Add Availability')
@section('page_title', 'Add Availability')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('availabilities.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 mb-1">Mode</label>
            <select name="mode" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
                <option value="online" {{ old('mode') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="in-person" {{ old('mode') == 'in-person' ? 'selected' : '' }}>In-Person</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">City (if in-person)</label>
            <input type="text" name="city" value="{{ old('city') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Days</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="days[]" value="{{ $day }}" {{ (is_array(old('days')) && in_array($day, old('days'))) ? 'checked' : '' }} class="form-checkbox">
                        {{ $day }}
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Time Slots</label>
            <input type="text" name="time_slots[]" placeholder="e.g. 9:00-11:00" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300 mb-1">
            <input type="text" name="time_slots[]" placeholder="e.g. 14:00-16:00" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Availability</button>
    </form>
</div>
@endsection
