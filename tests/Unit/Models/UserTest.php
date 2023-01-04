<?php

namespace Tests\Unit\Filters;

use App\Filters\PaginationFilter;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_transactions_relationship()
    {
        // Arrange
        $user = User::factory()->create();
        Transaction::factory()->count(20)->create();
        Transaction::factory()->count(20)->create(['user_id' => $user->id]);

        // Act
        $result = $user->transactions;

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(20, $result->count());
    }

}
