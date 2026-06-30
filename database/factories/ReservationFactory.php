<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Member;
use App\Models\Book;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::inRandomOrder()->first()?->id ?? 1,
            'book_id' => Book::inRandomOrder()->first()?->id ?? 1,
            'allocated_copy_id' => null,
            'request_date' => Carbon::now()->subDays(rand(1, 10)),
            'expiry_date' => null,
            'status' => 'pending',
        ];
    }
}
