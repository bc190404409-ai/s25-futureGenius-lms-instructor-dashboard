<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

class AdminInstructorSearchTest extends TestCase
{
    public function test_admin_can_search_instructors_by_name_or_email()
    {
        // create an admin
        $admin = \App\Models\Admin::create(['name'=>'A','email'=>'admin2@example.com','password'=>Hash::make('password')]);

        // create users
        $u1 = User::factory()->create(['name' => 'Alice Wonderland', 'email' => 'alice@example.com']);
        $u2 = User::factory()->create(['name' => 'Bob Builder', 'email' => 'bob@example.com']);

        $i1 = Instructor::create(['user_id' => $u1->id, 'is_approved' => false, 'is_disabled' => false]);
        $i2 = Instructor::create(['user_id' => $u2->id, 'is_approved' => true, 'is_disabled' => false]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.instructors.index', ['q' => 'Alice']))
            ->assertSee('Alice Wonderland')
            ->assertDontSee('Bob Builder');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.instructors.index', ['q' => 'bob@example.com']))
            ->assertSee('Bob Builder')
            ->assertDontSee('Alice Wonderland');
    }
}
