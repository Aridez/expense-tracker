<?php

namespace Tests\Unit\Filters;

use App\Models\Periodicity;
use App\Models\UpcomingTransaction;
use App\Models\User;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessUpcomingTransactionsTest extends TestCase
{

    use RefreshDatabase;

    public function test_upcoming_transactions_are_correctly_rescheduled()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        $expected_date = Carbon::createFromDate(2020, 11, 1);
        Carbon::setTestNow($date->copy()->addDay());
        $upcomingTransaction = UpcomingTransaction::factory()->create([
            'date' => $date,
            'original_date' => $date,
            'periodicity_id' => Periodicity::MONTHLY
        ]);

        // Act
        $this->artisan('transactions:process')->assertExitCode(0);

        // Assert
        $this->assertTrue($upcomingTransaction->refresh()->date->isSameDay($expected_date));
    }

    public function test_date_parameter_is_correctly_processed()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        $expected_date = Carbon::createFromDate(2020, 11, 1);
        $upcomingTransaction = UpcomingTransaction::factory()->create([
            'date' => $date,
            'original_date' => $date,
            'periodicity_id' => Periodicity::MONTHLY
        ]);

        // Act
        $this->artisan('transactions:process --date=' . $date->copy()->addDay()->format('Y-m-d'))->assertExitCode(0);

        // Assert
        $this->assertTrue($upcomingTransaction->refresh()->date->isSameDay($expected_date));
    }
}
