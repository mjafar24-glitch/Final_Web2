<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a class="btn btn-primary" href="{{ route('location.create') }}" role="button">
                <i class='bx bx-plus'></i> Tambah Lokasi
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Lantai</th>
                        <th scope="col">Lorong</th>
                        <th scope="col">Nomor Rak</th>
                        <th scope="col">Total Buku</th>
                        <th scope="col" style="width: 110px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $location->floor ?? '-' }}</td>
                            <td>{{ $location->aisle ?? '-' }}</td>
                            <td>{{ $location->shelf_number ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $location->book_copies_count }} Buku</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                    <button type="button" class="btn btn-info btn-sm btn-detail"
                                        data-route="{{ route('location.show', $location) }}">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href="{{ route('location.edit', $location) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-route="{{ route('location.destroy', $location) }}">
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Lokasi</h1>
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
