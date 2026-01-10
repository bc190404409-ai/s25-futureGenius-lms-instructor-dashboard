@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1> Edit Profile</h1>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <ul style="list-style: disc; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Update Your Information</h2>
    </div>
    <div class="card-body">
            <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label> Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $instructor->name) }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <!-- Location -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    <div class="form-group">
                        <label> Province</label>
                        <input type="text" name="province" value="{{ old('province', $instructor->province) }}"
                            class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('province')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label> City</label>
                        <input type="text" name="city" value="{{ old('city', $instructor->city) }}"
                            class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('city')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label> Street</label>
                        <input type="text" name="street" value="{{ old('street', $instructor->street) }}"
                            class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('street')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label> Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $instructor->phone) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('phone')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <!-- Links -->
                <div class="form-group">
                    <label> LinkedIn URL</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $instructor->linkedin_url) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('linkedin_url')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Portfolio URL</label>
                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $instructor->portfolio_url) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('portfolio_url')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <!-- Profile Photo -->
                <div class="form-group">
                    <label> Profile Photo</label>
                    <input type="file" name="profile_photo" accept="image/*"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('profile_photo')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror

                    @if($instructor->profile_photo)
                    <p style="color: #666; font-size: 12px; margin-top: 8px;">📎 Current photo:
                        <img src="{{ asset('storage/' . $instructor->profile_photo) }}" alt="Profile Photo" style="width: 60px; height: 60px; border-radius: 50%; border: 1px solid #e5e7eb; margin-top: 4px;">
                    </p>
                    @endif
                </div>

                <!-- Intro Video URL -->
                <div class="form-group">
                    <label> Intro Video URL</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $instructor->video_url) }}" placeholder="https://youtube.com/..."
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('video_url')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                    @if($instructor->video_url)
                    <p style="color: #666; font-size: 12px; margin-top: 8px;">📎 Current video: 
                        <a href="{{ $instructor->video_url }}" target="_blank" style="color: #4f46e5; text-decoration: underline;">View Video Link</a>
                    </p>
                    @endif
                </div>

                <!-- Bio -->
                <div class="form-group">
                    <label> Bio</label>
                    <textarea name="bio" rows="5"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio', $instructor->bio) }}</textarea>
                    @error('bio')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <!-- Buttons -->
                <div class="card-footer">
                    <a href="{{ route('instructor.profile') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
