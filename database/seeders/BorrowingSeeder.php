<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\BookCopy;
use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $copies = BookCopy::where('status', 'available')->inRandomOrder()->limit(30)->get();
        if ($copies->isEmpty()) return;

        // 10 Active Borrowings (Not returned yet)
        for ($i = 0; $i < 10; $i++) {
            if (!isset($copies[$i])) break;
            
            $borrowing = Borrowing::factory()->create([
                'book_copy_id' => $copies[$i]->id,
                'status' => 'borrowed',
            ]);
            $copies[$i]->update(['status' => 'borrowed']);
        }

        // 10 Returned on time
        for ($i = 10; $i < 20; $i++) {
            if (!isset($copies[$i])) break;
            
            $borrowDate = Carbon::now()->subDays(rand(10, 30));
            $dueDate = (clone $borrowDate)->addDays(7);
            $returnDate = (clone $borrowDate)->addDays(rand(2, 6)); // Returned before due
            
            Borrowing::factory()->create([
                'book_copy_id' => $copies[$i]->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => $returnDate,
                'status' => 'returned',
            ]);
            // Status remains available
        }

        // 10 Returned late (with fines)
        for ($i = 20; $i < 30; $i++) {
            if (!isset($copies[$i])) break;
            
            $borrowDate = Carbon::now()->subDays(rand(20, 40));
            $dueDate = (clone $borrowDate)->addDays(7);
            $lateDays = rand(2, 10);
            $returnDate = (clone $dueDate)->addDays($lateDays); // Returned late
            
            $borrowing = Borrowing::factory()->create([
                'book_copy_id' => $copies[$i]->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => $returnDate,
                'status' => 'returned',
            ]);
            
            // Generate Fine
            Fine::factory()->create([
                'borrowing_id' => $borrowing->id,
                'amount' => $lateDays * 500, // Rp 500 per day
                'late_days' => $lateDays,
                'payment_status' => rand(0, 1) ? 'paid' : 'unpaid',
            ]);
        }
    }
}
