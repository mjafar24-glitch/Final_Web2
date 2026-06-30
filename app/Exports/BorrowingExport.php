<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BorrowingExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return Borrowing::with(['member', 'bookCopy.book'])
            ->whereBetween('borrow_date', [$this->startDate, $this->endDate])
            ->orderBy('borrow_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Peminjaman',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Tanggal Kembali',
            'Nama Peminjam',
            'Kode Anggota',
            'Judul Buku',
            'Kode Eksemplar',
            'Status',
        ];
    }

    public function map($borrowing): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $borrowing->borrowing_code,
            $borrowing->borrow_date->format('d/m/Y'),
            $borrowing->due_date->format('d/m/Y'),
            $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-',
            $borrowing->member->name,
            $borrowing->member->member_code,
            $borrowing->bookCopy->book->title,
            $borrowing->bookCopy->copy_code,
            $borrowing->status == 'returned' ? 'Dikembalikan' : ($borrowing->status == 'borrowed' ? 'Dipinjam' : 'Hilang'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
