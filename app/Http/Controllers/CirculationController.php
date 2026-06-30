<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BookCopy;
use App\Models\Member;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CirculationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'bookCopy.book', 'user', 'fine'])->latest()->get();

        return view('circulation.index', [
            'title' => 'Sirkulasi Peminjaman',
            'borrowings' => $borrowings,
            'members' => Member::where('is_active', true)->get(),
        ]);
    }

    /**
     * Process new borrowing.
     */
    public function borrow(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'copy_code' => 'required|exists:book_copies,copy_code',
        ]);

        $copy = BookCopy::where('copy_code', $request->copy_code)->first();

        if ($copy->status === 'reserved') {
            // Cek apakah member ini yang mereservasi
            $reservation = \App\Models\Reservation::where('allocated_copy_id', $copy->id)
                ->where('member_id', $request->member_id)
                ->where('status', 'pending')
                ->first();
                
            if (!$reservation) {
                return back()->withError("Buku dengan kode {$request->copy_code} sedang direservasi oleh anggota lain.");
            }
        } elseif ($copy->status !== 'available') {
            return back()->withError("Buku dengan kode {$request->copy_code} sedang tidak tersedia (Status: {$copy->status}).");
        }

        DB::beginTransaction();
        try {
            if (isset($reservation)) {
                $reservation->update(['status' => 'fulfilled']);
            }

            Borrowing::create([
                'member_id' => $request->member_id,
                'book_copy_id' => $copy->id,
                'user_id' => Auth::id(),
                'borrow_date' => Carbon::today(),
                'due_date' => Carbon::today()->addDays(7), // default 7 days limit
                'status' => 'borrowed',
            ]);

            $copy->update(['status' => 'borrowed']);

            DB::commit();
            return back()->withSuccess('Peminjaman berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Process book return and calculate fines.
     */
    public function returnBook(Request $request)
    {
        $request->validate([
            'return_copy_code' => 'required|exists:book_copies,copy_code',
        ]);

        $copy = BookCopy::where('copy_code', $request->return_copy_code)->first();

        // Find active borrowing for this copy
        $borrowing = Borrowing::where('book_copy_id', $copy->id)
            ->where('status', 'borrowed')
            ->first();

        if (!$borrowing) {
            return back()->withError("Tidak ditemukan data peminjaman aktif untuk kode buku {$request->return_copy_code}.");
        }

        DB::beginTransaction();
        try {
            $today = Carbon::today();
            $dueDate = Carbon::parse($borrowing->due_date);
            $lateDays = 0;
            $fineAmount = 0;

            if ($today->gt($dueDate)) {
                $lateDays = $today->diffInDays($dueDate);
                $fineAmount = $lateDays * 500; // Rp 500 per day

                // Create Fine record
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'amount' => $fineAmount,
                    'late_days' => $lateDays,
                    'payment_status' => 'unpaid',
                ]);
            }

            $borrowing->update([
                'return_date' => $today,
                'status' => 'returned',
            ]);

            // Cek apakah ada reservasi pending untuk buku ini
            $pendingReservation = \App\Models\Reservation::where('book_id', $copy->book_id)
                ->where('status', 'pending')
                ->whereNull('allocated_copy_id')
                ->orderBy('request_date', 'asc')
                ->first();

            if ($pendingReservation) {
                // Alokasikan ke reservasi pertama di antrean
                $pendingReservation->update([
                    'allocated_copy_id' => $copy->id,
                    'expiry_date' => $today->copy()->addDays(2),
                ]);
                $copy->update(['status' => 'reserved']);
                
                DB::commit();
                
                $msg = 'Buku berhasil dikembalikan.';
                if ($fineAmount > 0) {
                    $msg .= " Terlambat {$lateDays} hari. Denda: Rp " . number_format($fineAmount, 0, ',', '.') . ".";
                }
                $msg .= " Info: Buku ini langsung dialokasikan untuk reservasi member {$pendingReservation->member->name}.";

                return back()->withSuccess($msg);
            } else {
                $copy->update(['status' => 'available']);
            }

            DB::commit();

            $msg = 'Buku berhasil dikembalikan.';
            if ($fineAmount > 0) {
                $msg .= " Terlambat {$lateDays} hari. Denda: Rp " . number_format($fineAmount, 0, ',', '.');
            }

            return back()->withSuccess($msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
