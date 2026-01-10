@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Skills Approval</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left text-sm">Instructor</th>
                    <th class="px-4 py-2 text-left text-sm">Skill</th>
                    <th class="px-4 py-2 text-left text-sm">Type</th>
                    <th class="px-4 py-2 text-left text-sm">Status</th>
                    <th class="px-4 py-2 text-center text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skills as $skill)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $skill->instructor->name }}</td>
                    <td class="px-4 py-2">{{ $skill->skill_name }}</td>
                    <td class="px-4 py-2">{{ ucfirst($skill->skill_type) }}</td>
                    <td class="px-4 py-2 text-sm">{{ ucfirst($skill->status) }}</td>
                    <td class="px-4 py-2 text-center">
                        @if($skill->status === 'pending')
                            <form class="inline" method="POST" action="{{ route('admin.approve', ['type'=>'skill','id'=>$skill->id]) }}">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline text-sm">Approve</button>
                            </form>
                            <form class="inline" method="POST" action="{{ route('admin.reject', ['type'=>'skill','id'=>$skill->id]) }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline text-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-gray-500 text-sm">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
