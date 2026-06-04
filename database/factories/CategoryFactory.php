<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'daily_profit_percent' => $this->faker->randomFloat(2, 1, 5),
            'duration_days' => $this->faker->numberBetween(30, 365),
            'is_active' => true,
            'display_order' => 0,
        ];
    }
}
