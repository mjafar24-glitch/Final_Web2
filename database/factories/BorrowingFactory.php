<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\BookCopy;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowDate = $this->faker->dateTimeBetween('-2 months', 'now');
        $dueDate = (clone $borrowDate)->modify('+7 days');
        
        return [
            'member_id' => Member::inRandomOrder()->first()?->id ?? 1,
            'book_copy_id' => BookCopy::inRandomOrder()->first()?->id ?? 1,
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'return_date' => null,
            'status' => 'borrowed',
        ];
    }
}
