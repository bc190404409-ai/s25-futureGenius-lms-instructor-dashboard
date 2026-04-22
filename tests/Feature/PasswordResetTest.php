<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;

class PasswordResetTest extends TestCase
{
    public function test_user_can_request_password_reset_link()
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'pwtest@example.com']);

        // ensure the request page is accessible
        $this->get(route('password.request'))->assertStatus(200)->assertSee('Send Password Reset Link');

        $response = $this->post(route('password.email'), ['email' => $user->email]);

        $response->assertStatus(302);
        $response->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_duplicate_reset_requests_within_cooldown_are_suppressed()
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'dup@example.com']);

        $this->post(route('password.email'), ['email' => $user->email])->assertStatus(302);

        // First call should send notification
        Notification::assertSentTo($user, ResetPassword::class);

        // Immediately post again; server should suppress and not send another notification
        $this->post(route('password.email'), ['email' => $user->email])->assertStatus(302);

        // Still only one notification should have been sent
        \Illuminate\Support\Facades\Notification::assertSentTimes(ResetPassword::class, 1);
    }

    public function test_user_can_reset_password_with_valid_token()
    {
        $user = User::factory()->create(['email' => 'pwreset@example.com']);

        $token = Password::broker()->createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('login.form'));
        $this->assertTrue(\Hash::check('newpassword', $user->fresh()->password));
    }
}
