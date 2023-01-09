<?php

namespace Database\Factories;

use App\Models\Periodicity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UpcomingTransaction>
 */
class UpcomingTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeBetween('+0 days', '+2 years');
        return [
            'date' => $date,
            'original_date' => $date,
            'description' => fake()->text(10),
            'amount' => fake()->randomFloat(2, -10000.00, 10000.00),
            'repeat_until'=> null,
            'periodicity_id' => Periodicity::MONTHLY,
            'user_id' => User::factory()->create()->id
        ];
    }
}
