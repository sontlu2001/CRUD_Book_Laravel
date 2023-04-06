<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCategoryFactory extends Factory
{
    protected $table = BookCategory::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];

    }
}
