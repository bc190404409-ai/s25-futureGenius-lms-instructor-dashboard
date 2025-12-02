@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Skills Approval</h1>

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

    <div class="bg-white shadow-md rounded-xl p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skill</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($skills as $skill)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $skill->instructor->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $skill->skill_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($skill->skill_type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $skill->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($skill->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($skill->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        @if($skill->status == 'pending')
                        <form class="inline" method="POST" action="{{ route('admin.approve', ['type'=>'skill','id'=>$skill->id]) }}">
                            @csrf
                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                        <form class="inline" method="POST" action="{{ route('admin.reject', ['type'=>'skill','id'=>$skill->id]) }}">
                            @csrf
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                        </form>
                        @else
                        <span class="text-gray-500">No actions</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
