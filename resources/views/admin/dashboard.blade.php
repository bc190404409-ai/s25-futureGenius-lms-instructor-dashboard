@extends('admin.layout')

@section('content')
    <h1 style="font-size: 24px; margin-bottom: 20px;">Dashboard Overview</h1>

    <div class="cards">
        <div class="card">
            <h4>Total Instructors</h4>
            <p>{{ number_format($total ?? 0) }}</p>
        </div>
        <div class="card">
            <h4>Approved</h4>
            <p style="color: #16a34a;">{{ number_format($approved ?? 0) }}</p>
        </div>
        <div class="card">
            <h4>Pending</h4>
            <p style="color: #ca8a04;">{{ number_format($pending ?? 0) }}</p>
        </div>
        <div class="card">
            <h4>Certifications</h4>
            <p style="color: #2563eb;">{{ number_format($certCount ?? 0) }}</p>
        </div>
    </div>

    <div class="table-box" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 600;">Recent Certifications</h2>
            <a href="{{ route('certifications.index') }}" style="color: #4f46e5; font-size: 14px; text-decoration: none;">View all →</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Instructor</th>
                    <th>Title</th>
                    <th>Issuer</th>
                    <th>Issued</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentCerts ?? [] as $cert)
                <tr>
                    <td>{{ $cert->instructor->user->name ?? '—' }}</td>
                    <td>{{ $cert->title }}</td>
                    <td>{{ $cert->issuer }}</td>
                    <td style="color: #666; font-size: 14px;">{{ optional($cert->issue_date)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #999;">No certifications yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection