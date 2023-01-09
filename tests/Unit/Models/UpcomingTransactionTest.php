<?php

namespace Tests\Unit\Filters;

use App\Filters\PaginationFilter;
use App\Models\Periodicity;
use App\Models\Transaction;
use App\Models\UpcomingTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UpcomingTransactionTest extends TestCase
{

    use RefreshDatabase;

    public function test_periodicity_relationship()
    {
        // Arrange
        $upcoming_transaction = UpcomingTransaction::factory()->create(['periodicity_id' => Periodicity::NONE]);

        // Act
        $periodicity = $upcoming_transaction->periodicity;

        // Assert
        $this->assertInstanceOf(Periodicity::class, $periodicity);
        $this->assertTrue($periodicity->is(Periodicity::find(Periodicity::NONE)));
    }


    public function test_upcoming_transactions_are_correctly_limited_by_no_periodicity()
    {
        // Arrange
        $upcoming_transaction = UpcomingTransaction::factory()->create(['periodicity_id' => Periodicity::NONE]);

        // Act
        $upcoming_transaction->reschedule();

        // Assert
        $this->assertDatabaseEmpty('upcoming_transactions');
    }

    public function test_upcoming_transactions_are_correctly_limited_by_repeat_until()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        Carbon::setTestNow($date);
        $upcoming_transaction = UpcomingTransaction::factory()->create(['periodicity_id' => Periodicity::MONTHLY, 'repeat_until' => Carbon::createFromDate(2020, 10, 15)]);

        // Act
        $upcoming_transaction->reschedule();

        // Assert
        $this->assertDatabaseEmpty('upcoming_transactions');
    }

    public function test_upcoming_transactions_are_correctly_rescheduled()
    {
        // Arrange
        $date = Carbon::createFromDate(2020, 10, 1);
        $expected_date = Carbon::createFromDate(2020, 11, 1);
        Carbon::setTestNow($date);
        $upcoming_transaction = UpcomingTransaction::factory()->create(['date' => $date, 'original_date' => $date, 'periodicity_id' => Periodicity::MONTHLY]);

        // Act
        $upcoming_transaction->reschedule();

        // Assert
        $this->assertEquals($expected_date->format('Y-m-d'), $upcoming_transaction->refresh()->date->format('Y-m-d'));
    }
}
