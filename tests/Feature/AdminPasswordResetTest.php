<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\Admin;

class AdminPasswordResetTest extends TestCase
{
    public function test_admin_can_request_password_reset_link()
    {
        Notification::fake();

        $admin = Admin::create(['name'=>'Admin','email'=>'adminpw@example.com','password'=>\Illuminate\Support\Facades\Hash::make('password')]);

        $this->get(route('admin.password.request'))->assertStatus(200)->assertSee('Send Password Reset Link');

        $response = $this->post(route('admin.password.email'), ['email' => $admin->email]);

        $response->assertStatus(302);
        $response->assertSessionHas('status');

        Notification::assertSentTo($admin, ResetPassword::class);
    }

    public function test_admin_can_reset_password_with_valid_token()
    {
        $admin = Admin::create(['name'=>'Admin2','email'=>'adminpw2@example.com','password'=>\Illuminate\Support\Facades\Hash::make('password')]);

        $token = Password::broker('admins')->createToken($admin);

        $response = $this->post(route('admin.password.update'), [
            'token' => $token,
            'email' => $admin->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('admin.login.form'));
        $this->assertTrue(\Hash::check('newpassword', $admin->fresh()->password));
    }
}
