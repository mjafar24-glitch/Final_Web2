<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class='bx bx-book-alt text-primary' style="font-size: 60px;"></i>
            </div>
            <div class="col-md-10">
                <h5 class="fw-bold mb-1">{{ $book->title }}</h5>
                <p class="text-muted mb-0">ISBN: <code>{{ $book->isbn }}</code> &bull; Penulis: {{ $book->author }}</p>
                <a href="{{ route('book.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                    <i class='bx bx-arrow-back'></i> Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-lg p-3">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a class="btn btn-primary" href="{{ route('book_copy.create', ['book_id' => $book->id]) }}" role="button">
                <i class='bx bx-plus'></i> Tambah Eksemplar
            </a>
            <span class="text-muted small">Total: {{ $copies->count() }} eksemplar</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode / Barcode</th>
                        <th scope="col">Lokasi Rak</th>
                        <th scope="col">Status</th>
                        <th scope="col">Kondisi</th>
                        <th scope="col" style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($copies as $copy)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $copy->copy_code }}</code></td>
                            <td>
                                @if($copy->location)
                                    Lt.{{ $copy->location->floor }} / Lrg.{{ $copy->location->aisle }} / Rak.{{ $copy->location->shelf_number }}
                                @else
                                    <span class="text-muted">Belum diset</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badge = 'bg-secondary';
                                    if ($copy->status == 'available') $badge = 'bg-success';
                                    elseif ($copy->status == 'borrowed') $badge = 'bg-warning text-dark';
                                    elseif ($copy->status == 'reserved') $badge = 'bg-info text-dark';
                                    elseif ($copy->status == 'lost' || $copy->status == 'damaged') $badge = 'bg-danger';
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($copy->status) }}</span>
                            </td>
                            <td>{{ $copy->condition ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                    <button type="button" class="btn btn-info btn-sm btn-detail"
                                        data-route="{{ route('book_copy.show', $copy) }}">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href="{{ route('book_copy.edit', $copy) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-route="{{ route('book_copy.destroy', $copy) }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Eksemplar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })

            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 500);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memuat data",
                            icon: "error"
                        });
                    }
                });
            })
        </script>
    @endpush

</x-app>
