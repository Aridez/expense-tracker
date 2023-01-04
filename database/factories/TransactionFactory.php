<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => fake()->text(10),
            'date' => fake()->date(),
            'amount' => fake()->randomFloat(2, -10000.00, 10000.00),
            'user_id' => User::factory()->create()->id
        ];
    }
}
