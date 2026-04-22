<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Skill;
use App\Models\Certification;

class InstructorDashboardSearchTest extends TestCase
{
    public function test_instructor_dashboard_search_filters_recent_items()
    {
        $user = User::factory()->create(['role' => 'instructor']);
        // ensure an Instructor record exists for this user
        $instructor = \App\Models\Instructor::firstOrCreate(['user_id' => $user->id], ['is_approved' => true]);
        $this->actingAs($user);

        Skill::create(['instructor_id' => $instructor->id, 'user_id' => $user->id, 'skill_name' => 'Javascript', 'skill_type' => 'technical', 'status' => 'approved']);
        Skill::create(['instructor_id' => $instructor->id, 'user_id' => $user->id, 'skill_name' => 'PHP', 'skill_type' => 'technical', 'status' => 'pending']);

        Certification::create(['instructor_id' => $instructor->id, 'user_id' => $user->id, 'title' => 'AWS Certified', 'issuer' => 'AWS', 'file_path' => '/tmp/aws.pdf', 'issue_date' => now()->toDateString()]);
        Certification::create(['instructor_id' => $instructor->id, 'user_id' => $user->id, 'title' => 'Laravel Certification', 'issuer' => 'Laracasts', 'file_path' => '/tmp/laravel.pdf', 'issue_date' => now()->toDateString()]);

        $this->get(route('dashboard', ['q' => 'PHP']))->assertSee('PHP')->assertDontSee('Javascript');
        $this->get(route('dashboard', ['q' => 'Laravel']))->assertSee('Laravel Certification')->assertDontSee('AWS Certified');

        // make sure empty search shows multiple items
        $this->get(route('dashboard'))->assertSee('Javascript')->assertSee('AWS Certified');
    }
}
