<?php

namespace Database\Factories;

use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Location;
use Illuminate\Support\Str;

/**
 * @extends Factory<BookCopy>
 */
class BookCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first()?->id ?? 1,
            'location_id' => Location::inRandomOrder()->first()?->id ?? 1,
            'copy_code' => 'CPY-' . strtoupper(Str::random(8)),
            'status' => $this->faker->randomElement(['available', 'available', 'borrowed', 'reserved', 'lost', 'damaged']),
            'condition' => $this->faker->randomElement(['Baru', 'Baik', 'Kusam', 'Sedikit Rusak']),
        ];
    }
}
