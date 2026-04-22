@extends('admin.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

<div class="instructor-dashboard">
    <div class="instructor-header">
        <h1>👨‍🏫 Manage Instructors</h1>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:16px;">
        <!-- Filter Tabs -->
        <div class="tabs-container" style="flex:1;">
            <a href="{{ route('admin.instructors.index', ['status' => null]) }}" 
               class="tab-button @if(request('status') === null || request('status') === 'all') active @endif">
                 All ({{ $total ?? 0 }})
            </a>
            <a href="{{ route('admin.instructors.index', ['status' => 'pending']) }}" 
               class="tab-button @if(request('status') === 'pending') active @endif">
                 Pending ({{ $pending ?? 0 }})
            </a>
            <a href="{{ route('admin.instructors.index', ['status' => 'approved']) }}" 
               class="tab-button @if(request('status') === 'approved') active @endif">
                 Approved ({{ $approved ?? 0 }})
            </a>
            <a href="{{ route('admin.instructors.index', ['status' => 'disabled']) }}" 
               class="tab-button @if(request('status') === 'disabled') active @endif">
                ❌ Disabled ({{ $disabled ?? 0 }})
            </a>
        </div>

        <!-- Search Form -->
        <div style="flex:0 0 320px;">
            <form method="GET" action="{{ route('admin.instructors.index') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div style="display:flex; gap:8px;">
                    <input name="q" value="{{ old('q', $q ?? request('q')) }}" placeholder="Search name or email" style="flex:1; padding:8px; border-radius:6px; border:1px solid #d1d5db;" />
                    <button type="submit" class="btn-small" style="padding:8px 12px;">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Instructors Table -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        @if($instructors->count() > 0)
            <table class="content-table">
                <thead>
                    <tr>
                        <th> Name</th>
                        <th>📧 Email</th>
                        <th> Status</th>
                        <th>🕐 Joined</th>
                        <th> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                    <tr>
                        <td>
                            <a href="{{ route('admin.instructors.show', $instructor) }}" style="color: #4f46e5; text-decoration: none; font-weight: 500;">
                                 {{ $instructor->user->name ?? '—' }}
                            </a>
                        </td>
                        <td>{{ $instructor->user->email ?? '—' }}</td>
                        <td>
                            @if($instructor->rejected_at)
                                <span class="status-badge rejected">❌ Rejected</span>
                            @elseif($instructor->is_disabled)
                                <span class="status-badge rejected">❌ Disabled</span>
                            @elseif($instructor->is_approved)
                                <span class="status-badge approved"> Approved</span>
                            @else
                                <span class="status-badge pending"> Pending</span>
                            @endif
                        </td>
                        <td style="color: #999; font-size: 13px;">{{ $instructor->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="action-buttons">
                                @if($instructor->is_disabled)
                                    <!-- Disabled: show only Enable -->
                                    <form method="POST" action="{{ route('admin.instructors.toggleDisable', $instructor) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-small" style="background: #10b981; color: white;">Enable</button>
                                    </form>
                                @elseif($instructor->is_approved)
                                    <!-- Approved (not disabled): show Disable -->
                                    <form method="POST" action="{{ route('admin.instructors.toggleDisable', $instructor) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-small" style="background: #6b7280; color: white;">Disable</button>
                                    </form>
                                @else
                                    <!-- Pending: show Approve & Reject only -->
                                    <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-small" style="background: #16a34a; color: white;">Approve</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}" style="display: inline;" class="reject-form">
                                        @csrf
                                        <input type="hidden" name="reason" value="">
                                        <button type="submit" class="btn-small" style="background: #ef4444; color: white;">Reject</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="padding: 20px; text-align: center;">
                {{ $instructors->links() }}
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.reject-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            var reason = prompt('Optional: add a short reason for rejection (leave blank to skip):');
                            if (reason === null) {
                                // user cancelled
                                e.preventDefault();
                                return;
                            }
                            var input = form.querySelector('input[name="reason"]');
                            if (input) input.value = reason;
                        });
                    });
                });
            </script>
        @else
            <div class="empty-section">
                <p>No instructors found in this category.</p>
                <a href="{{ route('admin.instructors.index') }}">View All Instructors</a>
            </div>
        @endif
    </div>
</div>
@endsection