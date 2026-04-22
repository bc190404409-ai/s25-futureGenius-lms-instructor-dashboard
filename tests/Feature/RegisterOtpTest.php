<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorOtp;
use App\Models\User;
use App\Models\EmailOtp;

class RegisterOtpTest extends TestCase
{
    public function test_register_creates_user_and_sends_otp()
    {
        Mail::fake();

        $post = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post(route('register'), $post)
            ->assertStatus(200)
            ->assertSee('Verify your email');

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertNotNull($user, 'User was not created');

        $otp = EmailOtp::where('user_id', $user->id)->first();
        $this->assertNotNull($otp, 'Email OTP was not created');

        Mail::assertQueued(InstructorOtp::class, function ($mail) use ($user, $otp) {
            return $mail->hasTo($user->email) && $mail->otp->id === $otp->id;
        });
    }
}
