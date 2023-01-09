<?php

namespace Tests\Unit\Filters;

use App\Models\Periodicity;
use App\Models\UpcomingTransaction;
use App\Models\User;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{

    use RefreshDatabase;

    public function test_past_transactions_are_correctly_created()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        Carbon::setTestNow($date);
        /** @var TransactionService */
        $transactionService = $this->app->make(TransactionService::class);
        $user = User::factory()->create();
        $transaction_date = Carbon::createFromDate(2020, 9, 1);

        // Act
        $transactionService->addTransaction($transaction_date, 'Past transaction', 100, Periodicity::find(Periodicity::NONE), null, $user);

        // Assert
        $this->assertDatabaseHas('transactions', [
            'date' => $transaction_date->format('Y-m-d'),
            'description' => 'Past transaction',
            'amount' => 100,
            'user_id' => $user->id
        ]);
    }

    public function test_periodic_past_transactions_are_correctly_scheduled()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 12, 20);
        Carbon::setTestNow($date);
        /** @var TransactionService */
        $transactionService = $this->app->make(TransactionService::class);
        $user = User::factory()->create();
        $transaction_date = Carbon::createFromDate(2020, 12, 12);
        $upcoming_date = Carbon::createFromDate(2021, 1, 12);
        $repeat_until = Carbon::createFromDate(2022, 1, 1);

        // Act
        $transactionService->addTransaction($transaction_date, 'Recurring transaction', 100, Periodicity::find(Periodicity::MONTHLY), $repeat_until, $user);

        // Assert
        $this->assertDatabaseHas('transactions', [
            'date' => $transaction_date->format('Y-m-d'),
            'description' => 'Recurring transaction',
            'amount' => 100,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('upcoming_transactions', [
            'date' => $upcoming_date->format('Y-m-d'),
            'description' => 'Recurring transaction',
            'amount' => 100,
            'user_id' => $user->id,
            'periodicity_id' => Periodicity::MONTHLY,
            'repeat_until' => $repeat_until->format('Y-m-d')
        ]);
    }

    public function test_future_transactions_are_correctly_scheduled()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 11, 1);
        Carbon::setTestNow($date);
        /** @var TransactionService */
        $transactionService = $this->app->make(TransactionService::class);
        $user = User::factory()->create();
        $transaction_date = Carbon::createFromDate(2020, 12, 12);
        $repeat_until = Carbon::createFromDate(2022, 1, 1);

        // Act
        $transactionService->addTransaction($transaction_date, 'Future transaction', 100, Periodicity::find(Periodicity::MONTHLY), $repeat_until, $user);

        // Assert
        $this->assertDatabaseEmpty('transactions');
        $this->assertDatabaseHas('upcoming_transactions', [
            'date' => $transaction_date->format('Y-m-d'),
            'description' => 'Future transaction',
            'amount' => 100,
            'user_id' => $user->id,
            'periodicity_id' => Periodicity::MONTHLY,
            'repeat_until' => $repeat_until->format('Y-m-d')
        ]);
    }

    public function test_periodic_past_transactions_are_correctly_limited_by_repeat_until()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 12, 20);
        Carbon::setTestNow($date);
        /** @var TransactionService */
        $transactionService = $this->app->make(TransactionService::class);
        $user = User::factory()->create();
        $transaction_date = Carbon::createFromDate(2020, 12, 12);
        $upcoming_date = Carbon::createFromDate(2021, 1, 12);
        $repeat_until = Carbon::createFromDate(2021, 1, 10);

        // Act
        $transactionService->addTransaction($transaction_date, 'Recurring transaction', 100, Periodicity::find(Periodicity::MONTHLY), $repeat_until, $user);

        // Assert
        $this->assertDatabaseHas('transactions', [
            'date' => $transaction_date->format('Y-m-d'),
            'description' => 'Recurring transaction',
            'amount' => 100,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseEmpty('upcoming_transactions');
    }
    public function test_upcoming_transactions_are_correctly_rescheduled()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        $expected_date = Carbon::createFromDate(2020, 11, 1);
        Carbon::setTestNow($date->copy()->addDay());
        $transactionService = $this->app->make(TransactionService::class);
        $upcomingTransaction = UpcomingTransaction::factory()->create([
            'date' => $date,
            'original_date' => $date,
            'periodicity_id' => Periodicity::MONTHLY
        ]);

        // Act
        $transactionService->processUpcomingTransactions(Carbon::now());

        // Assert
        $this->assertTrue($upcomingTransaction->refresh()->date->isSameDay($expected_date));
    }

    public function test_recurring_transactions_are_correctly_deleted()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        Carbon::setTestNow($date->copy()->addDay());
        $transactionService = $this->app->make(TransactionService::class);
        $upcomingTransaction = UpcomingTransaction::factory()->create([
            'date' => $date,
            'original_date' => $date,
            'periodicity_id' => Periodicity::MONTHLY,
            'repeat_until' => $date
        ]);

        // Act
        $transactionService->processUpcomingTransactions(Carbon::now());

        // Assert
        $this->assertDatabaseMissing('upcoming_transactions', ['id' => $upcomingTransaction->id]);
    }
}
