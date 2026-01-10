@extends('layouts.app')

@section('title', 'My Availabilities')
@section('page_title', 'My Availabilities')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e2e8f0;">
    <div class="page-header" style="margin: 0; padding: 0; border: none;">
        <h1>🕒 My Availabilities</h1>
    </div>
    <a href="{{ route('availabilities.create') }}" class="btn btn-primary"> Add Availability</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($availabilities->count() > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>🔄 Mode</th>
                    <th>📍 City</th>
                    <th> Days</th>
                    <th> Time Slots</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availabilities as $availability)
                    <tr>
                        <td>
                            <span class="badge badge-primary" style="text-transform: capitalize;">
                                {{ $availability->mode }}
                            </span>
                        </td>
                        <td>{{ $availability->city ?? '—' }}</td>
                        <td>{{ implode(', ', json_decode($availability->days)) }}</td>
                        <td>{{ implode(', ', json_decode($availability->time_slots)) }}</td>
                        <td>
                            <a href="{{ route('availabilities.edit', $availability) }}" class="btn btn-sm" style="background: #f59e0b; color: white; text-decoration: none; display: inline-block;"> Edit</a>
                            <form action="{{ route('availabilities.destroy', $availability) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
            <p style="font-size: 48px; margin-bottom: 15px;">🕒</p>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 16px;">No availabilities added yet.</p>
            <a href="{{ route('availabilities.create') }}" class="btn btn-primary"> Add Your First Availability</a>
        </div>
    </div>
@endif
@endsection
