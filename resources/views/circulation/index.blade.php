<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg p-0">
                <div class="card-header bg-white border-bottom p-0">
                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold p-3 active" id="borrow-tab" data-bs-toggle="tab" data-bs-target="#borrow-tab-pane" type="button" role="tab" aria-controls="borrow-tab-pane" aria-selected="true">
                                <i class='bx bx-log-out-circle me-1'></i> Peminjaman Baru
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold p-3" id="return-tab" data-bs-toggle="tab" data-bs-target="#return-tab-pane" type="button" role="tab" aria-controls="return-tab-pane" aria-selected="false">
                                <i class='bx bx-log-in-circle me-1'></i> Pengembalian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold p-3" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">
                                <i class='bx bx-history me-1'></i> Riwayat Transaksi
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        
                        <!-- TAB PEMINJAMAN -->
                        <div class="tab-pane fade show active p-3" id="borrow-tab-pane" role="tabpanel" aria-labelledby="borrow-tab" tabindex="0">
                            <h5 class="fw-bold mb-4">Proses Peminjaman Buku</h5>
                            <form action="{{ route('circulation.borrow') }}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="member_id" class="form-label required">Anggota (Peminjam)</label>
                                            <select class="form-select select2-default" id="member_id" name="member_id" required>
                                                <option value="">-- Pilih Anggota --</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->member_code }} - {{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="copy_code" class="form-label required">Barcode / Kode Eksemplar</label>
                                            <input type="text" class="form-control form-control-lg" id="copy_code" name="copy_code" required placeholder="Scan barcode atau ketik manual..." autocomplete="off">
                                            <small class="text-muted">Pastikan status buku sedang 'Available'</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class='bx bx-check-circle'></i> Proses Pinjam
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB PENGEMBALIAN -->
                        <div class="tab-pane fade p-3" id="return-tab-pane" role="tabpanel" aria-labelledby="return-tab" tabindex="0">
                            <h5 class="fw-bold mb-4">Proses Pengembalian Buku</h5>
                            <form action="{{ route('circulation.return') }}" method="post">
                                @csrf
                                <div class="row g-3 justify-content-center">
                                    <div class="col-md-8 text-center">
                                        <div class="mb-3">
                                            <label for="return_copy_code" class="form-label required fw-bold fs-5">Scan Barcode Buku</label>
                                            <input type="text" class="form-control form-control-lg text-center fs-3 py-3 shadow-sm" id="return_copy_code" name="return_copy_code" required placeholder="CPY-XXXXXX" autocomplete="off" autofocus>
                                            <small class="text-muted mt-2 d-block">Sistem akan otomatis menghitung denda jika terlambat.</small>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-lg px-5 mt-3">
                                            <i class='bx bx-down-arrow-circle'></i> Proses Kembalikan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- TAB RIWAYAT TRANSAKSI -->
                        <div class="tab-pane fade p-3" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped w-100" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Peminjam</th>
                                            <th>Buku</th>
                                            <th>Tgl Pinjam</th>
                                            <th>Batas Kembali</th>
                                            <th>Status</th>
                                            <th>Denda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($borrowings as $b)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="fw-semibold">{{ $b->member->name }}</span><br>
                                                    <small class="text-muted">{{ $b->member->member_code }}</small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ $b->bookCopy->book->title ?? '-' }}</span><br>
                                                    <small class="text-muted">{{ $b->bookCopy->copy_code ?? '-' }}</small>
                                                </td>
                                                <td>{{ $b->borrow_date->format('d/m/Y') }}</td>
                                                <td>{{ $b->due_date->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($b->status == 'borrowed')
                                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                                    @else
                                                        <span class="badge bg-success">Dikembalikan</span><br>
                                                        <small class="text-muted">{{ $b->return_date->format('d/m/Y') }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($b->fine)
                                                        <span class="text-danger fw-bold">Rp {{ number_format($b->fine->amount, 0, ',', '.') }}</span>
                                                        @if($b->fine->payment_status == 'paid')
                                                            <span class="badge bg-success mt-1 d-block">Lunas</span>
                                                        @else
                                                            <span class="badge bg-danger mt-1 d-block">Belum Lunas</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Fokus otomatis ke input barcode pengembalian saat tab pengembalian diklik
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                if(e.target.id === 'return-tab') {
                    $('#return_copy_code').focus();
                } else if(e.target.id === 'borrow-tab') {
                    $('#copy_code').focus();
                }
            });
        </script>
    @endpush
</x-app>
