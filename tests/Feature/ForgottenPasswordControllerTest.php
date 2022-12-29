<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgottenPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get(route('forgotten-password.create'));

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('forgotten-password.store'), ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetNotification::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();


        $user = User::factory()->create();

        $this->post(route('forgotten-password.store'), ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetNotification::class, function ($notification) {
            $response = $this->get(route('forgotten-password.edit', ['token' => $notification->token]));

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('forgotten-password.store'), ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetNotification::class, function ($notification) use ($user) {
            $response = $this->put(route('forgotten-password.update', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]));

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
