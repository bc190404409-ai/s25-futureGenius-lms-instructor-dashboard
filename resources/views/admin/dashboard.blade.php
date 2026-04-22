@extends('admin.layout')

@section('content')
    <h1 style="font-size: 24px; margin-bottom: 20px;">Dashboard Overview</h1>

    <div class="cards grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Total Instructors</h4>
            <p class="text-2xl font-semibold mt-2">{{ number_format($total ?? 0) }}</p>
        </div>
        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Approved Instructors</h4>
            <p class="text-2xl font-semibold text-green-600 mt-2">{{ number_format($approved ?? 0) }}</p>
        </div>
        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Pending Instructors</h4>
            <p class="text-2xl font-semibold text-yellow-600 mt-2">{{ number_format($pending ?? 0) }}</p>
        </div>
        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Certifications</h4>
            <p class="text-2xl font-semibold text-blue-600 mt-2">{{ number_format($certCount ?? 0) }}</p>
        </div>

        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Certs Pending</h4>
            <p class="text-2xl font-semibold text-yellow-600 mt-2">{{ number_format($certPending ?? 0) }}</p>
        </div>
        <div class="card p-4 bg-white rounded shadow">
            <h4 class="text-sm text-gray-600">Certs Approved</h4>
            <p class="text-2xl font-semibold text-green-600 mt-2">{{ number_format($certApproved ?? 0) }}</p>
        </div>
    </div>

    <div class="table-box mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Recent Certifications</h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.approvals.certifications') }}" class="text-sm text-indigo-600 hover:underline">Manage approvals →</a>
                <a href="{{ route('admin.approvals.certifications') }}" class="text-sm text-indigo-600 hover:underline">View all →</a>
            </div>
        </div>

        <div class="overflow-auto bg-white shadow rounded">
            <table class="min-w-full">
                <thead class="bg-gray-50 text-left text-xs text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2">Instructor</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Issuer</th>
                        <th class="px-4 py-2">Issued</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recentCerts ?? [] as $cert)
                    <tr class="border-b last:border-b-0">
                        <td class="px-4 py-3"><a href="{{ route('admin.instructors.show', $cert->instructor) }}" class="text-indigo-600 hover:underline">{{ $cert->instructor->user->name ?? '—' }}</a></td>
                        <td class="px-4 py-3"><a href="{{ route('admin.approvals.certifications.show', $cert) }}" class="text-indigo-600 hover:underline">{{ $cert->title }}</a></td>
                        <td class="px-4 py-3">{{ $cert->issuer }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ optional($cert->issue_date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cert->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($cert->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($cert->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($cert->status == 'pending')
                                <form method="POST" action="{{ route('admin.approvals.certifications.approve', $cert) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm">Approve</button>
                                </form>
                                <a href="{{ route('admin.approvals.certifications.show', $cert) }}" class="bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm ml-2">Review</a>
                            @else
                                <span class="text-sm text-gray-500">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-6 text-gray-400">No certifications yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection