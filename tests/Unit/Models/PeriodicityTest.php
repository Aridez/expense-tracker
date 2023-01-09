<?php

namespace Tests\Unit\Filters;

use App\Models\Periodicity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriodicityTest extends TestCase
{

    use RefreshDatabase;

    public function test_find_next_future_date_with_daily_periodicity()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 1);
        $current_date = Carbon::createFromDate(2020, 2, 1);
        $expected_date = Carbon::createFromDate(2020, 2, 2);
        $periodicity = Periodicity::find(Periodicity::DAILY);
        Carbon::setTestNow();

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_weekly_periodicity()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 1);
        $current_date = Carbon::createFromDate(2020, 2, 3);
        $expected_date = Carbon::createFromDate(2020, 2, 9);
        $periodicity = Periodicity::find(Periodicity::WEEKLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_monthly_periodicity_jumping_month()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 31);
        $current_date = Carbon::createFromDate(2020, 1, 31);
        $expected_date = Carbon::createFromDate(2020, 2, 29);
        $periodicity = Periodicity::find(Periodicity::MONTHLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_monthly_periodicity_without_jumping_month()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 13);
        $current_date = Carbon::createFromDate(2020, 1, 4);
        $expected_date = Carbon::createFromDate(2020, 1, 13);
        $periodicity = Periodicity::find(Periodicity::MONTHLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_monthly_periodicity_jumping_month_without_overflow()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 30);
        $current_date = Carbon::createFromDate(2020, 1, 31);
        $expected_date = Carbon::createFromDate(2020, 2, 29);
        $periodicity = Periodicity::find(Periodicity::MONTHLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_yearly_periodicity_jumping_years()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 1, 30);
        $current_date = Carbon::createFromDate(2020, 5, 31);
        $expected_date = Carbon::createFromDate(2021, 1, 30);
        $periodicity = Periodicity::find(Periodicity::YEARLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

    public function test_find_next_future_date_with_yearly_periodicity_without_jumping_years()
    {
        // Arrange
        $original_date = Carbon::createFromDate(2017, 8, 30);
        $current_date = Carbon::createFromDate(2020, 5, 31);
        $expected_date = Carbon::createFromDate(2020, 8, 30);
        $periodicity = Periodicity::find(Periodicity::YEARLY);

        // Act
        $result = $periodicity->findNextDate($current_date, $original_date);

        // Assert
        $this->assertTrue($expected_date->isSameDay($result));
    }

}
