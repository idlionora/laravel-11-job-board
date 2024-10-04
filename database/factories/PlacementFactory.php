<?php

namespace Database\Factories;

use App\Models\Placement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Placement>
 */
class PlacementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
            'description' => fake()->paragraphs(3, true),
            'salary' => fake()->numberBetween(5_000, 150_000),
            'location' => fake()->city,
            'category' => fake()->randomElement(Placement::$category),
            'experience' => fake()->randomElement(Placement::$experience)
        ];
    }
}
