<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'time' => fake()->randomElement(['12:00', '12:30', '13:00', '13:30', '19:00', '19:30', '20:00', '20:30', '21:00']),
            'guests' => fake()->numberBetween(1, 8),
            'comment' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'rejected', 'cancelled']),
            'rejection_reason' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'pending']);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'confirmed']);
    }
}
