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
            "name" => fake()->unique()->randomElement([
                'Alternate history',
                'Autobiography',
                'Anthology',
                'Biography',
                'Classic',
                'Cookbook',
                'Comic book',
                'Diary',
                'Dictionary',
                'Encyclopedia',
                'Drama',
                'Guide',
                'Fairytale',
                'Health/fitness',
                'Fantasy',
                'History',
                'Humor',
                'Horror',
                'Science'
            ])
        ];
    }
}
