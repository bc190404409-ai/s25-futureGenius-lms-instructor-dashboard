@extends('layouts.app')

@section('title', 'Add Availability')
@section('page_title', 'Add Availability')

@section('content')
<div class="page-header">
    <h1> Add New Availability</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Set Your Availability</h2>
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

            <form action="{{ route('availabilities.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label> Mode</label>
                    <select name="mode" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Mode</option>
                        <option value="online" {{ old('mode') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="in-person" {{ old('mode') == 'in-person' ? 'selected' : '' }}>In-Person</option>
                    </select>
                    @error('mode')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> City (if In-Person)</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('city')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Available Days</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 8px;">
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="days[]" value="{{ $day }}" 
                                {{ (is_array(old('days')) && in_array($day, old('days'))) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <span>{{ $day }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('days')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Time Slots (e.g., 9:00-11:00)</label>
                    <input type="text" name="time_slots[]" placeholder="Morning slot" value="{{ old('time_slots.0') }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" style="margin-bottom: 8px;">
                    <input type="text" name="time_slots[]" placeholder="Afternoon slot" value="{{ old('time_slots.1') }}"
                        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('time_slots')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="card-footer">
                    <a href="{{ route('availabilities.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"> Create Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
