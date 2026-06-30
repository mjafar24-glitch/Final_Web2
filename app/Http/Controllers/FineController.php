<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fine.index', [
            'title' => 'Data Denda',
            'fines' => Fine::with(['borrowing.member', 'borrowing.bookCopy.book'])->latest()->get(),
        ]);
    }

    /**
     * Process fine payment.
     */
    public function pay(Fine $fine)
    {
        if ($fine->payment_status === 'paid') {
            return back()->withError('Denda ini sudah lunas sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $fine->update(['payment_status' => 'paid']);
            DB::commit();
            return back()->withSuccess('Pembayaran denda berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
