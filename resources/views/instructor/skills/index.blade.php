@extends('layouts.app')

@section('title', 'My Skills')
@section('page_title', 'My Skills')

@section('content')
<div class="page-header">
    <h1> My Skills</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="margin-bottom: 25px;">
    <a href="{{ route('skills.create') }}" class="btn btn-primary"> Add New Skill</a>
</div>

@if($skills->count() > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>🏷️ Skill Name</th>
                    <th>📂 Type</th>
                    <th> Video Link</th>
                    <th> Status</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skills as $skill)
                    <tr>
                        <td><strong>{{ $skill->skill_name }}</strong></td>
                        <td>{{ $skill->skill_type }}</td>
                        <td>
                            @if($skill->video_link)
                                <a href="{{ $skill->video_link }}" target="_blank" style="color: #4f46e5; text-decoration: none;"> View</a>
                            @else
                                <span style="color: #999;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $skill->status == 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($skill->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-sm" style="background: #3b82f6; color: white; text-decoration: none; display: inline-block;"> Edit</a>
                            <form action="{{ route('skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: #ef4444; color: white; border: none; cursor: pointer;"> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 40px;">
            <p style="font-size: 48px; margin-bottom: 15px;"></p>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 16px;">No skills added yet.</p>
            <a href="{{ route('skills.create') }}" class="btn btn-primary"> Create Your First Skill</a>
        </div>
    </div>
@endif
@endsection
