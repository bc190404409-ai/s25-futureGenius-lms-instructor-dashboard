@extends('layouts.app')

@section('title', 'My Certifications')
@section('page_title', 'My Certifications')

@section('content')
<div class="page-header">
    <h1> My Certifications</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="margin-bottom: 25px;">
    <a href="{{ route('certifications.create') }}" class="btn btn-primary"> Add New Certification</a>
</div>

@if($certifications->count() > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th> Title</th>
                    <th> Issuer</th>
                    <th> Issue Date</th>
                    <th> Expiry Date</th>
                    <th> Status</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certifications as $cert)
                    <tr>
                        <td><strong>{{ $cert->title }}</strong></td>
                        <td>{{ $cert->issuer }}</td>
                        <td>{{ $cert->issue_date }}</td>
                        <td>{{ $cert->expiry_date ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $cert->status == 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($cert->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('certifications.edit', $cert) }}" class="btn btn-sm" style="background: #3b82f6; color: white; text-decoration: none; display: inline-block;"> Edit</a>
                            <form action="{{ route('certifications.destroy', $cert) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
            <p style="color: #64748b; margin-bottom: 20px; font-size: 16px;">No certifications added yet.</p>
            <a href="{{ route('certifications.create') }}" class="btn btn-primary"> Add Your First Certification</a>
        </div>
    </div>
@endif
@endsection
