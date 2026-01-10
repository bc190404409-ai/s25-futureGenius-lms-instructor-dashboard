@extends('layouts.app')

@section('title', 'Edit Availability')
@section('page_title', 'Edit Availability')

@section('content')
<div class="page-header">
    <h1> Edit Availability</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Update Your Availability</h2>
    </div>
    <div class="card-body">
            @if ($errors->any())
            <div style="background-color: #fee; border-left: 4px solid #ef4444; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
                <p style="color: #991b1b; font-weight: 600; margin-bottom: 8px;"> Please fix the following errors:</p>
                <ul style="color: #991b1b; margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('availabilities.update', $availability) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label> Mode</label>
                    <select name="mode" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="online" {{ $availability->mode == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="in-person" {{ $availability->mode == 'in-person' ? 'selected' : '' }}>In-Person</option>
                    </select>
                    @error('mode')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> City (if In-Person)</label>
                    <input type="text" name="city" value="{{ old('city', $availability->city) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('city')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Available Days</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 8px;">
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="days[]" value="{{ $day }}" 
                                {{ in_array($day, json_decode($availability->days)) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <span>{{ $day }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('days')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Time Slots</label>
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 8px;">
                        @foreach(json_decode($availability->time_slots) as $slot)
                        <input type="text" name="time_slots[]" value="{{ $slot }}"
                            class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @endforeach
                        <input type="text" name="time_slots[]" placeholder="Add another time slot"
                            class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @error('time_slots')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="card-footer">
                    <a href="{{ route('availabilities.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"> Update Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
