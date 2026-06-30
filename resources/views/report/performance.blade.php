<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Top 10 Books -->
        <div class="col-lg-7">
            <div class="card shadow-lg p-3 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-primary"><i class='bx bx-trophy'></i> Top 10 Buku Paling Sering Dipinjam</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Peringkat</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Total Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topBooks as $index => $book)
                                <tr>
                                    <td class="text-center fw-bold">
                                        @if($index == 0)
                                            <i class='bx bxs-trophy text-warning fs-4'></i> 1
                                        @elseif($index == 1)
                                            <i class='bx bxs-trophy text-secondary fs-4'></i> 2
                                        @elseif($index == 2)
                                            <i class='bx bxs-trophy" style="color: #cd7f32" fs-4'></i> 3
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td class="text-center h5">
                                        <span class="badge bg-primary rounded-pill">{{ $book->total_borrowed }}x</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada riwayat peminjaman buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Problematic Books -->
        <div class="col-lg-5">
            <div class="card shadow-lg p-3">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-danger"><i class='bx bx-error'></i> Laporan Eksemplar Bermasalah (Rusak/Hilang)</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Kode Eksemplar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($problematicCopies as $copy)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $copy->book->title }}</span>
                                    </td>
                                    <td><code>{{ $copy->copy_code }}</code></td>
                                    <td>
                                        @if($copy->status == 'lost')
                                            <span class="badge bg-danger">Hilang</span>
                                        @elseif($copy->status == 'damaged')
                                            <span class="badge bg-warning text-dark">Rusak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada eksemplar buku yang hilang atau rusak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app>
