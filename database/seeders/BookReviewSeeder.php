<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\BookReview;
use App\Models\BookCopy;
use App\Models\Book;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all returned borrowings
        $returnedBorrowings = Borrowing::where('status', 'returned')->get();
        
        $reviewedCombos = [];

        foreach ($returnedBorrowings as $borrowing) {
            $bookCopy = BookCopy::find($borrowing->book_copy_id);
            if (!$bookCopy) continue;
            
            $bookId = $bookCopy->book_id;
            $memberId = $borrowing->member_id;
            
            $comboKey = $bookId . '_' . $memberId;

            // Prevent duplicate reviews for the same book by the same member
            if (!in_array($comboKey, $reviewedCombos)) {
                // 50% chance they leave a review
                if (rand(0, 1)) {
                    BookReview::factory()->create([
                        'book_id' => $bookId,
                        'member_id' => $memberId,
                        // If they returned late, maybe lower rating?
                        'rating' => $borrowing->fine()->exists() ? rand(1, 3) : rand(3, 5),
                    ]);
                    $reviewedCombos[] = $comboKey;
                }
            }
        }
    }
}
