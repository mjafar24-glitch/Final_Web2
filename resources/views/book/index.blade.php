<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Advanced Search Card --}}
    <div class="card shadow-sm p-3 mb-3">
        <h6 class="fw-bold mb-2"><i class='bx bx-search-alt'></i> Pencarian Lanjutan</h6>
        <form action="{{ route('book.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label small mb-1">Cari (Judul / Penulis / ISBN / Penerbit)</label>
                <input type="text" class="form-control form-control-sm" id="search" name="search"
                    value="{{ request('search') }}" placeholder="Ketik kata kunci...">
            </div>
            <div class="col-md-3">
                <label for="category_id" class="form-label small mb-1">Kategori</label>
                <select class="form-select form-select-sm" id="category_id" name="category_id">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="year_published" class="form-label small mb-1">Tahun Terbit</label>
                <input type="number" class="form-control form-control-sm" id="year_published" name="year_published"
                    value="{{ request('year_published') }}" placeholder="Contoh: 2023" min="1000" max="{{ date('Y') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class='bx bx-search'></i> Cari
                </button>
                <a href="{{ route('book.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class='bx bx-reset'></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-3">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a class="btn btn-primary" href="{{ route('book.create') }}" role="button">
                <i class='bx bx-plus'></i> Tambah Buku
            </a>
            <span class="text-muted small">Total: {{ $books->count() }} buku</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun</th>
                        <th scope="col" style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $book->isbn }}</code></td>
                            <td class="text-start">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $book->category->name ?? '-' }}</span>
                            </td>
                            <td>{{ $book->publisher ?? '-' }}</td>
                            <td>{{ $book->year_published ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                    <a href="{{ route('book_copy.index', ['book_id' => $book->id]) }}" class="btn btn-success btn-sm" title="Manajemen Eksemplar">
                                        <i class='bx bx-copy'></i>
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm btn-detail"
                                        data-route="{{ route('book.show', $book) }}">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href="{{ route('book.edit', $book) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-route="{{ route('book.destroy', $book) }}">
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
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailModalLabel">Detail Buku</h1>
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
