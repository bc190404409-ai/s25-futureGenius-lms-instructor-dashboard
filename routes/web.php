<?php

use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssessmentSubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InstructorNotificationController;
use App\Http\Controllers\InstructorProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard and basic auth
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Instructor notifications
    Route::get('instructor/notifications/read/{id}', [InstructorNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('instructor/notifications/read-all', [InstructorNotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Instructor profile
    Route::get('/instructor/profile', [InstructorProfileController::class, 'show'])->name('instructor.profile');
    Route::get('/instructor/profile/edit', [InstructorProfileController::class, 'edit'])->name('instructor.profile.edit');
    Route::post('/instructor/profile/update', [InstructorProfileController::class, 'update'])->name('instructor.profile.update');

    // Skills
    Route::resource('skills', SkillController::class)->except(['show']);

    // Certifications
    Route::resource('certifications', CertificationController::class)->except(['show']);

    // Projects
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Enrollments
    Route::get('/courses', [EnrollmentController::class, 'index'])->name('courses.list');
    Route::post('/enroll/{courseId}', [EnrollmentController::class, 'enroll'])->name('course.enroll');
    Route::get('/student/my-courses', [EnrollmentController::class, 'myCourses'])->name('student.myCourses');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::get('/skills/{skill}/edit', [SkillController::class, 'edit'])->name('skills.edit');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

    Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');
    Route::get('/certifications/create', [CertificationController::class, 'create'])->name('certifications.create');
    Route::post('/certifications', [CertificationController::class, 'store'])->name('certifications.store');
    Route::get('/certifications/{certification}/edit', [CertificationController::class, 'edit'])->name('certifications.edit');
    Route::put('/certifications/{certification}', [CertificationController::class, 'update'])->name('certifications.update');
    Route::delete('/certifications/{certification}', [CertificationController::class, 'destroy'])->name('certifications.destroy');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
    Route::get('/availabilities/create', [AvailabilityController::class, 'create'])->name('availabilities.create');
    Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::get('/availabilities/{availability}/edit', [AvailabilityController::class, 'edit'])->name('availabilities.edit');
    Route::put('/availabilities/{availability}', [AvailabilityController::class, 'update'])->name('availabilities.update');
    Route::delete('/availabilities/{availability}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');

    Route::get('/instructor/profile', [InstructorProfileController::class, 'show'])->name('instructor.profile');
    Route::get('/instructor/profile/edit', [InstructorProfileController::class, 'edit'])->name('instructor.profile.edit');
    Route::post('/instructor/profile/update', [InstructorProfileController::class, 'update'])->name('instructor.profile.update');

    Route::prefix('instructor/assessments')->group(function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('instructor.assessments.index');
        Route::get('/create', [AssessmentController::class, 'selectType'])->name('instructor.assessments.create');
        Route::get('/create/{type}', [AssessmentController::class, 'createForm'])->name('instructor.assessments.createForm');
        Route::post('/store', [AssessmentController::class, 'store'])->name('instructor.assessments.store');

        Route::get('/{assessment}/edit', [AssessmentController::class, 'edit'])->name('instructor.assessments.edit');

        Route::put('/{assessment}', [AssessmentController::class, 'update'])->name('instructor.assessments.update');

        Route::delete('/{assessment}', [AssessmentController::class, 'destroy'])->name('instructor.assessments.destroy');

        Route::get('/submissions', [AssessmentSubmissionController::class, 'index'])->name('instructor.assessments.submissions.index');

        Route::get('/submissions/{submission}', [AssessmentSubmissionController::class, 'show'])->name('instructor.assessments.submissions.show');
    });


    Route::prefix('instructor')->name('instructor.')->group(function () {
        Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    });
});
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('admin/skills/approve/{skill}', [AdminApprovalController::class, 'approveSkill'])->name('admin.skills.approve');
    Route::get('admin/skills/reject/{skill}', [AdminApprovalController::class, 'rejectSkill'])->name('admin.skills.reject');

    Route::get('admin/certifications/approve/{cert}', [AdminApprovalController::class, 'approveCertification'])->name('admin.certifications.approve');
    Route::get('admin/certifications/reject/{cert}', [AdminApprovalController::class, 'rejectCertification'])->name('admin.certifications.reject');

    Route::get('admin/projects/approve/{project}', [AdminApprovalController::class, 'approveProject'])->name('admin.projects.approve');
    Route::get('admin/projects/reject/{project}', [AdminApprovalController::class, 'rejectProject'])->name('admin.projects.reject');
});

// Socialite routes for instructor registration/login
Route::get('auth/redirect/{provider}', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('auth/callback/{provider}', [App\Http\Controllers\Auth\SocialAuthController::class, 'callback'])->name('social.callback');

// OTP verification routes
Route::get('verify-otp', function(){ return redirect('/'); })->name('verify.otp.form'); // placeholder if accessed directly
Route::post('verify-otp', [App\Http\Controllers\Auth\OtpController::class, 'verify'])->name('verify.otp');
// Resend OTP (throttled) — limit to 5 per minute globally and per-user cooldown enforced in controller
Route::post('resend-otp', [App\Http\Controllers\Auth\OtpController::class, 'resend'])->name('resend.otp')->middleware('throttle:5,1');

// Admin auth and dashboard
Route::get('admin/login', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/instructors', [App\Http\Controllers\AdminAuthController::class, 'instructors'])->name('admin.instructors.index');
    Route::post('/instructors/{instructor}/approve', [App\Http\Controllers\AdminAuthController::class, 'approveInstructor'])->name('admin.instructors.approve');
    Route::post('/instructors/{instructor}/reject', [App\Http\Controllers\AdminAuthController::class, 'rejectInstructor'])->name('admin.instructors.reject');
    Route::post('/instructors/{instructor}/toggle-disable', [App\Http\Controllers\AdminAuthController::class, 'toggleDisableInstructor'])->name('admin.instructors.toggleDisable');
});
