<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_index_page_is_displayed()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('transactions.index'));

        $response->assertStatus(200);
    }

    public function test_transaction_create_page_is_displayed()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('transactions.create'));

        $response->assertStatus(200);
    }

    public function test_earning_transactions_can_be_stored()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('transactions.store'), [
            'description' => 'Test transaction',
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 100,
            'type' => 'earning',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('transactions', [
            'description' => 'Test transaction',
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 100,
            'user_id' => $user->id,
        ]);
    }

    public function test_spending_transactions_can_be_stored()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('transactions.store'), [
            'description' => 'Test transaction',
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 100,
            'type' => 'spending',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('transactions', [
            'description' => 'Test transaction',
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => -100,
            'user_id' => $user->id,
        ]);
    }

}
