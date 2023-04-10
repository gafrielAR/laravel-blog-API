<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence($nbWords = 6, $variableNbWords = true),
            'content' => fake()->realText($maxNbChars = 200, $indexSize = 2),
            'user_id' => User::factory(),
            'category_id' => Category::factory()
        ];
    }
}
