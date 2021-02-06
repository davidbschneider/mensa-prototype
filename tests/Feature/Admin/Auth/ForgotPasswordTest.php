<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Notifications\Admin\Auth\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function passwordRequestRoute()
    {
        return route('admin.password.request');
    }

    protected function passwordResetGetRoute($token)
    {
        return route('admin.password.reset', $token);
    }

    protected function passwordEmailGetRoute()
    {
        return route('admin.password.email');
    }

    protected function passwordEmailPostRoute()
    {
        return route('admin.password.email');
    }

    public function testUserCanViewAnEmailPasswordForm()
    {
        $response = $this->get($this->passwordRequestRoute());

        $response->assertSuccessful();
        $response->assertViewIs('admin.auth.passwords.email');
    }

    public function testUserCanViewAnEmailPasswordFormWhenAuthenticated()
    {
        $user = Admin::factory()->make();

        $response = $this->be($user, 'admin')->get($this->passwordRequestRoute());

        $response->assertSuccessful();
        $response->assertViewIs('admin.auth.passwords.email');
    }

    public function testUserReceivesAnEmailWithAPasswordResetLink()
    {
        Notification::fake();
        $user = Admin::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->post($this->passwordEmailPostRoute(), [
            'email' => 'john@example.com',
        ]);
        $this->assertNotNull($token = DB::table(config('auth.passwords.admins.table'))->first());
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get($this->passwordResetGetRoute($notification->token));
            $response->assertStatus(200);
            return true;
        });
    }

    public function testUserDoesNotReceiveEmailWhenNotRegistered()
    {
        Notification::fake();

        $response = $this->from($this->passwordEmailGetRoute())->post($this->passwordEmailPostRoute(), [
            'email' => 'nobody@example.com',
        ]);

        $response->assertRedirect($this->passwordEmailGetRoute());
        $response->assertSessionHasErrors('email');
        Notification::assertNotSentTo(Admin::factory()->make(['email' => 'nobody@example.com']), ResetPassword::class);
    }

    public function testEmailIsRequired()
    {
        $response = $this->from($this->passwordEmailGetRoute())->post($this->passwordEmailPostRoute(), []);

        $response->assertRedirect($this->passwordEmailGetRoute());
        $response->assertSessionHasErrors('email');
    }
}
