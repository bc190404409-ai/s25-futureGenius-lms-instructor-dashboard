<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Certification;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    // Suggestions for admin pages: instructors and certifications
    public function suggestAdmin(Request $request)
    {
        $q = trim($request->query('q', ''));
        $results = [];

        if ($q === '') {
            return response()->json($results);
        }

        // Instructors by name or email
        $instructors = Instructor::with('user')
            ->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            })->take(5)->get();

        foreach ($instructors as $inst) {
            $results[] = [
                'type' => 'instructor',
                'label' => ($inst->user->name ?? '—') . ' (' . ($inst->user->email ?? '') . ')',
                'url' => route('admin.instructors.show', $inst->id),
                'avatar' => $inst->user->profile_photo ? asset('storage/' . $inst->user->profile_photo) : null,
            ];
        }

        // Certifications by title or issuer
        $certs = Certification::with('instructor.user')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('issuer', 'like', "%{$q}%")
            ->take(6 - count($results))
            ->get();

        foreach ($certs as $c) {
            $results[] = [
                'type' => 'certification',
                'label' => $c->title . ' — ' . ($c->issuer ?? ''),
                'url' => route('admin.approvals.certifications.show', $c->id),
            ];
        }

        return response()->json($results);
    }

    // Suggestions for instructor pages: courses
    public function suggestInstructor(Request $request)
    {
        $q = trim($request->query('q', ''));
        $results = [];

        if ($q === '') {
            return response()->json($results);
        }

        $userId = Auth::id();
        $courses = Course::where('instructor_id', $userId)
            ->where(function($s) use ($q) {
                $s->where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%");
            })->take(8)->get();

        foreach ($courses as $c) {
            $results[] = [
                'type' => 'course',
                'label' => $c->title,
                'url' => route('projects.show', $c->id) ?? url('/'),
            ];
        }

        return response()->json($results);
    }
}
