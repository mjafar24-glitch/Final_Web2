<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index()
    {
        return view('reservation.index', [
            'title' => 'Daftar Reservasi',
            'reservations' => Reservation::with(['member', 'book', 'allocatedCopy'])->latest()->get(),
            'members' => Member::where('is_active', true)->get(),
            'books' => Book::orderBy('title')->get(),
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
        ]);

        // Check if there are available copies first
        $book = Book::with('bookCopies')->findOrFail($request->book_id);
        $availableCopy = $book->bookCopies()->where('status', 'available')->first();

        DB::beginTransaction();
        try {
            if ($availableCopy) {
                // If a copy is available immediately, allocate it
                Reservation::create([
                    'member_id' => $request->member_id,
                    'book_id' => $request->book_id,
                    'allocated_copy_id' => $availableCopy->id,
                    'request_date' => Carbon::now(),
                    'expiry_date' => Carbon::now()->addDays(2),
                    'status' => 'pending',
                ]);
                $availableCopy->update(['status' => 'reserved']);
                
                DB::commit();
                return back()->withSuccess('Buku saat ini tersedia dan langsung dialokasikan. Silakan minta anggota untuk segera mengambil buku dalam 2 hari.');
            } else {
                // Wait in queue
                Reservation::create([
                    'member_id' => $request->member_id,
                    'book_id' => $request->book_id,
                    'request_date' => Carbon::now(),
                    'status' => 'pending',
                ]);

                DB::commit();
                return back()->withSuccess('Reservasi berhasil masuk antrean. Sistem akan mengalokasikan buku jika ada yang mengembalikan.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return back()->withError('Hanya reservasi berstatus pending yang dapat dibatalkan.');
        }

        DB::beginTransaction();
        try {
            if ($reservation->allocated_copy_id) {
                $reservation->allocatedCopy->update(['status' => 'available']);
            }
            $reservation->update(['status' => 'cancelled']);
            DB::commit();
            
            return back()->withSuccess('Reservasi berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal membatalkan: ' . $e->getMessage());
        }
    }
}
