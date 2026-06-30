<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\BookCopy;
use App\Exports\BorrowingExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function borrowing(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $borrowings = Borrowing::with(['member', 'bookCopy.book'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('report.borrowing', [
            'title' => 'Laporan Peminjaman',
            'borrowings' => $borrowings,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $filename = 'laporan_peminjaman_' . $startDate . '_sd_' . $endDate . '.xlsx';

        return Excel::download(new BorrowingExport($startDate, $endDate), $filename);
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $borrowings = Borrowing::with(['member', 'bookCopy.book'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->orderBy('borrow_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('report.borrowing_pdf', compact('borrowings', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan_peminjaman_' . $startDate . '_sd_' . $endDate . '.pdf';

        return $pdf->download($filename);
    }

    public function performance()
    {
        // Top 10 Books
        $topBooks = Book::withCount('bookCopies')
            ->withCount(['bookCopies as total_borrowed' => function ($query) {
                $query->join('borrowings', 'book_copies.id', '=', 'borrowings.book_copy_id');
            }])
            ->orderByDesc('total_borrowed')
            ->limit(10)
            ->get();

        // Lost or Damaged Copies
        $problematicCopies = BookCopy::with('book')
            ->whereIn('status', ['lost', 'damaged'])
            ->get();

        return view('report.performance', [
            'title' => 'Laporan Kinerja Buku',
            'topBooks' => $topBooks,
            'problematicCopies' => $problematicCopies,
        ]);
    }
}
