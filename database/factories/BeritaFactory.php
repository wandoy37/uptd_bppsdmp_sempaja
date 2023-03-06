<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->sentence(),
            'thumbnail' => 'none-thumbnail',
            'status' => $this->faker->randomElement(['publish', 'draft']),
            'author_id' => 1,
            'category_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
