<?php

namespace Tests\Unit\Filters;

use App\Filters\PaginationFilter;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginationFilterTest extends TestCase
{

    use RefreshDatabase;

    public function test_pagination_filter_with_next_page()
    {
        // Arrange
        $filter = new PaginationFilter(1, 10);
        Transaction::factory()->count(20)->create();

        // Act
        $result = $filter->handle(Transaction::query(), function ($query) {
            return $query;
        });

        // Assert
        $this->assertEquals(11, $result->get()->count());
    }

    public function test_pagination_filter_without_next_page()
    {
        // Arrange
        $filter = new PaginationFilter(2, 10);
        Transaction::factory()->count(20)->create();

        // Act
        $result = $filter->handle(Transaction::query(), function ($query) {
            return $query;
        });

        // Assert
        $this->assertEquals(10, $result->get()->count());
    }
}
