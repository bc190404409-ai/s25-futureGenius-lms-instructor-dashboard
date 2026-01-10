@extends('admin.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

<div class="instructor-dashboard">
    <!-- Header with Back Button -->
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e5e7eb;">
        <a href="{{ route('admin.instructors.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #4f46e5; text-decoration: none; font-weight: 500; font-size: 14px;">
            ← Back to Instructors
        </a>
        <h1 style="margin: 0; font-size: 28px;"> Instructor Details</h1>
    </div>

    <!-- Instructor Basic Information -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
            <!-- Name -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Full Name</p>
                <p style="font-size: 20px; font-weight: bold; margin: 8px 0 0 0;">{{ $instructor->user->name ?? 'N/A' }}</p>
            </div>

            <!-- Email -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Email Address</p>
                <p style="font-size: 16px; margin: 8px 0 0 0; word-break: break-all;">{{ $instructor->user->email ?? 'N/A' }}</p>
            </div>

            <!-- Phone -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Phone</p>
                <p style="font-size: 16px; margin: 8px 0 0 0;">{{ $instructor->user->phone ?? 'N/A' }}</p>
            </div>

            <!-- Status -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Status</p>
                <div style="margin-top: 8px;">
                    @if($instructor->rejected_at)
                        <span class="status-badge rejected">❌ Rejected</span>
                    @elseif($instructor->is_disabled)
                        <span class="status-badge rejected">❌ Disabled</span>
                    @elseif($instructor->is_approved)
                        <span class="status-badge approved"> Approved</span>
                    @else
                        <span class="status-badge pending"> Pending</span>
                    @endif
                </div>
            </div>

            <!-- Experience -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Experience (Years)</p>
                <p style="font-size: 18px; font-weight: bold; margin: 8px 0 0 0;">{{ $instructor->experience_years ?? 0 }}</p>
            </div>

            <!-- City -->
            <div>
                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">City</p>
                <p style="font-size: 16px; margin: 8px 0 0 0;">{{ $instructor->city ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Timeline Information -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <!-- Joined Date -->
        <div style="background: #fff; border-left: 4px solid #3b82f6; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <p style="color: #666; font-size: 13px; margin: 0 0 8px 0;"> Joined Date</p>
            <p style="font-size: 16px; font-weight: 600; margin: 0;">{{ is_string($instructor->created_at) ? $instructor->created_at : $instructor->created_at->format('M d, Y') }}</p>
            <p style="color: #999; font-size: 12px; margin: 4px 0 0 0;">{{ is_string($instructor->created_at) ? '' : $instructor->created_at->diffForHumans() }}</p>
        </div>

        <!-- Approved Date -->
        @if($instructor->is_approved && $instructor->approved_at)
        <div style="background: #fff; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <p style="color: #666; font-size: 13px; margin: 0 0 8px 0;"> Approved Date</p>
            <p style="font-size: 16px; font-weight: 600; margin: 0;">{{ is_string($instructor->approved_at) ? $instructor->approved_at : $instructor->approved_at->format('M d, Y') }}</p>
            <p style="color: #999; font-size: 12px; margin: 4px 0 0 0;">{{ is_string($instructor->approved_at) ? '' : $instructor->approved_at->diffForHumans() }}</p>
        </div>
        @endif

        <!-- Rejected Date -->
        @if($instructor->rejected_at)
        <div style="background: #fff; border-left: 4px solid #ef4444; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <p style="color: #666; font-size: 13px; margin: 0 0 8px 0;">❌ Rejected Date</p>
            <p style="font-size: 16px; font-weight: 600; margin: 0;">{{ is_string($instructor->rejected_at) ? $instructor->rejected_at : $instructor->rejected_at->format('M d, Y') }}</p>
            <p style="color: #999; font-size: 12px; margin: 4px 0 0 0;">{{ is_string($instructor->rejected_at) ? '' : $instructor->rejected_at->diffForHumans() }}</p>

            @if($instructor->rejected_reason)
                <p style="color: #555; font-size: 14px; margin-top: 12px;"><strong>Reason:</strong> {{ \Illuminate\Support\Str::limit($instructor->rejected_reason, 200) }}</p>
            @endif
        </div>
        @endif

        <!-- Availability Mode -->
        <div style="background: #fff; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <p style="color: #666; font-size: 13px; margin: 0 0 8px 0;">🕐 Availability Mode</p>
            <p style="font-size: 16px; font-weight: 600; margin: 0;">{{ ucfirst($instructor->availability_mode ?? 'Not Set') }}</p>
        </div>
    </div>

    <!-- Skills Section -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px;">
        <h2 style="margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px;">
             Skills ({{ $instructor->skills->count() }})
        </h2>
        @if($instructor->skills->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                @foreach($instructor->skills as $skill)
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 8px;">
                    <p style="margin: 0; font-weight: 600; font-size: 14px;">{{ $skill->name ?? 'Unnamed Skill' }}</p>
                    <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.9;">Level: {{ ucfirst($skill->level ?? 'N/A') }}</p>
                </div>
                @endforeach
            </div>
        @else
            <p style="color: #999; font-style: italic;">No skills added yet.</p>
        @endif
    </div>

    <!-- Certifications Section -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px;">
        <h2 style="margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px;">
             Certifications ({{ $instructor->certifications->count() }})
        </h2>
        @if($instructor->certifications->count() > 0)
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Certificate Name</th>
                        <th>Issued By</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructor->certifications as $cert)
                    <tr>
                        <td><strong>{{ $cert->title ?? 'N/A' }}</strong></td>
                        <td>{{ $cert->issuer ?? 'N/A' }}</td>
                        <td>{{ $cert->issue_date ? (is_string($cert->issue_date) ? $cert->issue_date : $cert->issue_date->format('M d, Y')) : 'N/A' }}</td>
                        <td>
                            @if($cert->expiry_date)
                                {{ is_string($cert->expiry_date) ? $cert->expiry_date : $cert->expiry_date->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999; font-style: italic;">No certifications added yet.</p>
        @endif
    </div>

    <!-- Availabilities Section -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px;">
        <h2 style="margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px;">
             Availabilities ({{ $instructor->availabilities->count() }})
        </h2>
        @if($instructor->availabilities->count() > 0)
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructor->availabilities as $avail)
                    <tr>
                        <td>{{ ucfirst($avail->day_of_week ?? 'N/A') }}</td>
                        <td>{{ $avail->start_time ?? 'N/A' }}</td>
                        <td>{{ $avail->end_time ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999; font-style: italic;">No availabilities set yet.</p>
        @endif
    </div>

    <!-- Projects Section -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px;">
        <h2 style="margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px;">
             Project Engagements ({{ $instructor->projectEngagements->count() }})
        </h2>
        @if($instructor->projectEngagements->count() > 0)
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Role</th>
                        <th>Start Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructor->projectEngagements as $engagement)
                    <tr>
                        <td><strong>{{ $engagement->project->title ?? 'N/A' }}</strong></td>
                        <td>{{ $engagement->role ?? 'N/A' }}</td>
                        <td>{{ $engagement->start_date ? (is_string($engagement->start_date) ? $engagement->start_date : $engagement->start_date->format('M d, Y')) : 'N/A' }}</td>
                        <td>
                            <span class="status-badge {{ strtolower($engagement->status ?? 'pending') }}">
                                {{ ucfirst($engagement->status ?? 'Pending') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999; font-style: italic;">No project engagements yet.</p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px; border-top: 3px solid #4f46e5;">
        <h3 style="margin: 0 0 20px 0; font-size: 16px;"> Actions</h3>
        <div class="action-buttons" style="display: flex; flex-wrap: wrap; gap: 10px;">
            @if($instructor->is_disabled)
                <!-- Disabled: show Enable only -->
                <form method="POST" action="{{ route('admin.instructors.toggleDisable', $instructor) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-small" style="background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        Enable Instructor
                    </button>
                </form>
            @elseif($instructor->is_approved)
                <!-- Approved: show Disable -->
                <form method="POST" action="{{ route('admin.instructors.toggleDisable', $instructor) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-small" style="background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        Disable Instructor
                    </button>
                </form>
            @else
                <!-- Pending: Approve & Reject -->
                <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-small" style="background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                         Approve Instructor
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}" style="display: inline;" class="reject-form">
                    @csrf
                    <input type="hidden" name="reason" value="">
                    <button type="submit" class="btn-small" style="background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        ❌ Reject Instructor
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.instructors.index') }}" style="display: inline-block; background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500; text-decoration: none;">
                ← Back to List
            </a>
        </div>
    </div>
</div>

<style>
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .btn-small {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

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

@endsection
