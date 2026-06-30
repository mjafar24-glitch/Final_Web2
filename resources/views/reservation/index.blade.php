<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Form Tambah Reservasi -->
    <div class="card shadow-lg p-3 mb-4">
        <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-bookmark-plus me-1'></i> Tambah Reservasi Baru</h5>
        <form action="{{ route('reservation.store') }}" method="post">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="member_id" class="form-label required">Anggota</label>
                    <select class="form-select select2-default" id="member_id" name="member_id" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->member_code }} - {{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="book_id" class="form-label required">Buku yang Direservasi</label>
                    <select class="form-select select2-default" id="book_id" name="book_id" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->author }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class='bx bx-bookmark-plus'></i> Reservasi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Reservasi -->
    <div class="card shadow-lg p-3">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Daftar Reservasi Buku</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Request</th>
                        <th>Batas Waktu Ambil</th>
                        <th>Status</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold">{{ $r->member->name }}</span><br>
                                <small class="text-muted">{{ $r->member->member_code }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $r->book->title }}</span><br>
                                @if($r->allocated_copy_id)
                                    <small class="text-muted">Dialokasikan: <code>{{ $r->allocatedCopy->copy_code }}</code></small>
                                @else
                                    <small class="text-warning"><i class='bx bx-time'></i> Menunggu buku tersedia</small>
                                @endif
                            </td>
                            <td>{{ $r->request_date->format('d M Y, H:i') }}</td>
                            <td>
                                @if($r->expiry_date)
                                    <span class="{{ $r->expiry_date->isPast() && $r->status == 'pending' ? 'text-danger fw-bold' : '' }}">
                                        {{ $r->expiry_date->format('d M Y, H:i') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $badge = 'bg-secondary';
                                    if ($r->status == 'pending') {
                                        $badge = $r->allocated_copy_id ? 'bg-primary' : 'bg-warning text-dark';
                                    } elseif ($r->status == 'fulfilled') {
                                        $badge = 'bg-success';
                                    } elseif ($r->status == 'expired' || $r->status == 'cancelled') {
                                        $badge = 'bg-danger';
                                    }
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($r->status) }}</span>
                                @if($r->status == 'pending' && $r->allocated_copy_id)
                                    <br><small class="text-muted">Siap Diambil</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($r->status == 'pending')
                                    <form action="{{ route('reservation.cancel', $r) }}" method="post" onsubmit="return confirm('Apakah Anda yakin membatalkan reservasi ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                            <i class='bx bx-x-circle'></i> Batal
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
