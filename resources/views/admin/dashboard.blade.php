@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Total Instructors</div>
            <div class="text-xl font-bold">{{ number_format($total ?? 0) }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Approved</div>
            <div class="text-xl font-bold text-green-600">{{ number_format($approved ?? 0) }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Pending</div>
            <div class="text-xl font-bold text-yellow-600">{{ number_format($pending ?? 0) }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Disabled</div>
            <div class="text-xl font-bold text-red-600">{{ number_format($disabled ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Recent Instructors</h2>
            <a href="{{ route('admin.instructors.index') }}" class="text-sm text-blue-600">View all</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm text-gray-600">Name</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-600">Joined</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recent ?? [] as $inst)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $inst->user->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $inst->user->email ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($inst->is_disabled)
                                <span class="text-red-600">Disabled</span>
                            @elseif($inst->is_approved)
                                <span class="text-green-600">Approved</span>
                            @else
                                <span class="text-yellow-600">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $inst->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-3" colspan="4">No instructors yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection