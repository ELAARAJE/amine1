<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->words(4, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title) . '-' . fake()->unique()->randomNumber(4),
            'description' => fake()->paragraphs(2, true),
            'image' => null,
            'starts_at' => fake()->dateTimeBetween('now', '+6 months'),
            'price' => fake()->optional()->randomFloat(2, 30, 120),
            'is_published' => fake()->boolean(70),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => ['is_published' => true]);
    }
}
