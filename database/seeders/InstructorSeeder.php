<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::where('email', 'admin@example.com')->first();

        // Approved instructor
        $u1 = User::create([
            'name' => 'Approved Instructor',
            'email' => 'instructor1@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'email_verified_at' => now(),
        ]);
        Instructor::create([
            'user_id' => $u1->id,
            'experience_years' => 3,
            'availability_mode' => 'online',
            'city' => 'City A',
            'is_approved' => true,
            'approved_by' => $admin ? $admin->id : null,
            'approved_at' => now(),
        ]);

        // Pending instructor
        $u2 = User::create([
            'name' => 'Pending Instructor',
            'email' => 'instructor2@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);
        Instructor::create([
            'user_id' => $u2->id,
            'experience_years' => 1,
            'availability_mode' => 'in-person',
            'city' => 'City B',
            'is_approved' => false,
        ]);

        // Disabled instructor
        $u3 = User::create([
            'name' => 'Disabled Instructor',
            'email' => 'instructor3@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'email_verified_at' => now(),
        ]);
        Instructor::create([
            'user_id' => $u3->id,
            'experience_years' => 5,
            'availability_mode' => 'online',
            'city' => 'City C',
            'is_approved' => true,
            'approved_by' => $admin ? $admin->id : null,
            'approved_at' => now(),
        ]);
    }
}
