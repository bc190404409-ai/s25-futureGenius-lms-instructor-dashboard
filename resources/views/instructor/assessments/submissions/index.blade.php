@extends('layouts.app')

@section('title', 'Assessment Submissions')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-6">Assessment Submissions</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded mb-4">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Assessment</th>
                    <th class="py-3 px-6 text-left">Student</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Submitted At</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($submissions as $index => $submission)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-left">{{ $submission->assessment->title ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $submission->student->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ ucfirst($submission->status) }}</td>
                    <td class="py-3 px-6 text-left">{{ $submission->submitted_at->format('Y-m-d H:i') }}</td>
                    <td class="py-3 px-6 text-center space-x-2">
                        <a href="{{ route('instructor.assessments.submissions.show', $submission->id) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">
                           View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No submissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
