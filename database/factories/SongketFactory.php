<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Songket>
 */
class SongketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Songket ' . fake()->unique()->words(3, true);
        $colors = ['#FFD700', '#C0C0C0', '#8B0000', '#000080', '#006400', '#800080', '#4B0082', '#8B4513'];

        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(3, true),
            'base_price' => fake()->numberBetween(500000, 5000000),
            'colors' => fake()->randomElements($colors, fake()->numberBetween(2, 4)),
            'images' => [
                '/placeholder.svg?height=600&width=600',
                '/placeholder.svg?height=600&width=600',
                '/placeholder.svg?height=600&width=600',
            ],
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'is_active' => fake()->boolean(95), // 95% chance of being active
            'stock_quantity' => fake()->numberBetween(0, 50),
        ];
    }

    /**
     * Indicate that the songket should be featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the songket should be active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the songket should be out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'stock_quantity' => 0,
        ]);
    }
}
