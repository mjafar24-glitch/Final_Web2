<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <form action="{{ route('report.borrowing') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}" required>
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class='bx bx-filter-alt'></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('report.borrowing.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success w-100">
                    <i class='bx bx-file'></i> Export Excel
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('report.borrowing.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-danger w-100">
                    <i class='bx bxs-file-pdf'></i> Export PDF
                </a>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-3">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Data Peminjaman ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Peminjaman</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Peminjam</th>
                        <th>Buku (Eksemplar)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowings as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $b->borrowing_code }}</span></td>
                            <td>{{ $b->borrow_date->format('d M Y') }}</td>
                            <td>{{ $b->due_date->format('d M Y') }}</td>
                            <td>
                                {{ $b->member->name }} <br>
                                <small class="text-muted">{{ $b->member->member_code }}</small>
                            </td>
                            <td>
                                {{ $b->bookCopy->book->title }} <br>
                                <small class="text-muted"><code>{{ $b->bookCopy->copy_code }}</code></small>
                            </td>
                            <td>
                                @if ($b->status == 'borrowed')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @elseif ($b->status == 'returned')
                                    <span class="badge bg-success">Dikembalikan</span><br>
                                    <small class="text-muted">{{ $b->return_date->format('d/m/Y') }}</small>
                                @else
                                    <span class="badge bg-danger">Hilang</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
