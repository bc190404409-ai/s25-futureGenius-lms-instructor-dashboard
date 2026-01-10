@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

<div class="instructor-dashboard">
    <div class="instructor-header">
        <h1>📊 Instructor Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card skills">
            <h2>Skills</h2>
            <p>{{ $stats['skills'] }}</p>
        </div>
        <div class="stat-card certifications">
            <h2>Certifications</h2>
            <p>{{ $stats['certifications'] }}</p>
        </div>
        <div class="stat-card projects">
            <h2>Projects</h2>
            <p>{{ $stats['projects'] }}</p>
        </div>
        <div class="stat-card availability">
            <h2>Availability Slots</h2>
            <p>{{ $stats['availabilities'] }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <!-- Recent Skills -->
        <div class="activity-section">
            <h3>📚 Recent Skills</h3>
            <ul class="activity-list">
                @forelse($recentSkills as $skill)
                    <li class="activity-item">
                        <span>{{ $skill->skill_name }}</span>
                        <span class="status-badge @if($skill->status === 'approved') approved @elseif($skill->status === 'pending') pending @else rejected @endif">
                            {{ ucfirst($skill->status) }}
                        </span>
                    </li>
                @empty
                    <p class="empty-state">No recent skills found.</p>
                @endforelse
            </ul>
        </div>

        <!-- Recent Certifications -->
        <div class="activity-section">
            <h3>🎓 Recent Certifications</h3>
            <ul class="activity-list">
                @forelse($recentCerts as $cert)
                    <li class="activity-item">
                        <span>{{ $cert->title }}</span>
                        <span class="status-badge @if($cert->status === 'approved') approved @elseif($cert->status === 'pending') pending @else rejected @endif">
                            {{ ucfirst($cert->status) }}
                        </span>
                    </li>
                @empty
                    <p class="empty-state">No recent certifications found.</p>
                @endforelse
            </ul>
        </div>

        <!-- Recent Projects -->
        <div class="activity-section">
            <h3>🚀 Recent Projects</h3>
            <ul class="activity-list">
                @forelse($recentProjects as $proj)
                    <li class="activity-item">
                        <span>{{ $proj->project_title }}</span>
                        <span class="status-badge @if($proj->status === 'completed') completed @elseif($proj->status === 'in_progress') in_progress @else pending @endif">
                            {{ ucfirst(str_replace('_', ' ', $proj->status)) }}
                        </span>
                    </li>
                @empty
                    <p class="empty-state">No recent projects found.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Deactivate all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            this.classList.add('active');
        });
    });
</script>
@endsection
