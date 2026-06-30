<?php

namespace App\Http\Controllers;

use App\Models\BookReview;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        // Cek apakah member ini pernah meminjam dan mengembalikan buku ini
        $hasBorrowed = Borrowing::where('member_id', $request->member_id)
            ->whereHas('bookCopy', function ($q) use ($request) {
                $q->where('book_id', $request->book_id);
            })
            ->where('status', 'returned')
            ->exists();

        if (!$hasBorrowed) {
            return back()->withError('Anggota ini tidak dapat memberikan ulasan karena belum pernah meminjam dan mengembalikan buku ini.');
        }

        // Cek apakah sudah pernah me-review buku ini
        $existingReview = BookReview::where('book_id', $request->book_id)
            ->where('member_id', $request->member_id)
            ->first();

        if ($existingReview) {
            return back()->withError('Anggota ini sudah pernah memberikan ulasan untuk buku ini.');
        }

        BookReview::create($request->only(['book_id', 'member_id', 'rating', 'review_text']));

        return back()->withSuccess('Ulasan berhasil ditambahkan.');
    }
}
