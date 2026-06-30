<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-map-pin text-primary' style="font-size: 80px;"></i>
        <h4 class="fw-bold mt-3">Lantai {{ $location->floor ?? '-' }}</h4>
        <span class="badge bg-primary fs-6">Lorong {{ $location->aisle ?? '-' }} &bull; Rak {{ $location->shelf_number ?? '-' }}</span>
        <div class="mt-3">
            <span class="badge bg-secondary">{{ $location->bookCopies->count() }} Eksemplar</span>
        </div>
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Daftar Buku di Lokasi Ini</h5>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse ($location->bookCopies as $copy)
                <div class="d-flex align-items-center mb-2 p-2 border rounded">
                    <i class='bx bx-book me-2 text-primary fs-5'></i>
                    <div>
                        <div class="fw-semibold">{{ $copy->book->title }}</div>
                        <small class="text-muted">Barcode: <code>{{ $copy->copy_code }}</code> &bull; Status: {{ ucfirst($copy->status) }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada eksemplar buku di lokasi ini.</p>
            @endforelse
        </div>
    </div>
</div>
