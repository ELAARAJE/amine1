<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\MenuCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        $allergensList = ['gluten', 'lactose', 'œufs', 'fruits à coque', 'soja', 'crustacés', 'poisson'];

        return [
            'menu_category_id' => MenuCategory::factory(),
            'name' => ucfirst(fake()->words(3, true)),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 8, 45),
            'allergens' => fake()->optional()->randomElements($allergensList, fake()->numberBetween(0, 3)),
            'position' => fake()->numberBetween(1, 20),
            'is_visible' => true,
        ];
    }
}
