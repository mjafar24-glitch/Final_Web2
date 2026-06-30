<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? 1,
            'isbn' => $this->faker->unique()->isbn13(),
            'title' => $this->faker->sentence(rand(2, 5)),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'year_published' => $this->faker->numberBetween(2000, 2026),
        ];
    }
}
