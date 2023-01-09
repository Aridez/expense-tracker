<?php

namespace Tests\Unit\Filters;

use App\Filters\OrderByFilter;
use App\Filters\PaginationFilter;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderByFilterTest extends TestCase
{

    use RefreshDatabase;

    public function test_order_by_filter()
    {
        // Arrange
        $filter = new OrderByFilter('date', 'desc');
        $date = Carbon::now();
        $first = Transaction::factory()->create(['date' => $date]);
        Transaction::factory()->count(2)->create(['date' => $date->subDay()]);

        // Act
        $result = $filter->handle(Transaction::query(), function ($query) {
            return $query;
        });

        // Assert
        $this->assertTrue($result->get()[0]->is($first));
    }

}
