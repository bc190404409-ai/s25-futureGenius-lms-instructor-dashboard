@extends('layouts.app')

@section('title', 'My Projects')
@section('page_title', 'My Projects')

@section('content')
<div class="page-header">
    <h1> My Projects</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="margin-bottom: 25px;">
    <a href="{{ route('projects.create') }}" class="btn btn-primary"> Add New Project</a>
</div>

@if($projects->count() > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>📋 Title</th>
                    <th>📂 Category</th>
                    <th>🏁 Start Date</th>
                    <th>🏁 End Date</th>
                    <th> Status</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td><strong>{{ $project->title }}</strong></td>
                        <td>{{ $project->category }}</td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                        <td>
                            <span class="badge badge-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm" style="background: #3b82f6; color: white; text-decoration: none; display: inline-block;"> Edit</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
            <p style="color: #64748b; margin-bottom: 20px; font-size: 16px;">No projects added yet.</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary"> Create Your First Project</a>
        </div>
    </div>
@endif
@endsection
