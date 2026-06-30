<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Daftar Tagihan Denda</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku (Eksemplar)</th>
                        <th>Keterlambatan</th>
                        <th>Nominal Denda</th>
                        <th>Status Pembayaran</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fines as $fine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold">{{ $fine->borrowing->member->name }}</span><br>
                                <small class="text-muted">{{ $fine->borrowing->member->member_code }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $fine->borrowing->bookCopy->book->title ?? '-' }}</span><br>
                                <small class="text-muted">{{ $fine->borrowing->bookCopy->copy_code ?? '-' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger rounded-pill">{{ $fine->late_days }} Hari</span>
                            </td>
                            <td class="fw-bold text-danger">
                                Rp {{ number_format($fine->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($fine->payment_status == 'paid')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($fine->payment_status == 'unpaid')
                                    <form action="{{ route('fine.pay', $fine) }}" method="post" onsubmit="return confirm('Apakah Anda yakin denda ini sudah dibayar lunas oleh anggota?');">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class='bx bx-check-double'></i> Lunasi
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class='bx bx-check'></i> Selesai
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
