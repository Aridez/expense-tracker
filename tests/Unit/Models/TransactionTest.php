<?php

namespace Tests\Unit\Filters;

use App\Filters\PaginationFilter;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase;

    public function test_transaction_pagination_filter()
    {
        // Arrange
        Transaction::factory()->count(20)->create();
        $request = new Request(['page' => 1, 'limit' => 10]);

        // Act
        $result = Transaction::filter(Transaction::query(), $request);

        // Assert
        $this->assertEquals(11, $result->count());
    }

}
