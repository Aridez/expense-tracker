<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_create_page_is_displayed()
    {
        $response = $this->get(route('accounts.create'));

        $response->assertStatus(200);
    }

    public function test_account_can_be_stored()
    {
        $response = $this->post(route('accounts.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_account_edit_page_is_displayed()
    {
        /** @var User */
        $user = User::factory()->createOne();

        $response = $this
            ->actingAs($user)
            ->get(route('accounts.edit'));

        $response->assertOk();
    }

    public function test_account_information_can_be_updated()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('accounts.update'), [
                'name' => 'Test User',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.edit'));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
    }

}
