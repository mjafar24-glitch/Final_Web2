<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000080;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #000080;
        }
        .header p {
            margin: 4px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #000080;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        td {
            padding: 5px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        .badge-success { background: #198754; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman Buku</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        <p>Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tgl Pinjam</th>
                <th>Batas</th>
                <th>Tgl Kembali</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowings as $index => $b)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $b->borrowing_code }}</td>
                    <td>{{ $b->borrow_date->format('d/m/Y') }}</td>
                    <td>{{ $b->due_date->format('d/m/Y') }}</td>
                    <td>{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $b->member->name }}</td>
                    <td>{{ $b->bookCopy->book->title }}</td>
                    <td>
                        @if ($b->status == 'returned')
                            <span class="badge badge-success">Dikembalikan</span>
                        @elseif ($b->status == 'borrowed')
                            <span class="badge badge-warning">Dipinjam</span>
                        @else
                            <span class="badge badge-danger">Hilang</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total: {{ $borrowings->count() }} data peminjaman
    </div>
</body>
</html>
