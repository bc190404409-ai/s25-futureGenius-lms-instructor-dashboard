@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1> My Profile</h1>
</div>

<div class="grid-cols-1" style="max-width: 800px;">
    <div class="card">
        <div class="card-body">
            {{-- Profile Header --}}
            <div style="display: flex; gap: 30px; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e2e8f0;">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: bold;">
                    {{ strtoupper(substr($instructor->name, 0, 1)) }}
                </div>
                <div style="flex: 1;">
                    <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 8px;">{{ $instructor->name }}</h2>
                    <p style="color: #64748b; margin-bottom: 5px;">📧 {{ $instructor->email }}</p>
                    <p style="color: #64748b; margin-bottom: 15px;">📍 {{ trim(($instructor->province ? $instructor->province . ' / ' : '') . ($instructor->city ?? '')) ?: 'No location set' }}</p>
                    <a href="{{ route('instructor.profile.edit') }}" class="btn btn-primary">
                         Edit Profile
                    </a>
                </div>
            </div>

            {{-- Bio Section --}}
            <div style="margin-bottom: 25px;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;"> Bio</h3>
                <p style="color: #475569; line-height: 1.6;">{{ $instructor->bio ?? 'No bio added yet.' }}</p>
            </div>

            {{-- Links Section --}}
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                {{-- LinkedIn --}}
                @if($instructor->linkedin_url)
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #4f46e5;">
                    <p style="font-weight: 600; margin-bottom: 8px;"> LinkedIn</p>
                    <a href="{{ $instructor->linkedin_url }}" target="_blank" style="color: #4f46e5; text-decoration: none; word-break: break-all;">
                        {{ $instructor->linkedin_url }}
                    </a>
                </div>
                @endif

                {{-- Portfolio URL --}}
                @if($instructor->portfolio_url)
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #7c3aed;">
                    <p style="font-weight: 600; margin-bottom: 8px;"> Portfolio URL</p>
                    <a href="{{ $instructor->portfolio_url }}" target="_blank" style="color: #7c3aed; text-decoration: none; word-break: break-all;">
                        {{ $instructor->portfolio_url }}
                    </a>
                </div>
                @endif

                {{-- Portfolio File --}}
                @if($instructor->portfolio_file)
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #06b6d4;">
                    <p style="font-weight: 600; margin-bottom: 8px;"> Portfolio File</p>
                    <a href="{{ asset('storage/' . $instructor->portfolio_file) }}" target="_blank" style="color: #06b6d4; text-decoration: none;">
                        📥 Download Portfolio
                    </a>
                </div>
                @endif

                {{-- Intro Video --}}
                @if($instructor->video_url)
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
                    <p style="font-weight: 600; margin-bottom: 8px;"> Intro Video</p>
                    <a href="{{ $instructor->video_url }}" target="_blank" style="color: #f59e0b; text-decoration: none;">
                        🎬 Watch Video
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
