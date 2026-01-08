@extends('admin.layout')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Instructors</h1>
        <div class="text-sm text-gray-500">Total: {{ $instructors->total() }}</div>
    </div>

    <div class="mb-4">
        <nav class="flex space-x-2">
            @php $tabs = ['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'disabled' => 'Disabled']; @endphp
            @foreach($tabs as $key => $label)
                <a href="{{ route('admin.instructors.index', ['status' => $key === 'all' ? null : $key]) }}" class="px-3 py-1 rounded {{ ($status === $key || ($status === 'all' && $key === 'all')) ? 'bg-gray-200' : 'hover:bg-gray-100' }}">{{ $label }}</a>
            @endforeach
        </nav>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full" role="table" aria-label="Instructors list">
            <caption class="sr-only">List of instructors</caption>
            <thead>
                <tr class="text-left text-sm text-gray-600">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instructors as $instructor)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $instructor->user->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $instructor->user->email ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($instructor->is_disabled)
                                <span class="text-red-600">Disabled</span>
                            @elseif($instructor->is_approved)
                                <span class="text-green-600">Approved</span>
                            @else
                                <span class="text-yellow-600">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $instructor->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if(!$instructor->is_approved)
                                    <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}" onsubmit="return confirm('Approve this instructor?');">
                                        @csrf
                                        <button type="submit" aria-label="Approve {{ $instructor->user->name ?? 'instructor' }}" class="px-2 py-1 bg-green-600 text-white rounded text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500">Approve</button>
                                    </form>
                                @endif

                                @if(!$instructor->is_disabled)
                                    <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}" onsubmit="return confirm('Reject this instructor?');">
                                        @csrf
                                        <button type="submit" aria-label="Reject {{ $instructor->user->name ?? 'instructor' }}" class="px-2 py-1 bg-red-600 text-white rounded text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500">Reject</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.instructors.toggleDisable', $instructor) }}" onsubmit="return confirm('Toggle enable/disable for this instructor?');">
                                    @csrf
                                    <button type="submit" aria-label="{{ $instructor->is_disabled ? 'Enable' : 'Disable' }} {{ $instructor->user->name ?? 'instructor' }}" class="px-2 py-1 bg-gray-600 text-white rounded text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-500">{{ $instructor->is_disabled ? 'Enable' : 'Disable' }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-3" colspan="5">No instructors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $instructors->links() }}</div>
@endsection