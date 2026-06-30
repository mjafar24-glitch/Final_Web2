<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCopy;

class BookCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        foreach ($books as $book) {
            // Kita buat 2-4 eksemplar per buku
            $copyCount = rand(2, 4);

            for ($i = 1; $i <= $copyCount; $i++) {
                $status = 'available';
                // Peluang kecil untuk buku rusak/hilang (untuk laporan)
                if (rand(1, 100) <= 5) {
                    $status = rand(0, 1) ? 'lost' : 'damaged';
                }

                BookCopy::create([
                    'book_id' => $book->id,
                    'copy_code' => strtoupper(substr($book->title, 0, 3)) . '-' . str_pad($book->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'status' => $status,
                    'condition' => $status == 'damaged' ? 'Rusak ringan' : 'Baik',
                ]);
            }
        }
    }
}
